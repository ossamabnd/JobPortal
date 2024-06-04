<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Interfaces\ICompanyService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CompanyController extends Controller
{
    private ICompanyService $companyService;

    public function __construct(ICompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function addCompany(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'phone_number' => 'nullable|string|max:255',
            'image' => 'nullable|file|max:2048', // Max size 2MB, and must be an image
            'website' => 'nullable|string|max:255',
            'city' => 'required|string',
            'country' => 'required|string',
            'user_id' => 'required|exists:users,id', // Ensure the user_id exists in the users table
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Find company by user ID
        $company = Company::where('user_id', $data['user_id'])->first();

        if (!$company) {
            // If company doesn't exist for the user, create a new company
            $company = Company::create($data);
        } else {
            // Update the existing company
            $company->update($data);
        }

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $company->image = $imageName;
            $company->save();
        }

        // Return a response indicating success and the created/updated company data
        return response()->json(['company' => $company]);
    }

    // public function updateCompany(Request $request, $id)
    // {
    //     // Find the company by ID
    //     $company = Company::find($id);

    //     // Check if the company exists
    //     if (!$company) {
    //         return response()->json(['error' => 'Company not found'], 404);
    //     }

    //     // Validate the incoming request data
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'image' => 'nullable|string|max:255',
    //         'website' => 'nullable|string|max:255',
    //         'user_id' => 'exists:users,id',
    //     ]);

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // Update the company with the validated data
    //     $company->update($validator->validated());

    //     // Return a JSON response with the updated company data
    //     return response()->json(['company' => $company]);
    // }
    public function getCompany($user_id)
    {
        // Find the company by user ID
        $company = Company::where('user_id', $user_id)->first();

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        // Return the company information
        return response()->json(['company' => $company], 200);
    }
    public function getAllCompanies()
    {
        $companies = $this->companyService->getAllCompanies();
        return $companies;
    }


        public function destroy($id)
        {
            $company = Company::findOrFail($id);
            $userId = $company->user_id;

            // Delete the company
            $company->delete();

            // Delete the associated user
            User::where('id', $userId)->delete();

            return response()->json(['message' => 'Company and associated user deleted successfully'], 200);
        }
    }


