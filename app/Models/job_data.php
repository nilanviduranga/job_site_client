<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_data extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'location',
        'male',
        'female',
        'both',
        'min_age',
        'max_age',
        'salary',
        'start_date',
        'end_date',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
