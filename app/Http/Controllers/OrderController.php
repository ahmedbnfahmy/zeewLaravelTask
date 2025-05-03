<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'product_name' => 'required|string',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'status' => 'sometimes|in:pending,shipped',
            ]);
    
            $order = Order::create($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $order
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Order creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }
    public function index(Request $request)
    {
        $query = Order::with('customer');
        
        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['pending', 'shipped'])) {
            $query->where('status', $request->status);
        }
        
        // Filter by customer_id if provided
        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        
        // Filter by price range if provided
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        $orders = $query->get();
        
        return response()->json($orders);
    }
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,shipped',
        ]);

        $order->update($validated);
        
        return response()->json($order);
    }

    public function stats()
    {
        $stats = [
            'total_revenue' => Order::sum('price'),
            'orders_by_status' => Order::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
        ];
        
        return response()->json($stats);
    }
}