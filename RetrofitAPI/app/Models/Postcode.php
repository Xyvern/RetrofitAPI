<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    protected $table = 'postcodes';
    protected $primaryKey = 'postcodeID';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['latitude', 'longitude'];

    public function users()
    {
        return $this->hasMany(User::class, 'postcode', 'postcodeID');
    }
}