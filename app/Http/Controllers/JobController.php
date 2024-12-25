<?php

// app/Http/Controllers/JobController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\job_data;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // Create a job post
    public function store(Request $request)
    {
dd('hello');
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'min_age' => 'required|integer|min:0',
            'max_age' => 'required|integer|min:0',
            'salary' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $job = job_data::create($validated);

        return response()->json($job, 201);
    }

}
