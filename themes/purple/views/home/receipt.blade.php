@extends('fp::layouts.home')

@section('page-title')
    {{ lang('lang.payment_receipt') }}
@endsection

@section('content')
    <div class="container-contact100">
        <div class="wrap-contact100">
            <p class="contact100-form">
                @if($transaction && $transaction->status && $transaction->verified)
                    <span class="contact100-form-title">
                        {{ lang('lang.receipt') }}
                    </span>
            <div class="table-responsive">
                <table class="table table-bordered text-center" style="table-layout: fixed;">
                    <tbody>
                        <tr>
                            <td>
                                {{ lang('lang.id') }}
                            </td>
                            <td>{{ $transaction->id }}</td>
                        </tr>
                        <tr>
                            <td>
                                {{ lang('lang.amount') }}
                            </td>
                            <td>{{ custom_money_format($transaction->amount) }}</td>
                        </tr>
                        <tr>
                            <td>
                                {{ lang('lang.status') }}
                            </td>
                            <td>{{ $transaction->status ? lang('lang.success') : lang('lang.failed') }}</td>
                        </tr>
                        <tr>
                            <td>
                                {{ lang('lang.payir_transaction_id') }}
                            </td>
                            <td>{{ $transaction->payment_info['trans_id'] }}</td>
                        </tr>
                        <tr>
                            <td>
                                {{ lang('lang.card_number') }}
                            </td>
                            <td style="direction: ltr">
                                <span>{{ $transaction->payment_info['card_number'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ lang('lang.date') }}
                            </td>
                            <td>{{ $transaction->full_jalali_created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
                <span class="contact100-form-title">
                    {{ lang('lang.transaction_failed') }}
                </span>
                @if($transaction)
                    <div class="container-contact100-form-btn">
                        <div class="wrap-contact100-form-btn">
                            <div class="contact100-form-bgbtn"></div>
                            <a class="contact100-form-btn" href="{{ route('pg-pay', ['id' => $transaction->id]) }}">
                                <span>
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    {{ lang('lang.repay') }}
                                </span>
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    </div>
@endsection
