<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Product\ProductReviewRequest;
use App\Http\Resources\API\Product\DetailProductResource;
use App\Http\Resources\API\Product\ListProductResource as ProductListProductResource;
use App\Http\Resources\API\Product\ProductReviewResource;
use App\Http\Resources\ListProductResource;
use App\Models\Product;
use App\Models\ProductReview;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $this->getParams();
            $list = Product::list($this->params);
            $list['list'] = ProductListProductResource::collection($list['list']);
            return $this->ok($list);
        }catch(Exception $e){
            return $this->fail($e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReview(ProductReviewRequest $request)
    {
        try{
            DB::beginTransaction();
            ProductReview::store($request);
            DB::commit();
            return $this->ok(__('auth.success'));
        }catch(Exception $e){
            DB::rollBack();
            return $this->fail($e->getMessage(), 500); 
        }
    }



    /**
     * Display the product avg of review
     * required product_id
     */

    public function review(){
        try{
            $this->getParams();
            $list = ProductReview::list($this->params);
            $list['avg_review'] = ProductReview::avgReview();
            $list["cnt_review"] = ProductReview::cntReview();
            $list["is_reviewed"] = ProductReview::isReviewed();
            $list['list'] = ProductReviewResource::collection($list['list']);
            return $this->ok($list);
        }catch(Exception $e){
            return $this->fail($e->getMessage(), 500);
        }
    }

     /**
      * end of review
      */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    public function show(Product $product)
    {
        //
        try{
            $item = $product;
            $item = new DetailProductResource($item);
            return $this->ok($item);
        }catch(Exception $e){
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
    public function updateReview(ProductReviewRequest $request, $id)
    {
        try{
            DB::beginTransaction();
            ProductReview::store($request, $id);
            DB::commit();
            return $this->ok(__('auth.success'));
        }catch(Exception $e){
            DB::rollBack();
            return $this->fail($e->getMessage(), 500); 
        }
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
