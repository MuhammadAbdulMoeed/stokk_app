<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    protected $table = 'filters';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
