<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $primaryKey = 'productID';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['name', 'categoryID', 'price', 'rating', 'description','img_url', 'fat', 'calories', 'protein'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID', 'categoryID');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'productID', 'productID');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'productID', 'productID');
    }

    public function getTotalRating()
    {
        return $this->ratings->sum('rating')?: 0;
    }
}
