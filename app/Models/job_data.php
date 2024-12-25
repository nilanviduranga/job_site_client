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
        'city',
        'min_age',
        'max_age',
        'salary',
        'start_date',
        'end_date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}