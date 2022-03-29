<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterValue extends Model
{
    use HasFactory;

    protected $table = 'filter_values';


    protected $guarded = [];

    public function filter()
    {
        return $this->belongsTo(Filter::class,'filter_id');
    }
}
