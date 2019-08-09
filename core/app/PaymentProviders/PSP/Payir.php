<?php

namespace App\PaymentProviders\PSP;

class Payir
{
    protected $apiKey;
    public $paymentUrl;
    public $errorCode;
    public $errorMessage;

    /**
     * Payir constructor.
     */
    public function __construct()
    {
        $this->apiKey = site_config('payir_api_key') ? site_config('payir_api_key') : 'test';
    }

    /**
     * @param $amount
     * @param null $mobile
     * @param null $factorNumber
     * @param null $description
     * @return mixed
     */
    public function send($amount, $factorNumber, $mobile = null, $description = null)
    {
        $result = curl_post('https://pay.ir/pg/send', [
            'api' => $this->apiKey,
            'amount' => $amount,
            'mobile' => $mobile,
            'factorNumber' => $factorNumber,
            'description' => $description,
            'resellerId' => '1000000012',
            'redirect' => route('pg-callback-payir', ['id' => $factorNumber]),
        ]);
        $result = json_decode($result, true);
        if (isset($result['token'])) {
            $this->paymentUrl = 'https://pay.ir/pg/' . $result['token'];
        }
        if (isset($result['errorCode'])) {
            $this->errorCode = $result['errorCode'];
        }
        if (isset($result['errorMessage'])) {
            $this->errorMessage = $result['errorMessage'];
        }
        
        return $result;
    }
    
    /**
     * @param $token
     * @return mixed
     */
    public function verify($token)
    {
        $result = curl_post('https://pay.ir/pg/verify', [
            'api'   => $this->apiKey,
            'token' => $token,
        ]);
        $result = json_decode($result, true);
        
        return $result;
    }
}
