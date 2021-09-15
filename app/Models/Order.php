<?php

namespace App\Models;

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

    public function getOutletNameAttribute()
    {
        return $this->outlet->outlet_name ?? '';
    }

    public function getOrderStatusAttribute()
    {
        return $this->orderState->state_label ?? '';
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

        // create a event to happen on saving
        static::created(function ($model) {
            $model->order_number = self::generateOrderCode($model->id);
            $model->save();
        });
    }

    public function scopeFilter($query, $params)
    {

        if (request()->has("state_code")) {
            $query->where("order_states.order_state_code", request()->get("state_code"));
        }
        $outlet_id = $params["outlet_id"] ?? request()->get('outlet_id');
        $query->where("outlet_id", $outlet_id);
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

        $list = self::leftJoin('order_states', function ($join) {
            $join->on('order_states.id', '=', 'orders.state_id');
        })->filter($params);
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

    public static function isOrderExisted($params)
    {
        $count = self::where("order_number", $params["order_number"])->count();
        return ((int)$count > 0);
    }

    public static function store($request)
    {
        $request["state_id"] = OrderState::getValueByKey("202");
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
                    'product_variant_id' => $product["product_variant_id"],
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
