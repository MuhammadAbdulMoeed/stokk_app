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
        return $this->belongsToMany(CustomField::class,PivotCategoryFilter::class,'category_id','filter_id');
    }

    public function categoryFiltersOrder()
    {
        return $this->belongsToMany(CustomField::class,PivotCategoryFilter::class,'category_id','filter_id')
            ->orderBy('order','asc');
    }

    public function categoryField()
    {
        return $this->hasMany(PivotCategoryField::class,'category_id');
    }

    public function categoryFields()
    {
        return $this->belongsToMany(CustomField::class,PivotCategoryField::class,'category_id','custom_field_id');
    }

    public function categoryFieldsOrder()
    {
        return $this->belongsToMany(CustomField::class,PivotCategoryField::class,'category_id','custom_field_id')
            ->withPivot('sub_category_id')
            ->orderBy('order','asc');
    }
}
