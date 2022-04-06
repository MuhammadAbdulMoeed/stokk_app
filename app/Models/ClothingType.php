<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClothingType extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'clothing_types';

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
