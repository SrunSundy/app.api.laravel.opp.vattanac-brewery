<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationRecipient extends Model
{
    protected $fillable = [
        'notification_id',
        'user_id',
        'user_type',
        'is_read',
    ];

    protected $primaryKey = ['notification_id', 'user_id', 'user_type'];

    protected $casts = [
        'is_read' => 'boolean',
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
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeMyNotification($query)
    {
        $query->where([
            'user_id' => auth()->user()->id,
            'user_type' => Outlet::getTableName(),
        ]);
    }

    public function scopeIsRead($query, $is_read = true)
    {
        $query->where('is_read', $is_read);
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

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
    public static function read($notification_id)
    {
        self::updateOrCreate([
            'notification_id' => $notification_id,
            'user_id' => auth()->user()->id,
            'user_type' => Outlet::getTableName(),
        ], [
            'is_read' => true,
        ]);
    }

    public static function readAll()
    {
        self::where([
            'user_id' => auth()->user()->id,
            'user_type' => Outlet::getTableName(),
            'is_read' => false,
        ])->update([
            'is_read' => true,
        ]);
    }
}
