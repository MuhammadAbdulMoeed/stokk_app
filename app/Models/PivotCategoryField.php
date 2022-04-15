<?php

namespace App\Models;

use Cassandra\Custom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCategoryField extends Model
{
    use HasFactory;

    protected $table = 'pivot_categories_fields';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function field()
    {
        return $this->belongsTo(CustomField::class,'custom_field_id');
    }

    public function fields()
    {
        return $this->hasMany(CustomField::class,'id','custom_field_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class,'sub_category_id');
    }

}
