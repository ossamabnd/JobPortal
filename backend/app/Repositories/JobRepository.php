<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IJobRepository;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class JobRepository implements IJobRepository
{
    protected $model;

    public function _construct(Job $job)
    {
        $this->model = $job;
    }

    public function AddJob(Job $job)
    {
        $job->save();
        return $job;
    }

    public function updateJob(Request $request)
    {
        $job = Job::where('id', $request->id)->first();

        // if($request->file('image')){
        //     $completeName = $request->file('image')->getClientOriginalName();
        //     $fileName = pathinfo($completeName,PATHINFO_FILENAME);
        //     $extension = $request->file('image')->getClientOriginalExtension();
        //     $compPic= str_replace(' ','_',$fileName).'_'.time().'.'.$extension;
        //     $imagePath = $request->file('image')->storeAs('public/images/profiles',$compPic);
        //     // dd($path);
        // }

        // if($request->file('resume')){
        //     $completeName = $request->file('resume')->getClientOriginalName();
        //     $fileName = pathinfo($completeName,PATHINFO_FILENAME);
        //     $extension = $request->file('resume')->getClientOriginalExtension();
        //     $compPic= str_replace(' ','_',$fileName).'_'.time().'.'.$extension;
        //     $resumePath = $request->file('resume')->storeAs('public/resumes',$compPic);
        // }

        $job->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'salary'=>$request->input('salary'),
            'category' => $request->input('category'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'start_date' => $request->input('startDate')
            ]);
            
        $jobs = DB::table('jobs')
                ->get();
        return $jobs;

    }

    public function getAllJobs(){

        $jobs = DB::table('jobs')
                    ->get();
        return $jobs;
    }

    public function getLastJobs()
    {
        $lastJobs = Job::latest()->take(5)->get();
        return $lastJobs;
    }

    public function searchJobs(Request $request)
    {
        $query = DB::table('jobs');

        if ($request->type != 'undefined' && $request->type != '') {
            $query->where('type', $request->type);
        }
        if ($request->category != 'undefined' && $request->category != '') {
            $query->where('category', $request->category);
        }
        if ($request->city != 'undefined' && $request->city != '') {
            $query->where('city', $request->city);
        }
        if ($request->country != 'undefined' && $request->country != '') {
            $query->where('country', $request->country);
        }

        $jobs = $query->get();
        return $jobs;

    }
}
?>
