<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IApplicationRepository;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ApplicationRepository implements IApplicationRepository
{
    protected $model;

    public function _construct(Application $application)
    {
        $this->model = $application;
    }

    public function AddApplication(Application $application)
    {
        $application->save();
        return $application;
    }

    public function getAllApplications(){

        $applications = DB::table('applications')
                    ->get();
        return $applications;
    }
}
