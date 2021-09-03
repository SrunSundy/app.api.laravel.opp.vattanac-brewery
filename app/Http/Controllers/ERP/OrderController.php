<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\Erp\Order\ListOrderResource;
use App\Models\Order;
use Exception;
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
        try {
            $this->getParams();
            $this->params["outlet_id"] = request()->get('outlet_id');
            $list = Order::list($this->params);
            $list['list'] = ListOrderResource::collection($list['list']);
            
            return $this->ok($list);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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


    public function updateStatus(OrderRequest $request){
        try{

            DB::beginTransaction();

            $this->params["order_number"] = request()->get("order_number");
            $this->params["state_id"] = request()->get("order_status");

            if(Order::isOrderExisted($this->params)){
                Order::updateStatus($this->params);
                DB::commit();
                return $this->ok(__('auth.success'));
            }else{
                return $this->fail(__('auth.record_not_found'), 404);
                DB::rollBack();
            }
        }catch(Exception $e){
            DB::rollBack();
            return $this->fail($e->getMessage() , 500);
        }
    }


}
