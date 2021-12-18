<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Cart\CartRequest;
use App\Http\Resources\API\Cart\DetailCartResource;
use App\Http\Resources\API\Cart\ListCartResource;
use App\Models\Cart;
use App\Models\CartProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
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
            $item = Cart::detail($this->params);
            $data = Cart::list($this->params);
            $list = new DetailCartResource($item);
            $list['list'] = ListCartResource::collection($data['list']);
            $subTotal = 0;
            foreach($list['list'] as $item){
                if( filled($item["unit_price"])){
                    $subTotal += ($item["unit_price"] * $item["quantity"] );
                }
            }
            $list["sub_total"] = $subTotal;
            
            return $this->ok($list);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }


    public function cartCount(){
       
        try {
            $this->getParams();
            //$item["cnt"] = Cart::productCnt($this->params);
            $item["cnt"] = Cart::productQtyCnt($this->params);
            return $this->ok($item);
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
    public function store(CartRequest $request)
    {
        //
        try{
            DB::beginTransaction();
            Cart::store($request);
            DB::commit();
            $item["cnt"] = Cart::productCnt($request);
            
            return $this->ok($item);
        }catch(Exception $e){
            report($e);
            DB::rollBack();
            return $this->fail($e->getMessage(), 500);
        }
    }


    public function reorder(CartRequest $request)
    {
        try{
            DB::beginTransaction();
            Cart::reorder($request);
            DB::commit();
            $item["cnt"] = Cart::productCnt($request);
            
            return $this->ok($item);
        }catch(Exception $e){
            report($e);
            DB::rollBack();
            return $this->fail($e->getMessage(), 500);
        }
    }


    public function remove(CartRequest $request){
        try{
            DB::beginTransaction();
            Cart::remove($request);
            DB::commit();
            $item["cnt"] = Cart::productCnt($request);
            return $this->ok($item);
        }catch(Exception $e){
            report($e);
            DB::rollBack();
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function removeAll(CartRequest $request){

        try{
            DB::beginTransaction();
            Cart::removeAll($request);
            DB::commit();
            $item["cnt"] = Cart::productCnt($request);
            return $this->ok($item);
        }catch(Exception $e){
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
}
