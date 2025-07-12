<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradingHistory;
use App\Models\User;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TradingHistoryController extends Controller
{
    public function index()
    {
        $histories = TradingHistory::with(['user', 'trader'])->latest()->get();
        return view('admin.manage_trade_history', compact('histories'));
    }

    public function update(Request $request, TradingHistory $tradingHistory)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,completed,failed,cancelled',
        ]);

        try {
            $originalStatus = $tradingHistory->status;
            $tradingHistory->update($request->only(['amount', 'status']));

            // Handle status changes if needed (e.g., refund if cancelled)
            if ($originalStatus == 'completed' && $request->status == 'cancelled') {
                $user = User::find($tradingHistory->user_id);
                $user->balance += $tradingHistory->amount;
                $user->save();
            }

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Trading history updated successfully'])
                : redirect()->route('admin.trading-histories.index')->with('success', 'Trading history updated successfully');
        } catch (\Exception $e) {
            Log::error('Trading history update error: ' . $e->getMessage());

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to update trading history'], 500)
                : redirect()->back()->with('error', 'Failed to update trading history');
        }
    }

    public function destroy(TradingHistory $tradingHistory)
    {
        try {
            // If history was completed, refund user balance before deleting
            if ($tradingHistory->status == 'completed') {
                $user = User::find($tradingHistory->user_id);
                $user->balance += $tradingHistory->amount;
                $user->save();
            }

            $tradingHistory->delete();

            return request()->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Trading history deleted successfully'])
                : redirect()->route('admin.trading-histories.index')->with('success', 'Trading history deleted successfully');
        } catch (\Exception $e) {
            Log::error('Trading history deletion error: ' . $e->getMessage());

            return request()->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to delete trading history'], 500)
                : redirect()->back()->with('error', 'Failed to delete trading history');
        }
    }
}
