<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;
use App\Models\Profile;


interface IProfileRepository
{
    public function getProfile(Request $request);

    public function addProfile(Profile $profile);

    public function updateProfile(Request $request);

    public function getAllProfiles();
}
