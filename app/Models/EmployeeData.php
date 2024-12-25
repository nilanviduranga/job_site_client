<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeData extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'whatsapp',
        'image',
        'user_id',
    ];
}
