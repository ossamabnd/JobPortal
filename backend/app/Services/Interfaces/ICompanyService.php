<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface ICompanyService
{
    public function addCompany(Request $request);

    public function updateCompany(Request $request);

    public function getAllCompanies();


}
