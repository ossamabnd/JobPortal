<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ICompanyRepository;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class CompanyRepository implements ICompanyRepository
{
    protected $model;

    public function _construct(Company $company)
    {
        $this->model = $company;
    }

    public function AddCompany(Company $company)
    {
        $company->save();
        return $company;
    }

    public function updateCompany(Request $request)
    {
        $company = Company::where('id', $request->id)->first();

        if($request->file('logo')){
            $path = 'storage/images/companiesLogos';
            $completeName = $request->file('logo')->getClientOriginalName();
            $fileName = pathinfo($completeName,PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $compPic= str_replace(' ','_',$fileName).'_'.time().'.'.$extension;
            $request->logo->move($path,$compPic);
            // dd($path);
        }

        $company->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $compPic,
            ]);

        return $company;

    }

    public function getAllCompanies()
    {
        $companies = DB::table('companies')
                    ->get();
        return $companies;
    }
}
