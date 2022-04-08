<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldOption extends Model
{
    use HasFactory;

    protected $table = 'custom_field_options';
    protected $guarded = [];
}
