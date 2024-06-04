<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function getWelcomeMessage()
    {
        $message = __('messages.welcome');
        return response()->json(['message' => $message]);
    }

    public function getPersonalizedGreeting(Request $request)
    {
        $name = $request->input('name', 'Guest');
        return response()->json([
            'message' => __('messages.hello', ['name' => $name]),
        ]);
    }
}
