<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IProfileService
{
    public function addProfile(Request $request);

    public function updateProfile(Request $request);

    public function getAllProfiles();

    public function getProfile(Request $request);


}
