<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class,'parent_category_id');
    }


}
