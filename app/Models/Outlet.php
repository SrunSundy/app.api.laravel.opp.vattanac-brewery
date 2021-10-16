<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Outlet extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $hidden = [
        'password',
        'deleted_at',
    ];

    protected $fillable = [
        'owner_name', 
        'outlet_name', 
        'contact_number',
        'password',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

     /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        // create a event to happen on updating
        static::updating(function ($table) {
            $table->updated_at = get_current_datetime() ?? null;
        });

        // create a event to happen on saving
        static::creating(function ($table) {
            $table->created_at = get_current_datetime() ?? null;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /*
    |------------------------------------------------------------ 
    | Relations
    |------------------------------------------------------------
    */

    public function saleUser()
    {
        return $this->belongsTo(SaleUser::class, 'sale_user_id');
    }

    public function agent(){
        return $this->belongsTo(Agent::class, "agent_id");
    }

     /*
    |------------------------------------------------------------ 
    | ACCESSORS
    |------------------------------------------------------------
    */
    public function getSaleUserNameAttribute()
    {
        return $this->saleUser->fullname ?? '';
    }

    public function getOutletNameKhAttribute()
    {
        return $this->name_kh;
    }

    public function getOutletNameEnAttribute()
    {
        return $this->outlet_name;
    }

     /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */

    public static function isPhoneNumberExisted($request){
        $cnt = self::where("contact_number", request()->get("phone_number"))->count();
        return $cnt >= 1;
    }

    public static function store($request)
    {

        $fields = [
            'owner_name',
            'outlet_name',
            'contact_number',
            'password'
        ];

        $value = mapRequest($fields, $request);
        $data = self::create($value);
        
        return $data;
    }   


    public static function forgotPassword($request)
    {
        if (!$customer_verification = OutletForgotCode::verifyForgotPasswordToken($request)) {
            return false;
        }

        return self::updateOrCreate(
            ['contact_number' => $customer_verification->phone_number],
            ['password' => $request->new_password]
        );
    }

 


    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
