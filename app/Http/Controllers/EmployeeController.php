<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

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
            'EmployeeImage' => 'required|string',
            'Evalute' => 'required|integer',
        ]);



        // Create a new employee record
        $employee = Employee::create([
            'FirstName' => $request->FirstName,
            'LastName' => $request->LastName,
            'age' => $request->age,
            'StartWork' => $request->StartWork,
            'EmployeeImage' => $request->EmployeeImage,
            'Evalute' => $request->Evalute,
        ]);

        return response()->json([
            'message' => 'Employee created successfully',
            'data' => $employee,
        ], 201);
    }

    // Get all employees
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
            'FirstName' => 'sometimes|required|string|max:255',
            'LastName' => 'sometimes|required|string|max:255',
            'age' => 'sometimes|required|integer|min:18',
            'StartWork' => 'sometimes|required|date',
            'EmployeeImage' => 'sometimes|required|string',
            'Evalute' => 'sometimes|required|integer',
        ]);

        $employee = Employee::findOrFail($id);

        // Store the employee image if it was uploaded
        if ($request->hasFile('EmployeeImage')) {
            $imagePath = $request->file('EmployeeImage')->store('employees', 'public');
            $employee->EmployeeImage = $imagePath;
        }

        // Update employee details
        $employee->update($request->only('FirstName', 'LastName', 'age', 'StartWork', 'Evalute'));

        return response()->json([
            'message' => 'Employee updated successfully',
            'data' => $employee,
        ]);
    }

    // Delete a specific employee
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully',
        ]);
    }
}
