<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManagePlan extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.update_plan', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'swap_fee' => 'required|boolean',
            'pairs' => 'required|integer|min:1',
            'leverage' => 'nullable|string|max:50',
            'spread' => 'nullable|string|max:50',
        ]);

        try {
            $plan = Plan::create($request->all());

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Plan created successfully'])
                : redirect()->route('admin.plans.index')->with('success', 'Plan created successfully');
        } catch (\Exception $e) {
            Log::error('Plan creation error: ' . $e->getMessage());

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to create plan'], 500)
                : redirect()->back()->with('error', 'Failed to create plan');
        }
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'swap_fee' => 'required|boolean',
            'pairs' => 'required|integer|min:1',
            'leverage' => 'nullable|string|max:50',
            'spread' => 'nullable|string|max:50',
        ]);

        try {
            $plan->update($request->all());

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Plan updated successfully'])
                : redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully');
        } catch (\Exception $e) {
            Log::error('Plan update error: ' . $e->getMessage());

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to update plan'], 500)
                : redirect()->back()->with('error', 'Failed to update plan');
        }
    }

    public function destroy(Plan $plan)
    {
        try {
            $plan->delete();

            return request()->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Plan deleted successfully'])
                : redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully');
        } catch (\Exception $e) {
            Log::error('Plan deletion error: ' . $e->getMessage());

            return request()->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to delete plan'], 500)
                : redirect()->back()->with('error', 'Failed to delete plan');
        }
    }
}
