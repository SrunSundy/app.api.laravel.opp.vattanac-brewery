<?php

namespace App\Models;

use App\Core\DateLib;
use App\Http\Traits\OrderHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use OrderHelperTrait;
    protected $fillable = [
        'outlet_id', 
        'sale_user_id', 
        'promotion_id',
        'state_id',
        'order_number',
        'sub_total',
        'percent_off',
        'amount_off',
        'total',
        'is_urgent',
        'created_at',
        'updated_at',
    ];

    /*
    |------------------------------------------------------------ 
    | ACCESSORS
    |------------------------------------------------------------
    */
    public function getCouponCodeAttribute()
    {
        return $this->promotion->coupon_code ?? '';
    }

    public function getAgentNameAttribute()
    {
        return $this->agent->fullname ?? '';
    }

    public function getAgentIdAttribute()
    {
        return $this->agent->id ?? '';
    }

    public function getAgentCodeAttribute()
    {
        return $this->agent->agent_number ?? '';
    }

    public function getOutletNameAttribute()
    {
        return $this->outlet->outlet_name ?? '';
    }

    public function getOrderStatusAttribute()
    {
        return $this->orderState->state_label ?? '';
    }

    // public function getCreatedAtAttribute(){
    //     return DateLib::formatDateTime($this->created_at ?? '');
    // }


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
            $table->timestamps = false;
        });

        // create a event to happen on saving
        static::created(function ($model) {
            $model->order_number = self::generateOrderCode($model->id);
            $model->save();
        });
    }

    public function scopeFilter($query, $params)
    {
        if (request()->has("state_code")) {
            $query->where("state_id", request()->get("state_code"));
        }
        $outlet_id = auth()->user()->id ?? request()->get('outlet_id');
        $query->where("outlet_id", $outlet_id)
            ->where("order_number", "like", "%".$params["search"]."%");
        return $query;
    }

    /*
    |------------------------------------------------------------ 
    | RELATIONS
    |------------------------------------------------------------
    */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function agent()
    {
        return $this->belongsTo(SaleUser::class, 'sale_user_id');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, "outlet_id");
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, "order_id");
    }

    public function orderState()
    {
        return $this->belongsTo(OrderState::class, "state_id", 'order_state_code');
    }

    /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */
    public static function list($params)
    {

        $list = self::filter($params);
        return listLimit($list, $params);
    }

    public static function detail($params)
    {
        $data = self::where("order_number", $params["order_number"])
            ->where("outlet_id", $params["outlet_id"])
            ->first();
        return $data;
    }

    public static function updateStatus($params)
    {
        return self::where("order_number", $params["order_number"])
            ->update([
                "state_id" => $params["state_id"]
            ]);
    }

    public static function updateStatusById($params)
    {
        return self::where('id', request()->get("order_id"))
            ->where('outlet_id', auth()->user()->id)
            ->update([
                "state_id" => $params["state_id"]
            ]);
    }

    public static function show(){
        return self::where('id', request()->get("order_id"))
            ->where('outlet_id', auth()->user()->id)
            ->first();
    }

    public static function isOrderExisted($params)
    {
        $count = self::where("order_number", $params["order_number"])->count();
        return ((int)$count > 0);
    }

    public static function store($request)
    {
        $request["state_id"] = 202;
        $request["outlet_id"] = auth()->user()->id;
        $fields = [
            'outlet_id',
            'sale_user_id',
            'promotion_id',
            'state_id',
            'order_number',
            'sub_total',
            'percent_off',
            'amount_off',
            'total',
            'is_urgent',
            'products',
        ];
        $value = mapRequest($fields, $request);
        $order = self::create($value);
        if($order){
            $products = [];
            $req_products = request()->get("products");
            foreach($req_products as $product){
                //dd($product);
                $product_sub_total = self::calculateSubTotalAmount($product["quantity"], $product["unit_price"]);
                $product_total = self::calculateTotalAmount($product_sub_total, 0);

                array_push($products , [
                    'order_id' => $order->id,
                    'product_variant_id' => $product["product_id"],
                    'quantity' => $product["quantity"],
                    'unit_price' => $product["unit_price"],
                    'sub_total' => $product_sub_total,
                    'percent_off' => 0, // TO DO : Get percentage off from promotion
                    'amount_off' => 0, // TO DO : Get amount off from promotion
                    'total' => $product_total,
                ]);
            }
            OrderProduct::insert($products);
        }

        return $order;
    }
}
