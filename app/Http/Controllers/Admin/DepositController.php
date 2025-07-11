<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\Deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::with('user')->latest()->get();
        return view('admin.manage_deposit', compact('deposits'));
    }

    public function update(Request $request, Deposit $deposit)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'account_type' => 'required|string|max:255',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        try {
            $deposit->update($request->only(['amount', 'account_type', 'status']));

            // If status changed to approved, update user balance
            if ($request->status == 'approved' && $deposit->status != 'approved') {
                $user = User::find($deposit->user_id);
                $user->balance += $deposit->amount;
                $user->save();
            }

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Deposit updated successfully'])
                : redirect()->route('admin.deposits.index')->with('success', 'Deposit updated successfully');
        } catch (\Exception $e) {
            Log::error('Deposit update error: ' . $e->getMessage());

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to update deposit'], 500)
                : redirect()->back()->with('error', 'Failed to update deposit');
        }
    }

    public function destroy(Deposit $deposit)
    {
        try {
            $deposit->delete();

            return request()->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Deposit deleted successfully'])
                : redirect()->route('admin.deposits.index')->with('success', 'Deposit deleted successfully');
        } catch (\Exception $e) {
            Log::error('Deposit deletion error: ' . $e->getMessage());

            return request()->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to delete deposit'], 500)
                : redirect()->back()->with('error', 'Failed to delete deposit');
        }
    }
}
