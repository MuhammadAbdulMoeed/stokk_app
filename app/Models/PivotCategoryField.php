<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCategoryField extends Model
{
    use HasFactory;

    protected $table = 'pivot_categories_fields';
    protected $guarded = [];
}
