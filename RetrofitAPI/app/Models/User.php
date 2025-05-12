<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
        /*
    Role:
    1: Cust
    2: Karyawan
    3: Admin
    */

    use SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'userID';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['name', 'email', 'password', 'phone', 'address', 'postcode', 'pfp_url', 'role', 'credit'];
    
    public function postcode()
    {
        return $this->belongsTo(Postcode::class, 'postcode', 'postcodeID');
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'userID', 'userID');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'userID', 'userID');
    }

    public function topups()
    {
        return $this->hasMany(Topup::class, 'userID', 'userID');
    }
}