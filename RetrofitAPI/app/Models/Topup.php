<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    protected $table = 'topups';
    protected $primaryKey = 'topupID';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = ['userID', 'method', 'amount', 'transdate', 'status', 'snap_token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
}
