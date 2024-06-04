<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\Interfaces\IApplicationService;

class ApplicationController extends Controller
{
    private IApplicationService $applicationService;

    public function __construct(IApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function addApplication(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'nullable|string|max:255',
            'number_of_exper' => 'required|string|max:255',
            'resume' => 'required|file',
            'cover_lettre' => 'required|file',
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if the user has already applied for this job
        $existingApplication = Application::where('user_id', $request->user_id)
                                           ->where('job_id', $request->job_id)
                                           ->first();

        if ($existingApplication) {
            return response()->json(['error' => 'You have already applied for this job.'], 409);
        }

        // Create the application using the validated data and job_id from params
        $applicationData = $validator->validated();


        if ($request->hasFile('resume')) {
            // Get the uploaded file instance
            $resumeFile = $request->file('resume');

            // Define the destination path within the public directory
            $destinationPath = public_path('uploads');

            // Define the file name (optional: you can customize the file name as needed)
            $resumeFileName = time() . '_' . $resumeFile->getClientOriginalName();

            // Move the file to the public directory
            $resumeFile->move($destinationPath, $resumeFileName);

            // Save the file path to the application data
            $applicationData['resume'] = 'uploads/' . $resumeFileName;
        }

        if ($request->hasFile('cover_lettre')) {
            // Get the uploaded file instance
            $coverLettreFile = $request->file('cover_lettre');

            // Define the destination path within the public directory
            $destinationPath = public_path('uploads');

            // Define the file name (optional: you can customize the file name as needed)
            $coverLettreFileName = time() . '_' . $coverLettreFile->getClientOriginalName();

            // Move the file to the public directory
            $coverLettreFile->move($destinationPath, $coverLettreFileName);

            // Save the file path to the application data
            $applicationData['cover_lettre'] = 'uploads/' . $coverLettreFileName;
        }



        $application = Application::create($applicationData);

        // Return a JSON response with the created application data
        return response()->json(['application' => $application]);
    }

    // public function update(Request $request)
    // {
    //     $company = $this->companyService->updateCompany($request);
    //     return response()->json(['jobDataUpdated'=> $company]);
    // }

    public function getAllApplications()
    {
        $applications = Application::with('job')->get();
        return response()->json(['applications' => $applications]);
    }

    public function getAllApplicationsById($user_id)
    {
        $applications = Application::where('user_id', $user_id)
                                ->with(['job.company'])
                                ->get();

    return response()->json(['applications' => $applications]);
    }

    public function getJobsWithApplications($user_id)
    {
        $jobs = Job::where('user_id', $user_id)
                    ->with(['applications', 'company'])
                    ->get();

        return response()->json(['jobs' => $jobs]);
    }


}
