<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'website',
        'user_id',
        'city',
        'country',
        'phone_number',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }
}
