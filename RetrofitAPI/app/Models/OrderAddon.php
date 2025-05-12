<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddon extends Model
{
    protected $table = 'order_addons';
    protected $primaryKey = 'orderAddonID';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = ['orderDetailID', 'addon_name'];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'orderDetailID', 'orderDetailID');
    }
}
