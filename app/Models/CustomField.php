<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    protected $table = 'custom_fields';
    protected $guarded = [];

    public function customFieldOption()
    {
        return $this->hasMany(CustomFieldOption::class,'custom_field_id');
    }

    public function relatedFields()
    {
        return $this->belongsTo(CustomField::class,'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(CustomField::class,'parent_id');
    }

    public function getChild()
    {
        return $this->hasMany(CustomField::class,'parent_id');
    }

    public function customFieldOptionSelected()
    {
        return $this->belongsTo(CustomFieldOption::class,'option_id');
    }

    public function pivotTableValue()
    {
        return $this->hasOne(PivotProductCustomField::class,'custom_field_id');
    }

}
