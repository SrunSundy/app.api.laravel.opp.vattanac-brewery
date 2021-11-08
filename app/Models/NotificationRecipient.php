<?php

namespace App\Models;

use App\Http\Traits\ModelHelperTrait;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\MultiPrimaryKeyTrait;
use Illuminate\Notifications\Notifiable;

class NotificationRecipient extends Model
{
    use Notifiable, ModelHelperTrait , MultiPrimaryKeyTrait;

    public $incrementing = false;
    protected $primaryKey = ['notification_id', 'user_id', 'user_type'];
    
    protected $fillable = [
        'notification_id',
        'user_id',
        'user_type',
        'is_read',
    ];
  

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
