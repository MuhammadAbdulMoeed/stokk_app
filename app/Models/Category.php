<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function subCategory()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function categoryFilter()
    {
        return $this->hasMany(PivotCategoryFilter::class,'category_id');
    }

    public function categoryFilters()
    {
        return $this->belongsToMany(Filter::class,PivotCategoryFilter::class,'category_id','filter_id');
    }

    public function categoryFiltersOrder()
    {
        return $this->belongsToMany(Filter::class,PivotCategoryFilter::class,'category_id','filter_id')
            ->orderBy('order','asc');
    }
}
