<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function customField()
    {
        return $this->belongsToMany(CustomField::class, PivotProductCustomField::class, 'product_id', 'custom_field_id')
            ->withPivot('value');
    }

    public function customFieldRelated()
    {
        return $this->belongsToMany(CustomField::class, PivotProductCustomField::class, 'product_id', 'custom_field_id')
            ->withPivot('value')->whereNotNull('parent_id');
    }

    public function customFieldRelate()
    {
        return $this->belongsToMany(CustomField::class, PivotProductCustomField::class, 'product_id', 'custom_field_id')
            ->withPivot('value')->whereNull('parent_id');

    }

    public function allRelatedFields()
    {
        return $this->belongsToMany(CustomField::class, PivotProductCustomField::class, 'product_id', 'custom_field_id')
            ->withPivot('value');

    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function isFavorite()
    {
        return $this->hasMany(Favorite::class,'product_id');
    }

    public function customFieldHasMany()
    {
        return $this->hasMany( PivotProductCustomField::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }


}
