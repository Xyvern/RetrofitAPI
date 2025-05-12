<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $primaryKey = 'ratingID';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['userID', 'productID', 'orderDetailID', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'orderDetailID', 'orderDetailID');
    }
}
