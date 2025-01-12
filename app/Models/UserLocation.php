<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'user_locations';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
