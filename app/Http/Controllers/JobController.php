<?php

// app/Http/Controllers/JobController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\job_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id', // Ensure category exists
            'location' => 'required|string|max:255',
            'minAge' => 'required|integer|min:0',
            'maxAge' => 'required|integer|min:0|gte:minAge',
            'salary' => 'required|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'male' => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
            'both' => 'required|integer|min:0',
        ]);

        // Save data to the database
        $job = new job_data();
        $job->title = $validatedData['title'];
        $job->description = $validatedData['description'];
        $job->category_id = $validatedData['category_id'];
        $job->location = $validatedData['location'];
        $job->min_age = $validatedData['minAge'];
        $job->max_age = $validatedData['maxAge'];
        $job->salary = $validatedData['salary'];
        $job->job_status = "Pending";
        $job->start_date = $validatedData['start_date'];
        $job->end_date = $validatedData['end_date'];
        $job->male = $validatedData['male'];
        $job->female = $validatedData['female'];
        $job->both = $validatedData['both'];
        $job->user_id = Auth::id();
        $job->save();

        // Return success response
        return response()->json([
            'message' => 'Job created successfully!',
            'job' => $job,
        ], 201);
    }


public function fetch_my_jobs()
{
    // Get the authenticated user's ID
    $userId = Auth::id();

    // Fetch jobs created by the authenticated user and eager load the associated category
    $my_jobs = job_data::with('category')->where('user_id', $userId)->get();

    // Transform the job data to include both job and category details in the same array
    $my_jobs = $my_jobs->map(function ($job) {
        return [
            'job_id' => $job->id,
            'title' => $job->title,
            'description' => $job->description,
            'category_id' => $job->category_id,
            'category_name' => $job->category->category_name, // Accessing category's name
            'category_image' => $job->category->category_image, // Accessing category's image
            'location' => $job->location,
            'male' => $job->male,
            'female' => $job->female,
            'both' => $job->both,
            'min_age' => $job->min_age,
            'max_age' => $job->max_age,
            'salary' => $job->salary,
            'start_date' => $job->start_date,
            'end_date' => $job->end_date,
            'job_status' => $job->job_status,
            'created_at' => $job->created_at,
            'updated_at' => $job->updated_at,
        ];
    });
    // Return the transformed data as a JSON response
    return response()->json($my_jobs);
}


}
