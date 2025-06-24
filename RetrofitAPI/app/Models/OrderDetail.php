<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = 'orderDetailID';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = ['orderID', 'productID', 'quantity', 'price', 'addon'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderID', 'orderID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'orderDetailID', 'orderDetailID');
    }

    public function orderAddons()
    {
        return $this->hasMany(OrderAddon::class, 'orderDetailID', 'orderDetailID');
    }
}
