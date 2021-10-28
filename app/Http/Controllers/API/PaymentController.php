<?php

namespace App\Http\Controllers\API;

use App\Core\EncryptLib;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreatePaymentRequest;
use App\Http\Resources\Payment\AgentPaymentAccount;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentTransaction;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function getPaymentAccount()
    {
        try {
            $payment = auth()->user()->payment_account;
            if (!$payment || !filled($payment)) {
                return $this->fail('No payment account');
            }

            return $this->ok(new AgentPaymentAccount($payment));
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function store(CreatePaymentRequest $request)
    {
        try {
            DB::beginTransaction();

            $decypt = EncryptLib::decryptString($request->encrypt_cart_id, config('services.cipher.password'), config('services.cipher.iv'));
            info("decypt", [
                'value' => $decypt,
            ]);
            $cart_id_arr = explode('-', $decypt);
            $cart_id = $cart_id_arr[0] ?? '';
            $cart = Cart::where('outlet_id', auth()->user()->id)
                ->first();

            if (!$cart_id && $cart_id != $cart->id) {
                return $this->fail(__('validation.not_found', ['attribute' => __('validation.attributes.cart')]));
            }

            if ($request->amount != $cart->total) {
                return $this->fail(__('validation.incorrect', ['attribute' => 'amount']));
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
            DB::rollback();
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function update(CreatePaymentRequest $request)
    {
        try {
            DB::beginTransaction();

            $decypt = EncryptLib::decryptString($request->encrypt_cart_id, config('services.cipher.password'), config('services.cipher.iv'));
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
            }

            $payment->status = $request->status;
            $payment->save();

            DB::commit();
            return $this->ok(true);
        } catch (Exception $e) {
            DB::rollback();
            return $this->fail($e->getMessage(), 500);
        }
    }
}
