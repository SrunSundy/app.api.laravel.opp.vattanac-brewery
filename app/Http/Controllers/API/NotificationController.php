<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Notification\ListNotificationResource;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
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
            $list = Notification::list($this->params);

            $list["list"] = ListNotificationResource::collection($list["list"]);
            return $this->ok($list);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }


    public function unRead()
    {
         //
        try {
            $this->getParams();
            $list = Notification::listUnRead($this->params);

            $list["list"] = ListNotificationResource::collection($list["list"]);
            return $this->ok($list);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }


    public function countMyUnread()
    {
        try {
            $unread_notification = Notification::unreadRecord()->count();

            return $this->ok($unread_notification);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function readAllNotification()
    {
        DB::beginTransaction();
        try {
            NotificationRecipient::readAll();

            DB::commit();
            return $this->ok("");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->fail($e->getMessage(), 500);
        }
    }

    public function readNotification($notification)
    {
        DB::beginTransaction();
        try {
            $data = Notification::restrictRecord()->find($notification);

            if (!$data) {
                return $this->fail(__('auth.record_not_found'), 404);
            }

            NotificationRecipient::read($notification);

            DB::commit();
            return $this->ok("");
        } catch (Exception $e) {
            DB::rollBack();
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
}
