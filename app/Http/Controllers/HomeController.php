<?php

namespace App\Http\Controllers;

use App\Models\job_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
public function fetch_available_jobs()
{
    $user = Auth::user();
    $user_age = $user->dob ? $this->calculateAge($user->dob) : null;
    $user_gender = $user->gender;

    // Ensure age and gender are set
    if (is_null($user_age) || is_null($user_gender)) {
        return response()->json(['error' => 'User age or gender not defined'], 400);
    }

    // Fetch jobs with 'approved' status and apply filters
    $my_jobs = job_data::with('category', 'user')
        ->where('job_status', 'approved') // Get only approved jobs
        ->where('min_age', '<=', $user_age) // Age must be within range
        ->where('max_age', '>=', $user_age)
        ->where(function ($query) use ($user_gender) {
            $query->where('both', '>', 0) // Jobs available for both genders
                ->orWhere(function ($subQuery) use ($user_gender) {
                    if ($user_gender === 'male') {
                        $subQuery->where('male', '>', 0); // Jobs for males
                    } else {
                        $subQuery->where('female', '>', 0); // Jobs for females
                    }
                });
        })
        ->get(); // Fetch the jobs

    // Flatten the job data into a single-level array
    $transformed_jobs = $my_jobs->map(function ($job) {
        return [
            'id' => $job->id,
            'title' => $job->title,
            'description' => $job->description,
            'category_name' => $job->category->category_name ?? 'N/A',
            'category_image' => $job->category->category_image ?? 'N/A',
            'location' => $job->location,
            'salary' => $job->salary,
            'min_age' => $job->min_age,
            'max_age' => $job->max_age,
            'start_date' => $job->start_date,
            'end_date' => $job->end_date,
            'job_status' => $job->job_status,
            'poster_contact_number' => $job->user->phone ?? 'N/A', // Replace 'phone' with your actual DB field name
            'poster_whatsapp' => $job->user->whatsapp ?? 'N/A', // Replace 'whatsapp' with your actual DB field name
        ];
    });

    // Return the transformed data as a JSON response
    return response()->json($transformed_jobs);
}


    private function calculateAge($dob)
    {
        $dobDate = new \DateTime($dob);
        $currentDate = new \DateTime();
        $age = $dobDate->diff($currentDate)->y;
        return $age;
    }

    public function apply_to_job($job_id)
    {
        $user_id = Auth::id();
    }
}
