<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Services\Interfaces\IApplicationService;
use App\Repositories\Interfaces\IApplicationRepository;
use App\Models\Application;

class ApplicationService implements IApplicationService
{
    protected $repository;

    public function __construct(IApplicationRepository $applicationRepository)
    {
        $this->repository = $applicationRepository;
    }

    public function addApplication(Request $request){
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'resume' => 'required',
            'userId'=>'required',
            'jobId'=>'required',
        ]);

        $application = new Application();
        $application->username = $request->username;
        $application->email = $request->email;
        $application->phone_number = $request->phoneNumber;
        $application->number_of_exper = $request->number_of_exper;
        $application->cover_lettre = $request->coverLetter;

        if($request->file('resume')){
            $path = 'storage/resumes';
            $completeName = $request->file('resume')->getClientOriginalName();
            $fileName = pathinfo($completeName,PATHINFO_FILENAME);
            $extension = $request->file('resume')->getClientOriginalExtension();
            $compRes= str_replace(' ','_',$fileName).'_'.time().'.'.$extension;
            $request->resume->move($path,$compRes);
        }
        $application->resume = $compRes;
        $application->user_id = $request->userId;
        $application->job_id = $request->jobId;
        $application = $this->repository->addApplication($application);
        return $application;
    }

    public function getAllApplications()
    {
        $applications = $this->repository->getAllApplications();
        return response()->json([
            "applications" => $applications
        ]);
    }

}
