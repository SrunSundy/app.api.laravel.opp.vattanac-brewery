<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Brand\DetailBrandResource;
use App\Http\Resources\API\Brand\ListBrandResource;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $this->getParams();
            $list = Brand::list($this->params);
            $list['list'] = ListBrandResource::collection($list['list']);
            
            return $this->ok($list);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $this->getParams();
            $this->params["id"] = $id;
            $item = Brand::detail($this->params);
            if(!filled($item)){
                return $this->fail(__('auth.record_not_found'), 404);
            }
            $item = new DetailBrandResource($item);
            return $this->ok($item);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }   
    }
}
