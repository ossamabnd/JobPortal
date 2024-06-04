<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;
use App\Models\Job;


interface IJobRepository
{

    public function addJob(Job $job);

    public function updateJob(Request $request);

    public function getAllJobs();

    public function getLastJobs();

    public function searchJobs(Request $request);
}
