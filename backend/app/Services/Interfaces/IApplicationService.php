<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IApplicationService
{
    public function addApplication(Request $request);

    public function getAllApplications();
}
