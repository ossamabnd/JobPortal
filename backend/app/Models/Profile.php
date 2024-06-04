<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'email',
        'phone_number',
        'position',
        'number_of_exper',
        'image',
        'resume',
        'city',
        'country',
        'about',
        'skills',
        'user_id'
    ];
}
