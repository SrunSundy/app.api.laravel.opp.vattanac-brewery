<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\AgentPaymentAccount;
use Exception;

class PaymentController extends Controller
{
    public function getPaymentAccount()
    {
        try{
            $payment = auth()->user()->payment_account;
            if (!$payment) {
                return $this->fail('No payment account');
            }

            return $this->ok(new AgentPaymentAccount($payment));
        }catch(Exception $e){
            return $this->fail($e->getMessage(), 500);
        }
    }
}
