<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{
    // Create a new employee
    public function store(Request $request)
    {
        $request->validate([
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'age' => 'required|integer|min:18',
            'StartWork' => 'required|date',
            'EmployeeImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Evalute' => 'required|integer',
        ]);
    
        $imagePath = null;
        if ($request->hasFile('EmployeeImage')) {
            $imagePath = $request->file('EmployeeImage')->store('images', 'public');
        }
    
        $employee = Employee::create([
            'FirstName' => $request->FirstName,
            'LastName' => $request->LastName,
            'age' => $request->age,
            'StartWork' => $request->StartWork,
            'EmployeeImage' => $imagePath ? url('storage/' . $imagePath) : null,
            'Evalute' => $request->Evalute,
        ]);
    
        return response()->json([
            'message' => 'Employee created successfully',
            'data' => $employee,
        ], 201);
    }
    
    public function index()
    {
        $employees = Employee::all();

        return response()->json([
            'message' => 'Employees retrieved successfully',
            'data' => $employees,
        ]);
    }

    // Get a specific employee
    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json([
            'message' => 'Employee retrieved successfully',
            'data' => $employee,
        ]);
    }

    // Update a specific employee
    public function update(Request $request, $id)
    {
        $request->validate([
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'age' => 'required|integer|min:18',
            'StartWork' => 'nullable|date', 
            'EmployeeImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Evalute' => 'required|integer',
        ]);
    
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    
        if ($request->hasFile('EmployeeImage')) {
            if ($employee->EmployeeImage && Storage::disk('public')->exists($employee->EmployeeImage)) {
                Storage::disk('public')->delete($employee->EmployeeImage);
            }
    
            $imagePath = $request->file('EmployeeImage')->store('images', 'public');
            $employee->EmployeeImage = $imagePath;
        }
    
        $employee->FirstName = $request->FirstName;
        $employee->LastName = $request->LastName;
        $employee->age = $request->age;
        $employee->StartWork = $request->StartWork;
        $employee->Evalute = $request->Evalute;
        $employee->save();
    
        return response()->json([
            'message' => 'Employee updated successfully',
            'data' => $employee,
        ]);
    }
    


    // Delete a specific employee
        public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        $imagePath = public_path($employee->EmployeeImage);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully',
        ]);
    }

}
