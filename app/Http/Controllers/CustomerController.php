<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
        ]);

        $customer = Customer::create($validated);

        return response()->json($customer, 201);
    }

    public function index(Request $request)
    {
        $query = Customer::query();
        
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        
        if ($request->has('with_orders') && $request->with_orders) {
            $query->with('orders');
        }
        
        $customers = $query->get();
        
        return response()->json($customers);
    }

    public function show($id)
    {
        $customer = Customer::with('orders')->findOrFail($id);
        
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:customers,email,' . $id,
        ]);

        $customer->update($validated);
        
        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        
        return response()->json(null, 204);
    }

    public function stats()
    {
        $stats = [
            'total_customers' => Customer::count(),
            'customers_with_orders' => Customer::has('orders')->count(),
            'customers_without_orders' => Customer::doesntHave('orders')->count(),
        ];
        
        return response()->json($stats);
    }
}