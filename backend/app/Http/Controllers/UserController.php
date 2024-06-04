<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Interfaces\IUserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    private IUserService $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function addUser(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'string|in:seeker,employer,admin', // Adjust as per your requirements
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new User model instance
        $user = new User();

        // Fill the user model with validated data
        $user->fill($validator->validated());

        // Hash the password before saving
        $user->password = bcrypt($request->password);

        // Attempt to save the user to the database
        try {
            $user->save();
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error saving user: ' . $e->getMessage());
            // Return a JSON response indicating failure
            return response()->json(['error' => 'Failed to save user'], 500);
        }
        $token = JWTAuth::fromUser($user);

        // Return a response indicating success and the user data
        return response()->json([
            'userData' => $user,
            'token' => $token
    ], 201);
    }



    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getUser(Request $request)
    {
        $user = $this->userService->getUser($request);
        return $user;
    }

    public function getAllUsers()
    {
        $users = $this->userService->getAllUsers();
        return response()->json(['users'=> $users]);
    }

    public function updateUserName(Request $request, $id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        // Update the user's username
        $user->update($validatedData);

        // Generate JWT token for the updated user
        $token = JWTAuth::fromUser($user);

        // Return a JSON response with the token and updated user data
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
}
