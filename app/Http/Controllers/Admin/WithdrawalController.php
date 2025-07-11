<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\Withdrawal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->latest()->get();
        return view('admin.manage_withdrawal', compact('withdrawals'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'account_type' => 'required|in:Bank,Crypto',
            'crypto_currency' => 'required_if:account_type,Crypto|nullable|string|max:255',
            'amount' => 'required|numeric|min:0.00000001',
            'wallet_address' => 'required_if:account_type,Crypto|nullable|string|max:255',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        try {
            $originalStatus = $withdrawal->status;
            $withdrawal->update($request->all());

            // If status changed from pending to approved, deduct from user balance
            if ($originalStatus == 'pending' && $request->status == 'approved') {
                $user = User::find($withdrawal->user_id);
                $user->balance -= $withdrawal->amount;
                $user->save();
            }

            // If status changed from approved to rejected, refund user balance
            if ($originalStatus == 'approved' && $request->status == 'rejected') {
                $user = User::find($withdrawal->user_id);
                $user->balance += $withdrawal->amount;
                $user->save();
            }

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Withdrawal updated successfully'])
                : redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal updated successfully');
        } catch (\Exception $e) {
            Log::error('Withdrawal update error: ' . $e->getMessage());

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to update withdrawal'], 500)
                : redirect()->back()->with('error', 'Failed to update withdrawal');
        }
    }

    public function destroy(Withdrawal $withdrawal)
    {
        try {
            // If withdrawal was approved, refund user balance before deleting
            if ($withdrawal->status == 'approved') {
                $user = User::find($withdrawal->user_id);
                $user->balance += $withdrawal->amount;
                $user->save();
            }

            $withdrawal->delete();

            return request()->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Withdrawal deleted successfully'])
                : redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal deleted successfully');
        } catch (\Exception $e) {
            Log::error('Withdrawal deletion error: ' . $e->getMessage());

            return request()->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to delete withdrawal'], 500)
                : redirect()->back()->with('error', 'Failed to delete withdrawal');
        }
    }
}
