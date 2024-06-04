<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Services\Interfaces\IJobService;

class JobController extends Controller
{
    private IJobService $jobService;

    public function __construct(IJobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function addJob(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
            'yearofexperienceRef'=>'nullable|string',
            'start_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id'
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the job using the validated data
        $job = Job::create($validator->validated());

        // Return a JSON response with the created job data
        return response()->json(['jobData' => $job]);
    }

    // public function updateJob(Request $request, $id)
    // {
    //     // Find the job by ID
    //     $job = Job::find($id);

    //     // Check if the job exists
    //     if (!$job) {
    //         return response()->json(['error' => 'Job not found'], 404);
    //     }

    //     // Validate the incoming request data
    //     $validator = Validator::make($request->all(), [
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'type' => 'nullable|string|max:255',
    //         'salary' => 'nullable|string|max:255',
    //         'start_date' => 'nullable|date',
    //         'expiration_date' => 'nullable|date',
    //         'is_active' => 'nullable|boolean',
    //         'city' => 'nullable|string|max:255',
    //         'country' => 'nullable|string|max:255',
    //         'category' => 'required|string|max:255',
    //         'company_id' => 'exists:companies,id',
    //         'user_id' => 'exists:users,id',
    //     ]);

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // Update the job with the validated data
    //     $job->update($validator->validated());

    //     // Return a JSON response with the updated job data
    //     return response()->json(['jobData' => $job]);
    // }

    public function getAllJobsByCompany($id)
    {
        // Retrieve all jobs associated with the given user ID
        $jobs = Job::where('user_id', $id)->get();

        // Return the jobs as a JSON response
        return response()->json(['jobs' => $jobs]);
    }

    public function jobDetails($id)
    {
        // Retrieve the job details from the database based on the provided ID
        $job = Job::with('company')->findOrFail($id);

        // Return the job details along with the company name as a JSON response
        return response()->json(['job' => $job]);
    }

    public function getAllJobs()
    {
        // Eager load the company relationship
        $jobs = Job::with('company')->get();

        return response()->json(['jobs' => $jobs]);
    }

    public function getLastJobs()
    {
        $jobs = $this->jobService->getLastJobs();
        return response()->json(['jobs'=> $jobs]);
    }

    public function searchJobs(Request $request)
    {
        $jobs = $this->jobService->searchJobs($request);
        return response()->json(['jobs'=> $jobs]);
    }

    public function destroy($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return response()->json([
                'message' => 'Job not found'
            ], 404);
        }
        $job->delete();
        return response()->json([
            'message' => 'Job deleted successfully'
        ], 200);
    }

}
