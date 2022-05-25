<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function firstUser()
    {
        return $this->belongsTo(User::class,'user_1');
    }

    public function secondUser()
    {
        return $this->belongsTo(User::class,'user_2');
    }
}
