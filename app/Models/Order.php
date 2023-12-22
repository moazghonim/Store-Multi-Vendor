<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'user_id',
        'payment_method',
        'status',
        'payment_stauts',
    ];


    public function store()
    {
        return $this->BelongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Guest Customer']);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'order_id', 'product_id')
            ->using(OrderDetail::class)
            ->withPivot(['product_name', 'quantity', 'options']);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class)->where('type', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class)->where('type', 'shipping');
    }

    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {

        $year = Carbon::NOW()->year;
        $number = Order::whereyear('created_at', $year)->mix('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
