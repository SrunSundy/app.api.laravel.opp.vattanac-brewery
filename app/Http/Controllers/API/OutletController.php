<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Outlet\AgentFeedbackRequest;
use App\Http\Requests\API\Outlet\FeedbackRequest;
use App\Http\Requests\API\Outlet\OutletRequest;
use App\Http\Requests\API\Outlet\OutletWishlistRequest;
use App\Http\Resources\API\Outlet\OutletWishlistResource;
use App\Http\Resources\API\SaleUser\DetailSaleUSerResource;
use App\Models\Feedback;
use App\Models\Outlet;
use App\Models\OutletWishlist;
use App\Models\RequestOutlet;
use App\Models\SaleUser;
use App\Models\SaleUserFeedback;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function agent(){
        
        try{
            $item = SaleUser::detail();
            if(!filled($item)){
                return $this->fail(__('auth.record_not_found'), 404);
            }
            $item = new DetailSaleUSerResource($item);
            return $this->ok($item);
        }catch(Exception $e){
            return $this->fail($e->getMessage(), 500);
        }
    }

    /**
     * Display a listing of outlet's wishlist
     */

    public function wishlist(){
        try{
            $this->getParams();
            $list = OutletWishlist::list($this->params);
            
            $list['list'] = OutletWishlistResource::collection($list['list']);
            return $this->ok($list);
        }catch(Exception $e){
            return $this->fail($e->getMessage(), 500);
        }
    }


    /**
     * add product to wishlist 
     */
    public function storeWishlist(OutletWishlistRequest $request){
        try{
            DB::beginTransaction();
            OutletWishlist::store($request);
            DB::commit();
            return $this->ok(__('auth.success'));
        }catch(Exception $e){
            report($e);
            DB::rollBack();
            return $this->fail($e->getMessage(), 500);
        }
    }

    /**
     * remove product from wishlist
     */
    public function removeWishlist(OutletWishlistRequest $request){
        try{
            DB::beginTransaction();
            OutletWishlist::remove($request);
            DB::commit();
            return $this->ok(__('auth.success'));
        }catch(Exception $e){
            report($e);
            DB::rollBack();
            return $this->fail($e->getMessage(), 500);
        }
    }

     /**
     * send feedback for app
     */
    public function sendAppFeedback(FeedbackRequest $request){
        try{
            DB::beginTransaction();
            feedback::store($request);
            DB::commit();
            return $this->ok(__('auth.success'));
        }catch(Exception $e){
            report($e);
            DB::rollBack();
            return $this->fail($e->getMessage(), 500);
        }
    }


    /**
     * send feedback for agent
     */
    public function sendAgentFeedback(AgentFeedbackRequest $request){
        try{
            DB::beginTransaction();
            SaleUserFeedback::store($request);
            DB::commit();
            return $this->ok(__('auth.success'));
        }catch(Exception $e){
            report($e);
            DB::rollBack();
            return $this->fail($e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OutletRequest $request)
    {
        try{
             
            DB::beginTransaction();
            if(RequestOutlet::isPhoneNumberExisted($request)){
                DB::rollBack();
                return $this->fail("Phone number already exists", 403);
            }
            $data = RequestOutlet::store($request);
            DB::commit();
            return $this->ok($data);
            // $token = Auth::attempt([
            //     'contact_number' => $request->phone_number,
            //     'password' => $request->password,
            // ]);
            // return $this->ok($this->respondWithToken($token));
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

     /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => config('api.credential.token_type'),
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }
}
