<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldOption extends Model
{
    use HasFactory;

    protected $table = 'custom_field_options';
    protected $guarded = [];

    public function relatedFields()
    {
        return $this->hasMany(CustomField::class,'option_id')
            ->select(['name','type','slug', 'parent_id','option_id','id', 'is_required','field_type']);
    }

}
