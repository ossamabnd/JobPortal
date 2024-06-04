<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;
use App\Models\Application;


interface IApplicationRepository
{

    public function addApplication(Application $application);

    public function getAllApplications();

}
