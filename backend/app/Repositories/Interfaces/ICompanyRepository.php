<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;
use App\Models\Company;


interface ICompanyRepository
{
    public function addCompany(Company $company);

    public function updateCompany(Request $request);

    public function getAllCompanies();

}
