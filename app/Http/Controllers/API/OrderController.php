<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Order\CancelORderRequest;
use App\Http\Requests\API\Order\OrderRequest;
use App\Http\Resources\API\Order\DetailOrderResource;
use App\Http\Resources\API\Order\ListOrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            $this->getParams();
            $list = Order::list($this->params);
            $list['list'] = ListOrderResource::collection($list['list']);
            return $this->ok($list);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        //
        try{
            DB::beginTransaction();
            Order::store($request);
            DB::commit();
            Cart::removeAll($request);            
            return $this->ok(__('auth.success'));
            
        }catch(Exception $e)
        {
            report($e);
            DB::rollBack();
            return $this->fail($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
        try {
            $order = Order::show();
            $item = new DetailOrderResource($order);

            return $this->ok($item);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }


    /**cancel user's order */
    public function cancel(CancelORderRequest $request)
    {
        try{
             
            $order = Order::showToCancel();
            if($order){
                DB::beginTransaction();
                $durationToCancel = (int)Setting::getValueByKey("order.api.cancel_duration");
                $currentDate = get_current_datetime();
                $currentDuration =  substruct_two_datetime($order->created_at ,$currentDate);
             
                if($durationToCancel > $currentDuration){
                    $params["state_id"] = "499";
                    $status = Order::updateStatusById($params);
                    DB::commit();
                    return $this->ok($status);
                }else{
                    DB::rollBack();
                    return $this->fail("You can not cancel this order.");
                }
            }else{
                return $this->fail("Record not found", 404);
            }
        }catch (Exception $e){
            report($e);
            return $this->fail($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
