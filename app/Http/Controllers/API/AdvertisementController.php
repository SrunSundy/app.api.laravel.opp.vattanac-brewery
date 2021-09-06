<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Advertisement\DetailAdvertisementResource;
use App\Http\Resources\API\Advertisement\ListAdvertisementResource;
use App\Models\Advertisement;
use Exception;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
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
            $list = Advertisement::list($this->params);
            $list['list'] = ListAdvertisementResource::collection($list['list']);
            
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
    public function show(Advertisement $advertisement)
    {
        try {
            $item = $advertisement;
            $item = new DetailAdvertisementResource($item);
            return $this->ok($item);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }   
    }
}
