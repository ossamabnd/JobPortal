<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IUserRepository;
use App\Models\User;
// use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;


class UserRepository implements IUserRepository
{
    protected $model;

    public function _construct(User $user)
    {
        $this->model = $user;
    }

    public function AddUser(User $user)
    {
        $user->save();
        return $user;
    }

    public function getUser(Request $request)
    {
        $searchedUser =  User::where('email', $request->email)->first();

        // if(!$searchedUser) {
        //     throw ValidationException::withMessages([
        //         'email' =>["No account found, there's no account with the email you provided."],
        //     ]);
        // }
        // elseif (!Hash::check($request->password, $searchedUser->password)){
        //     throw ValidationException::withMessages([
        //         'password' =>["this password  doesn't match this email"],
        //     ]);
        // }else{
        //     return response([
        //     "token" => $searchedUser->createToken("Frontend App")->accessToken,
        //     "user" => $searchedUser
        // ]);
        // }
        return $searchedUser;

    }

    public function getAllUsers(){

        $users = DB::table('users')
                    ->get();
        return $users;
    }

    public function updateUserName(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->update([
            'username' => $request->fullName
        ]);
        return $user;
    }

}
?>
