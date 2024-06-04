<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Services\Interfaces\IUserService;
use App\Repositories\Interfaces\IUserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;



class UserService implements IUserService
{
    protected $repository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }
    public function addUser(Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:255',
            'email'=>'required|email|unique:users',
            'password' => [
                'required',
                Password::min(6)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'password_confirmation' => 'required|same:password',
        ]);
        $user = new User();
        $user->username = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;

        $user = $this->repository->addUser($user);

        return $user;
    }

    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }

    public function getUser(Request $request)
    {
        // $request->validate([
        //     // 'email'=>'required||email',
        // ]);
        // $credentials = request(['email','password']);
        $credentials = ['email'=>$request->email,'password'=>$request->password];
        if(! $token = auth()->attempt($credentials)){
            return response()->json(['error'=>'Email Or Password is not matches'],401);
        }
        $user = $this->repository->getUser($request);
        return response()->json([
            "token"=>$token,
            "user" => $user
        ]);
    }

    public function getAllUsers()
    {
        $users = $this->repository->getAllUsers();
        return $users;
    }

    public function updateUserName(Request $request)
    {
        $request->validate([
            'fullName' => 'required',
            'email'=>'required',
        ]);
        $user = $this->repository->updateUserName($request);
        return $user;
    }

}
