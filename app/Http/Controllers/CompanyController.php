<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'comments' => 'nullable|string|max:1000',
            'password'=>'required|string',
            'facebookLink'=>'required|string',
            'instagramLink'=>'required|string'
        ]);

        $company = company::create([
            'companyName' => $request->companyName,
            'description' => $request->description,
            'services' => $request->services,
            'Email' => $request->Email,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'Address' => $request->Address,
            'Lat' => $request->Lat,
            'Lang' => $request->Lang,
            'comments' => $request->comments,
            'password' => Hash::make($request->password),
            'facebookLink'=>$request->facebookLink,
            'instagramLink'=>$request->instagramLink 
        ]);

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
            'comments' => 'nullable|string|max:1000',
            'password'=>'required|string'
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
    public function Login(Request $request)
    {
        $request->validate([
            'Email' => 'required|email', 
            'password' => 'required|string', 
        ]);

        
        $company = company::where('Email', $request->Email)->first();

        if (!$company) {
            return response()->json([
                "message" => "Error: email not found"
            ], 404);
        }

        
        if (!(Hash::check($request->password, $company->password))) {
            return false;
        }
        return true;
    }
        public function changePassword(Request $request)
    {
        
        $request->validate([
            'Email' => 'required|email',
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string'
        ]);

        $company = company::where('Email', $request->Email)->first();

        if (!$company) {
            return response()->json([
                "message" => "Error: email not found"
            ], 404);
        }
        
        if (!Hash::check($request->current_password, $company->password)) {
            return response()->json([
                "message" => "Error: incorrect current password"
            ], 401);
        }

        $company->password = Hash::make($request->new_password);
        $company->save();

        return response()->json([
            "message" => "Password changed successfully"
        ], 200);
    }


    public function changeFacebookLink(Request $request,$id){
        $validated = $request->validate([
            'facebookLink' => 'required',
        ]);
        $company=company::find($id);
        if(!$company){
            return response()->json(['message'=>'error cannot find company'],404);
            
        }
        $company->facebookLink = $validated['facebookLink'];
        try{    
        $company->save();
        } catch(\Exception $e){
            return response()->json(['message' => 'Failed to update facebook Link'], 500);
        }
        return response()->json(['message'=>'facebook Link changed successfully',
                                'data'=>$company->facebookLink],201);
        
    }
    public function changeinstagramLink(Request $request,$id){
        $validated = $request->validate([
            'instagramLink' => 'required',
        ]);
        $company=company::find($id);
        if(!$company){
            return response()->json(['message'=>'error cannot find company'],404);
            
        }
        $company->instagramLink = $validated['instagramLink'];
        try{    
        $company->save();
        } catch(\Exception $e){
            return response()->json(['message' => 'Failed to update instagram Link'], 500);
        }
        return response()->json(['message'=>'instagram Link changed successfully',
                                'data'=>$company->instagramLink],201);
        
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
