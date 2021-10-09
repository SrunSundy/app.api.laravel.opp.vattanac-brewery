<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'message',
        'data',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function notification_recipients()
    {
        return $this->hasMany(NotificationRecipient::class);
    }

    public function notifiable()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeRestrictRecord($query)
    {
        $my_notification_ids = NotificationRecipient::where([
            'user_id' => auth()->user()->id,
            'user_type' => Outlet::getTableName(),
        ])->pluck('notification_id');


        return $query->where(function ($q) use ($my_notification_ids) {
            $q->whereIn('id', $my_notification_ids);
        });
    }

    public function scopeUnreadRecord($query)
    {
        $my_unread_notification_ids = NotificationRecipient::where([
            'user_id' => auth()->user()->id,
            'user_type' => Outlet::getTableName(),
            'is_read' => false,
        ])->pluck('notification_id');

        return $query->whereIn('id', $my_unread_notification_ids);
    }

    public function scopeIsRead($query, $is_read = true)
    {
        return $query->whereHas('notification_recipients', function ($q) use ($is_read) {
            $q->isRead($is_read);
        });
    }

    public function scopeHideReadNotification($query, $is_hide_read_notification = false)
    {
        if ($is_hide_read_notification) {
            return $query->whereHas('notification_recipients', function ($q) use ($is_hide_read_notification) {
                $q->isRead(!$is_hide_read_notification)
                    ->where('user_id', auth()->user()->id);
            });
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getIsReadAttribute()
    {
        return NotificationRecipient::myNotification()
            ->where(['notification_id' => $this->id, 'is_read' => true])->count() || false;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | STATIC FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function list($params)
    {
        $list = self::restrictRecord();
        return listLimit($list, $params);
    }
}
