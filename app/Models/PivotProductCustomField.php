<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotProductCustomField extends Model
{
    use HasFactory;

    protected $table = 'pivot_products_custom_fields';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function customField()
    {
        return $this->belongsTo(CustomField::class,'custom_field_id');
    }




}
