<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected  $table = 'shipping_addresses';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
