<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Transaction;
use App\PaymentProviders\PSP\Payir;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function callbackPayir(Request $request)
    {
        $rules = [
            'id' => 'required|exists:fp_transactions,id',
            'token' => 'required',
            'status' => 'required|numeric|in:0,1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            abort(404);
        }

        try {
            DB::beginTransaction();
            $transaction = Transaction::lockForUpdate()->find($request->id);
            if ($transaction) {
                if ($transaction->status && $transaction->verified) {
                    return $this->showReceipt($transaction);
                } else if (!$transaction->status && !$transaction->verified && isset($transaction->payment_info['token']) && $transaction->payment_info['token'] == $request->token) {
                    $paymentProvider = new Payir();
                    $verify = $paymentProvider->verify($request->token);
                    if ($verify && isset($verify['status']) && isset($verify['amount']) && isset($verify['transId']) && isset($verify['cardNumber'])) {
                        if ($verify['status'] == 1 && $verify['amount'] == $transaction->amount) {
                            $transaction->update([
                                'payment_info' => [
                                    'token' => $request->token,
                                    'trans_id' => $verify['transId'],
                                    'card_number' => $verify['cardNumber'],
                                    'status' => $verify['status'],
                                ],
                                'status' => 1,
                                'verified' => 1,
                                'paid_at' => date('Y-m-d H:i:s'),
                                'verified_at' => date('Y-m-d H:i:s'),
                            ]);
                            switch ($transaction->type) {
                                case Transaction::$type['form']:
                                    $transaction->form()->update(['pay_count' => $transaction->form()->pay_count + 1]);
                                    break;
                                case Transaction::$type['file']:
                                    $transaction->file()->update(['pay_count' => $transaction->file()->pay_count + 1]);
                                    break;
                                case Transaction::$type['factor']:
                                    $transaction->factor()->update([
                                        'paid' => 1,
                                        'transaction_id' => $transaction->id,
                                    ]);
                                    break;
                            }
                            \DB::commit();

                            $this->sendMail($transaction);

                            return $this->showReceipt($transaction);
                        }
                    }
                }
            }
            DB::rollBack();

            return $this->showReceipt($transaction);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function pay(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $rules = [
            'id' => 'required|exists:fp_transactions,id,status,0,verified,0',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            abort(404);
        }

        $transaction = Transaction::find($id);

        return $this->payWithPayir($transaction);
    }

    /**
     * @param Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function payWithPayir(Transaction $transaction)
    {
        $paymentProvider = new Payir();
        $paymentInfo = $paymentProvider->send($transaction->amount, $transaction->id);
        if (isset($paymentProvider->paymentUrl) && $paymentProvider->paymentUrl) {
            $transaction->update([
                'payment_info' => [
                    'token' => $paymentInfo['token'],
                ],
            ]);

            return redirect($paymentProvider->paymentUrl);
        }

        return redirect()->back()
            ->with('alert', 'danger')
            ->with('message', isset($paymentProvider->errorMessage) ? $paymentProvider->errorMessage : 'Error');
    }

    /**
     * @param Transaction $transaction
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function showReceipt(Transaction $transaction)
    {
        return view('fp::home.receipt')
            ->with('transaction', $transaction);
    }

    /**
     * @param Transaction $transaction
     * @throws \Exception
     */
    private function sendMail(Transaction $transaction)
    {
        $user = User::first();
        if ($user) {
            try {
                Mail::send('emails.transaction', ['user' => $user, 'transaction' => $transaction], function ($m) use ($user) {
                    $m->to($user->email, $user->name)->subject(lang('lang.new_transaction'));
                });
            } catch (\Exception $e) {
                if (app('site_configs')['APP_ENV'] === 'local') {
                    throw $e;
                }
            }
        }
    }
}
