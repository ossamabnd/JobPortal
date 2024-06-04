<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IUserService
{
    public function addUser(Request $request);

    public function getUser(Request $request);

    public function getAllUsers();

    public function updateUserName(Request $request);


}
