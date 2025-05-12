<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'orderID';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['userID', 'subtotal', 'shipping_fee', 'total', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'orderID', 'orderID');
    }
}
