<?php

return [
    'welcome' => 'Welcome to our application!',
    'hello' => 'Hello, :name',
    'goodbye' => 'Goodbye, :name!',
    'user' => [
        'created' => 'User created successfully.',
        'updated' => 'User updated successfully.',
        'deleted' => 'User deleted successfully.',
        'not_found' => 'User not found.',
    ],
    'post' => [
        'created' => 'Post created successfully.',
        'updated' => 'Post updated successfully.',
        'deleted' => 'Post deleted successfully.',
        'not_found' => 'Post not found.',
    ],
    'validation' => [
        'required' => 'The :attribute field is required.',
        'email' => 'The :attribute must be a valid email address.',
        'max' => [
            'string' => 'The :attribute may not be greater than :max characters.',
        ],
        'min' => [
            'string' => 'The :attribute must be at least :min characters.',
        ],
    ],
    'auth' => [
        'failed' => 'These credentials do not match our records.',
        'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    ],
];
