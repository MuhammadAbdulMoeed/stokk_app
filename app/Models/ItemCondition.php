<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCondition extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table  = 'item_conditions';

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
