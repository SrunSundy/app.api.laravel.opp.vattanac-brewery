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
        'agent_id',
        'promotion_id',
        'state_id',
        'order_number',
        'sub_total',
        'percent_off',
        'amount_off',
        'total',
        'is_urgent',
        'note',
        'secondary_phone',
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
        return $this->agent->name ?? '';
    }

    public function getAgentIdAttribute($value)
    {
        return $value ?? '';
    }

    public function getAgentPhoneAttribute()
    {
        return $this->agent->contact_number ?? '';
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

    public function getOrderStateCodeAttribute()
    {
        return $this->orderState->order_state_code ?? '';
    }

    public function getStateLabelAttribute()
    {
        return $this->orderState->state_label ?? '';
    }

    public function getCreatedAtAttribute($value)
    {
        return DateLib::formatDateTime($value ?? '');
    }

    public function getVbTransactionCodeAttribute()
    {
        return $this->transaction->transaction_id ?? '-';
    }

    public function getVbOrderCodeAttribute()
    {
        return $this->transaction->vb_order_id ?? '-';
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
            $table->timestamps = false;
        });

        // create a event to happen on saving
        static::created(function ($model) {


            $agent = Agent::where("id", $model->agent_id)->first();
            $prefix = "SO";
            if ($agent && filled($agent->agent_number)) {
                $prefix = $agent->agent_number . "-SO";
            }
            $model->order_number = self::generateOrderCode($model->id,  $prefix);
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
            ->where("order_number", "like", "%" . $params["search"] . "%");
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
        return $this->belongsTo(Agent::class, 'agent_id');
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

    public function transaction()
    {
        return $this->hasOne(PaymentTransaction::class, 'order_id')
            ->where('status', 'SUCCESS');
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
        return self::where('id', request()->get('order_id'))
            ->where('outlet_id', auth()->user()->id)
            ->update([
                "state_id" => $params["state_id"]
            ]);
    }

    public static function show()
    {
        return request()->route('order');
        // return self::where('id', request()->route('order'))
        //     ->where('outlet_id', auth()->user()->id)
        //     ->first();
    }

    public static function showToCancel()
    {
        return self::where('id', request()->get('order_id'))
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
        request()->merge([
            'contact_number' => phone($request["phone_number"], 'kh'),
        ]);
        $fields = [
            'outlet_id',
            'agent_id',
            'promotion_id',
            'state_id',
            'order_number',
            'sub_total',
            'percent_off',
            'amount_off',
            'total',
            'is_urgent',
            'products',
            'note',
            'secondary_phone'
        ];

        $value = mapRequest($fields, $request);
        $order = self::create($value);
        if ($order) {
            $products = [];
            $req_products = request()->get("products");
            foreach ($req_products as $product) {
                //dd($product);
                $product_sub_total = self::calculateSubTotalAmount($product["quantity"], $product["unit_price"]);
                $product_total = self::calculateTotalAmount($product_sub_total, 0);

                array_push($products, [
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

    public static function placeOrder()
    {
        $cart = Cart::where('outlet_id', auth()->user()->id)
            ->first();

        $order = self::create([
            'outlet_id' => $cart->outlet_id,
            'promotion_id' => $cart->promotion_id,
            'is_urgent' => $cart->is_urgent,
            'agent_id' => auth()->user()->agent_id,
            'state_id' => 202,
        ]);

        $sub_total = 0;
        $total = 0;
        foreach ($cart->cart_products as $cart_product) {
            // TO DO : Change from find product to find product variant
            $product = Product::find($cart_product->product_variant_id);

            if (filled($product)) {
                $product_sub_total = self::calculateSubTotalAmount($cart_product->quantity, $product->unit_price);
                $product_total = self::calculateTotalAmount($product_sub_total, 0);

                $order_product = OrderProduct::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $cart_product->product_variant_id,
                    'quantity' => $cart_product->quantity,
                    'unit_price' => $product->unit_price,
                    'sub_total' => $product_sub_total,
                    'percent_off' => 0, // TO DO : Get percentage off from promotion
                    'amount_off' => 0, // TO DO : Get amount off from promotion
                    'total' => $product_total,
                ]);

                $sub_total += $product_sub_total;
                $total += $product_total;
            }
        }

        $order->sub_total = $sub_total;
        $order->percent_off = 0;
        $order->amount_off = 0;
        $order->total = $total;
        $order->save();

        // TO DO : Copy the cart to store in cart history
        $cart->cart_products()->delete();
        $cart->delete();

        // $sale_user = SaleUser::find($order->sale_user_id);
        // $message = MessageTemplate::getNewOrderMessage($order);
        // if ($message) {
        //     $url = Configuration::getValueByKey(Configuration::ERP_URL);

        //     // TO DO : To replace the url with ERP
        //     $url = strtr($url, [
        //         '[ORDER_ID]' => $order->id,
        //     ]);

        //     $sale_user->notify(new TelegramNotification($message, $url));
        // }

        return $order;
    }
}
