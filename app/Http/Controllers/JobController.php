<?php

// app/Http/Controllers/JobController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\jb_process;
use App\Models\job_data;
use App\Models\User;
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

    public function view_response(Request $request)
    {
        $jobId = $request->id;

        // Fetch all job process data for the specified job ID
        $jobProcesses = jb_process::where('job_id', $jobId)->get();

        // Check if any job process data exists
        if ($jobProcesses->isEmpty()) {
            return response()->json(['message' => 'No job responses found.'], 404);
        }

        // Prepare an array to store the responses
        $responses = [];

        // Loop through each job process and fetch receiver's user data
        foreach ($jobProcesses as $jobProcess) {
            $receiverUser = User::find($jobProcess->receiver_id);

            // Skip if the receiver user is not found
            if (!$receiverUser) {
                continue;
            }

            // Add the combined job process and receiver data to the responses array
            $responses[] = [
                'jb_process_status' => $jobProcess->status,
                'payment_send' => $jobProcess->payment_send,
                'payment_received' => $jobProcess->payment_received,
                'payer_id' => $jobProcess->payer_id,
                'receiver_id' => $jobProcess->receiver_id,
                'receiver_name' => $receiverUser->name,
                'receiver_phone' => $receiverUser->phone,
                'receiver_whatsapp' => $receiverUser->whatsapp,
            ];
        }

        // Check if responses array is empty (all receiver users were missing)
        if (empty($responses)) {
            return response()->json(['message' => 'No valid responses found.'], 404);
        }
        // Return all responses as JSON
        return response()->json($responses);
    }




    public function hireCandidate(Request $request)
    {
        $receiver_id = $request->input('receiver_id');

        try {
            $response = jb_process::where('receiver_id', $receiver_id)->firstOrFail();
            $response->status = 'hired'; // Update the status to hired
            $response->save();

            return response()->json(['message' => 'Candidate hired successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error hiring candidate.', 'error' => $e->getMessage()], 500);
        }
    }

    public function rejectCandidate(Request $request)
    {
        $receiver_id = $request->input('receiver_id');

        try {
            $response = jb_process::where('receiver_id', $receiver_id)->firstOrFail();
            $response->status = 'rejected'; // Update the status to rejected
            $response->save();

            return response()->json(['message' => 'Candidate rejected successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error rejecting candidate.', 'error' => $e->getMessage()], 500);
        }
    }

    public function delete_job(Request $request)
    {
        // Validate input
        $id = $request->job_id;
        if (!$id) {
            return response()->json(['message' => 'Job ID is required'], 400);
        }
    
        // Log received job ID for debugging
        \Log::info("Job deletion request received for job_id: " . $id);
    
        $job_processes = jb_process::where('job_id', $id);
        if ($job_processes->exists()) {
            \Log::info("Found " . $job_processes->count() . " job_process records. Deleting...");
            $job_processes->delete();
        } else {
            \Log::info("No job_process records found for job_id: " . $id . ". Proceeding with job deletion.");
        }
    
        $job_data = job_data::find($id);
        if (!$job_data) {
            \Log::warning("Job with ID $id not found. Cannot delete.");
            return response()->json(['message' => 'Job not found'], 404);
        }
    
        // Delete job_data record
        $job_data->delete();
        \Log::info("Successfully deleted job_data for job_id: " . $id);
    
        return response()->json(['message' => 'Job deleted successfully']);
    }
    
    
}
