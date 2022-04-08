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
}
