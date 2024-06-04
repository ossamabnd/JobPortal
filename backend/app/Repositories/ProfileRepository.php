<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IProfileRepository;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ProfileRepository implements IProfileRepository
{
    protected $model;

    public function _construct(Profile $profile)
    {
        $this->model = $profile;
    }

    public function AddProfile(Profile $profile)
    {
        $profile->save();
        return $profile;
    }

    public function updateProfile(Request $request)
    {
        $profile = Profile::where('email', $request->email)->first();

        if($request->file('image')){
            $path = 'storage/images/profiles';
            $completeName = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($completeName,PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $compPic= str_replace(' ','_',$fileName).'_'.time().'.'.$extension;
            $request->image->move($path,$compPic);
            // dd($path);
        }

        if($request->file('resume')){
            $path = 'storage/resumes';
            $completeName = $request->file('resume')->getClientOriginalName();
            $fileName = pathinfo($completeName,PATHINFO_FILENAME);
            $extension = $request->file('resume')->getClientOriginalExtension();
            $compRes= str_replace(' ','_',$fileName).'_'.time().'.'.$extension;
            $request->resume->move($path,$compRes);
            $profile->update([
            'username' => $request->input('fullName'),
            'phone_number' => $request->input('phoneNumber'),
            'position' => $request->input('position'),
            'number_of_exper' => $request->input('number_of_exper'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'image' => $compPic,
            'resume' => $compRes,
            'about' => $request->about,
            'skills'=> $request->skills
            ]);
        }else{
             $profile->update([
            'username' => $request->input('fullName'),
            'phone_number' => $request->input('phoneNumber'),
            'position' => $request->input('position'),
            'number_of_exper' => $request->input('number_of_exper'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'image' => $compPic,
            'about' => $request->about,
            'skills'=> $request->skills
            ]);

        }



        return $profile;

    }

    public function getProfile(Request $request)
    {
        $searchedUser =  Profile::where('user_id', $request->userId)->first();
        return $searchedUser;

    }

    public function getAllProfiles(){

        $usersIds = DB::table('users')
                    ->select('id')
                    ->where('users.role', 'Job Seeker')
                    ->get()
                    ->pluck('id')
                    ->values();

        $profiles = DB::table('profiles')
                    ->whereIn('profiles.user_id',$usersIds)
                    ->get();

        return $profiles;
    }
}
?>
