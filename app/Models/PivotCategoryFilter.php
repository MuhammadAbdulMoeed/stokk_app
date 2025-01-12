<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCategoryFilter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function filter()
    {
        return $this->belongsTo(CustomField::class,'filter_id');
    }

//    public function filter()
//    {
//        return $this->belongsTo(Filter::class,'filter_id');
//    }



}
