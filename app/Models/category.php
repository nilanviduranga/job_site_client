<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\Jobs\Job;

class category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_image',
    ];

    public function jobs()
    {
        return $this->hasMany(job_data::class);
    }
}
