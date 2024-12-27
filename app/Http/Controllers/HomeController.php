<?php

namespace App\Http\Controllers;

use App\Models\jb_process;
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

        $job_ids = $this->get_job_ids();

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
            ->whereNotIn('id', $job_ids) // Exclude jobs in $job_ids
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

    private function get_job_ids()
    {
        $userid = Auth::id();
        // dd("aaa");

        // Retrieve job IDs based on user-specific conditions
        $job_ids = jb_process::where('receiver_id', $userid)
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'selected')
                    ->orWhere('status', 'rejected');
            })
            ->pluck('job_id') // Ensure 'id' corresponds to the primary key of the jobs
            ->toArray();

        return $job_ids;
    }

    private function get_jobs()
    {
        $userid = Auth::id();

        // Retrieve all data based on user-specific conditions
        $jobs = jb_process::where('receiver_id', $userid)
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'hired')
                    ->orWhere('status', 'rejected');
            })
            ->get(); // Retrieves all columns of the matching records

        return $jobs;
    }

    public function apply_to_job(Request $request)
    {
        $user_id = Auth::id();
        $jb_process = new jb_process();
        $jb_process->job_id = $request->jobId;
        $jb_process->status = 'Pending'; // Set an initial status
        $jb_process->payer_id = null; // Assuming the user applying is the payer
        $jb_process->receiver_id = $user_id; // Or assign an appropriate receiver ID
        $jb_process->payment_send = false; // Set the payment status to false
        $jb_process->payment_received = false; // Set the payment status to false
        $jb_process->save();

        return response()->json(['message' => 'Job application submitted successfully.']);
    }



    public function fetch_Applyed_jobs()
    {
        $user_id = Auth::id();

        // Retrieve all applied jobs for the current user using get_jobs()
        $jobs = $this->get_jobs();

        // If no jobs are found
        if ($jobs->isEmpty()) {
            return response()->json(['message' => 'No applied jobs found.']);
        }

        // Retrieve job data from the jb_process table with related job_data and user info
        $transformed_jobs = $jobs->map(function ($job_process) {
            // Eager load related job data and the user for the poster info
            $job = $job_process->job_data()->with('category', 'user')->first();

            if (!$job) {
                return null; // If no job data is found, skip this entry
            }

            // Combine jb_process data with job_data
            return [
                // Job data from the job_data model
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
                'poster_contact_number' => $job->user->phone ?? 'N/A',
                'poster_whatsapp' => $job->user->whatsapp ?? 'N/A',

                // Data from the jb_process model
                'jb_process_status' => $job_process->status,
                'payment_send' => $job_process->payment_send,
                'payment_received' => $job_process->payment_received,
                'payer_id' => $job_process->payer_id,
                'receiver_id' => $job_process->receiver_id,
            ];
        });

        // Filter out any null results (jobs that couldn't be found)
        $transformed_jobs = $transformed_jobs->filter(function ($job) {
            return $job !== null;
        });
        // Return the transformed job data as a JSON response
        return response()->json($transformed_jobs);
    }
}
