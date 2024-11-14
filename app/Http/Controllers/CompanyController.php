<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Create a new company
    public function store(Request $request)
    {
        $request->validate([
            'companyName' => 'required|string|max:255',
            'description' => 'required|string',
            'services' => 'required|string',
            'Email' => 'required|email',
            'phone1' => 'required|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'Address' => 'required|string',
            'Lat' => 'required|numeric',
            'Lang' => 'required|numeric',
            'comments' => 'nullable|string|max:1000'
        ]);

        $company = company::create($request->all());

        return response()->json([
            'message' => 'Company created successfully.',
            'data' => $company,
        ], 201);
    }

    // Get all companies
    public function index()
    {
        $companies = company::all();

        return response()->json([
            'message' => 'Companies retrieved successfully.',
            'data' => $companies,
        ]);
    }

    // Get a single company by ID
    public function show($id)
    {
        $company = company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        return response()->json([
            'message' => 'Company retrieved successfully.',
            'data' => $company,
        ]);
    }

    // Update a company
    public function update(Request $request, $id)
    {
        $request->validate([
            'companyName' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'services' => 'nullable|string',
            'Email' => 'nullable|email',
            'phone1' => 'nullable|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'Address' => 'nullable|string',
            'Lat' => 'required|numeric',
            'Lang' => 'required|numeric',
            'comments' => 'nullable|string|max:1000'
        ]);

        $company = company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        $company->update($request->all());

        return response()->json([
            'message' => 'Company updated successfully.',
            'data' => $company,
        ]);
    }

    // Delete a company
    public function destroy($id)
    {
        $company = company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        $company->delete();

        return response()->json(['message' => 'Company deleted successfully.']);
    }
}
