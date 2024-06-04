<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ApplicationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware(['auth'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('login', 'getUser'); //DONE
        Route::post('signup', 'addUser'); //DONE
        Route::post('logout', 'logout'); //DONE
        Route::get('getallusers', 'getAllUsers'); //DONE
        Route::post('updateusername/{id}', 'updateUserName'); //DONE

    });
    Route::controller(ProfileController::class)->group(function () {
        // Route::post('getprofile','getProfile');//DONE
        Route::get('getallprofiles', 'getAllProfiles'); //DONE
        // Route:: post('getprofiles','getProfiles');
        Route::post('addprofile', 'addProfile'); //DONE
        Route::get('getprofile/{id}', 'getProfile'); //DONE

    });

    Route::controller(JobController::class)->group(function () {
        Route::post('addjob', 'addJob'); //DONE
        Route::put('updatejob/{id}', 'updateJob'); //DONE
        Route::get('getalljobs', 'getAllJobs'); //DONE
        Route::get('getalljobs/{id}', 'getAllJobsByCompany'); //DONE get all job posted by company id
        Route::get('jobdetaills/{job_id}', 'jobDetails'); //DONE get one job detail using job id
        Route::get('getlastjobs', 'getLastJobs'); //DONE
        Route::post('searchjobs', 'searchJobs'); //DONE
    });
    Route::controller(CompanyController::class)->group(function () {

        Route::post('addcompany', 'addCompany'); //DONE
        Route::put('updatecompany/{id}', 'updateCompany'); //DONE
        Route::get('getallcompanies', 'getAllCompanies'); //DONE
        Route::get('getcompany/{user_id}',  'getCompany');
    });
    Route::controller(ApplicationController::class)->group(function () {
        Route::post('applyjob', 'addApplication'); //done
        Route::get('getallapplications', 'getAllApplications'); //done
        Route::get('getallapplications/{id}', 'getAllApplicationsById'); //done
        Route::get('getjobswithapplications/{id}', 'getJobsWithApplications'); //done
    });

// });

Route::delete('/jobs/{id}', [JobController::class, 'destroy']);
Route::delete('/companies/{id}', [CompanyController::class,'destroy']);
Route::delete('/profiles/{id}', [ProfileController::class,'destroy']);
