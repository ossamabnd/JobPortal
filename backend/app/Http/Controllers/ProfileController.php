<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Interfaces\IProfileService;

class ProfileController extends Controller
{
    private IProfileService $profileService;

    public function __construct(IProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function addProfile(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'number_of_exper' => 'nullable|string|max:255',
            'image' => 'nullable|file|max:2048', // Max size 2MB, and must be an image
            'resume' => 'nullable|file|max:2048', // Max size 2MB, and must be pdf, doc, or docx
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'skills' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id', // Ensure the user_id exists in the users table
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Find profile by user ID
        $profile = Profile::where('user_id', $data['user_id'])->first();

        if (!$profile) {
            // If profile doesn't exist for the user, create a new profile
            $profile = Profile::create($data);
        } else {
            // Update the existing profile
            $profile->update($data);
        }

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $profile->image = $imageName;
            $profile->save();
        }

        // Upload resume
        if ($request->hasFile('resume')) {
            $resume = $request->file('resume');
            $resumeName = $resume->getClientOriginalName();
            $resume->move(public_path('uploads'), $resumeName);
            $profile->resume = $resumeName;
            $profile->save();
        }

        // Return a response indicating success and the created/updated profile data
        return response()->json(['profile' => $profile]);
    }


    // public function updateProfile(Request $request, $id)
    // {
    //     // Find the profile by ID
    //     $profile = Profile::findOrFail($id);
    //     // Validate the incoming request data
    //     $validatedData = $request->validate([
    //         'username' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255',
    //         'phone_number' => 'nullable|string|max:255',
    //         'position' => 'nullable|string|max:255',
    //         'number_of_exper' => 'nullable|string|max:255',
    //         'image' => 'nullable|string|max:255',
    //         'resume' => 'nullable|string|max:255',
    //         'city' => 'nullable|string|max:255',
    //         'country' => 'nullable|string|max:255',
    //         'about' => 'nullable|string',
    //         'skills' => 'nullable|string|max:255',
    //     ]);

    //     // Update the profile with the validated data
    //     $profile->update($validatedData);

    //     // Return a response indicating success and the updated profile data
    //     return response()->json(['profile' => $profile]);
    // }

    public function getProfile(Request $request, $user_id)
    {
        // Find profile by user ID
        $profile = Profile::where('user_id', $user_id)->first();

        if (!$profile) {
            // If profile doesn't exist for the user, return an error response
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Return a response with the profile data
        return response()->json(['profile' => $profile]);
    }

    public function getAllProfiles()
    {
        $profiles = Profile::all();;
        return response()->json(['profiles'=> $profiles]);
    }
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $userId = $profile->user_id;

        // Delete the company
        $profile->delete();

        // Delete the associated user
        User::where('id', $userId)->delete();

        return response()->json(['message' => 'profile and associated user deleted successfully'], 200);
    }
    // public function getProfiles(Request $request){
    //     $profiles = $this->profileService->getProfiles($request);
    //     return $profiles;
    // }
}
