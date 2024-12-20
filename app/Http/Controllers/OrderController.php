<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // Create a new order
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CustomerFirstName' => 'required|string|max:255',
            'CustomerLastName' => 'required|string|max:255',
            'CustomerPhone' => 'required|string|max:15',
            'CustomerEmail' => 'nullable|email|max:255',
            'Address'=>'nullable|string',
            'OrderDate' => 'required|date',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'EmployeeNumber' => 'required|integer',
            'Lat' => 'required|numeric',
            'Lang' => 'required|numeric',
        ]);
        
        
        if ($validator->fails()) {
            
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 400); 
        }
        
        
        $order = Order::create($validator->validated());
        
        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }

    // Get all orders
    public function index()
    {
        $orders = Order::all();

        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => $orders,
        ]);
    }

    // Get a specific order
    public function show($id)
    {
        $order = Order::findOrFail($id);

        return response()->json([
            'message' => 'Order retrieved successfully',
            'data' => $order,
        ]);
    }

    // Update a specific order
    public function update(Request $request, $id)
    {
        $request->validate([
            'CustomerFirstName' => 'sometimes|nullable|string|max:255',
            'CustomerLastName' => 'sometimes|nullable|string|max:255',
            'CustomerPhone' => 'sometimes|nullable|string|max:15',
            'CustomerEmail' => 'sometimes|nullable|email|max:255',
            'OrderDate' => 'sometimes|nullable|date',
            'start_time' => 'sometimes|nullable|date_format:Y-m-d H:i:s',
            'end_time' => 'sometimes|nullable|date_format:Y-m-d H:i:s|after:start_time',
            'EmployeeNumber' => 'sometimes|nullable|integer',
            'Address'=>'sometimes|nullable|string',
            'Evalute' => 'sometimes|nullable|integer',
            'OrderState' => 'sometimes|nullable|in:pending,processing,completed,cancelled',
            'Lat' => 'sometimes|nullable|numeric',
            'Lang' => 'sometimes|nullable|numeric',
        ]);

        $order = Order::findOrFail($id);
        
        // Update order details
        $order->update($request->all());

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $order,
        ]);
    }

    // Delete a specific order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully',
        ]);
    }
}
