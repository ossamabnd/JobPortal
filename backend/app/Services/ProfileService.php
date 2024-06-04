<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Services\Interfaces\IProfileService;
use App\Repositories\Interfaces\IProfileRepository;
use App\Models\Profile;

class ProfileService implements IProfileService
{
    protected $repository;

    public function __construct(IProfileRepository $profileRepository)
    {
        $this->repository = $profileRepository;
    }

    public function addProfile(Request $request){
        $request->validate([
            'fullName' => 'required',
            'email' => 'required|unique:profiles',
            'userId'=>'required',
        ]);

        $profile = new Profile();
        $profile->username = $request->fullName;
        $profile->email = $request->email;
        $profile->user_id = $request->userId;

        $profile = $this->repository->addProfile($profile);

        return $profile;
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'email' => 'required',
            'position' => 'required',
            'city' => 'required',
            'country' => 'required'
        ]);

        $profile = $this->repository->updateProfile($request);

        return $profile;
    }

    public function getAllProfiles()
    {

        $profiles = $this->repository->getAllProfiles();
        return $profiles;
    }

    public function getProfile(Request $request)
    {
        $profile = $this->repository->getProfile($request);
        return $profile;
    }

}

