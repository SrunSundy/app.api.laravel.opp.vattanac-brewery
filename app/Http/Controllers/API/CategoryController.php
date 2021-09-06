<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Category\DetailCategoryResource;
use App\Http\Resources\API\Category\ListCategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;



class CategoryController extends Controller 
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
            $list = Category::list($this->params);
            $list['list'] = ListCategoryResource::collection($list['list']);
            
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
            $item = Category::detail($this->params);
            if(!filled($item)){
                return $this->fail(__('auth.record_not_found'), 404);
            }
            $item = new DetailCategoryResource($item);
            return $this->ok($item);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }   
    }
}
