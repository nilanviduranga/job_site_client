<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jb_process extends Model
{
        protected $fillable = [
        'status',
        'payment_send',
        'payment_received',
        'job_id',
        'payer_id',
        'receiver_id',
    ];
public function job_data()
{
    return $this->belongsTo(job_data::class, 'job_id', 'id');
}


public function view_response($id)
{
    // Fetch the job process data for the specified job ID
    $jobProcess = jb_process::where('job_id', $id)->first();

    // If no job process data is found, return an error response
    if (!$jobProcess) {
        return response()->json(['message' => 'Job process not found.'], 404);
    }

    // Get the receiver's user data using the receiver_id from the job process table
    $receiverUser = User::find($jobProcess->receiver_id);

    // If no user data is found for the receiver, return an error response
    if (!$receiverUser) {
        return response()->json(['message' => 'Receiver not found.'], 404);
    }

    // Prepare the response data containing job process data and receiver's user info
    $transformedData = [
        // Data from the jb_process model
        'jb_process_status' => $jobProcess->status,
        'payment_send' => $jobProcess->payment_send,
        'payment_received' => $jobProcess->payment_received,
        'payer_id' => $jobProcess->payer_id,
        'receiver_id' => $jobProcess->receiver_id,

        // Receiver user data
        'receiver_name' => $receiverUser->name,
        'receiver_phone' => $receiverUser->phone,
        'receiver_whatsapp' => $receiverUser->whatsapp,
    ];
dd($transformedData);
    // Return the transformed data as a JSON response
    return response()->json($transformedData);
}


}
