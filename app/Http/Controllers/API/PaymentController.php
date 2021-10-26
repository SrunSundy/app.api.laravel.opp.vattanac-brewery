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

    public function store(CreatePaymentRequest $request)
    {
        try {
            DB::beginTransaction();

            $decypt = EncryptLib::decryptString($request->encrypt_cart_id);
            $cart_id_arr = explode('-', $decypt);
            $cart_id = $cart_id_arr[0] ?? '';
            $cart = Cart::where('outlet_id', auth()->user()->id)
                ->first();

            if (!$cart_id && $cart_id != $cart->id) {
                return $this->fail(__('validation.not_found', ['attribute' => __('validation.attributes.cart')]));
            }

            if ($request->amount != $cart->total) {
                return $this->fail(__('validation.not_found', ['attribute' => __('validation.attributes.cart')]));
            }

            $payment = PaymentTransaction::create([
                'cart_id' => $cart_id,
                'outlet_id' => auth()->user()->id,
                'encrypt_cart_id' => $request->encrypt_cart_id,
                'transaction_id' => $request->transaction_id,
                'amount' => $request->amount,
                'status' => $request->status,
            ]);

            DB::commit();
            return $this->ok(true);
        } catch (Exception $e) {
            report($e);
            DB::rollback();
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function update(CreatePaymentRequest $request)
    {
        try {
            DB::beginTransaction();

            $decypt = EncryptLib::decryptString($request->encrypt_cart_id);
            $cart_id_arr = explode('-', $decypt);
            $cart_id = $cart_id_arr[0] ?? '';
            $cart = Cart::where('outlet_id', auth()->user()->id)
                ->first();
            if (!$cart_id && $cart_id != $cart->id) {
                return $this->fail(__('validation.not_found', ['attribute' => __('validation.attributes.cart')]));
            }

            if ($request->amount != $cart->total) {
                return $this->fail(__('validation.not_found', ['attribute' => __('validation.attributes.cart')]));
            }

            $payment = PaymentTransaction::where([
                'transaction_id' => $request->transaction_id,
                'order_id' => null,
                'encrypt_cart_id' => $request->encrypt_cart_id,
                'outlet_id' => auth()->user()->id,
            ]);

            if ($request->status === 'SUCCESS') {
                $status = ['SCANNED', 'PENDING'];
                $payment = $payment->whereIn('status', $status);
            }

            if ($request->status === 'FAIL') {
                $payment = $payment->where('status', '!=', 'SUCCESS');
            }

            if ($request->status === 'SCANNED') {
                $payment = $payment->where('status', 'PENDING');
            }

            $payment = $payment->first();
            if (!filled($payment)) {
                return $this->fail(__('validation.not_found', ['attribute' => __('validation.attributes.payment')]));
            }

            if ($request->status === 'SUCCESS') {
                $order = Order::placeOrder();
                $payment->order_id = $order->id;
                Session::flash('success', __('dialog.your_order_has_been_placed'));
            }

            $payment->status = $request->status;
            $payment->save();

            DB::commit();
            return $this->ok(true);
        } catch (Exception $e) {
            report($e);
            DB::rollback();
            abort(500);
        }
}
