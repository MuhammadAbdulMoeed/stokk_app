<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFilter extends Model
{
    use HasFactory;

    protected $table = 'category_filters';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
