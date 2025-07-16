<?php

namespace App\Http\Controllers\User;

use App\Models\Trader;
use App\Models\User\Profit;
use App\Models\User\Deposit;
use Illuminate\Http\Request;
use App\Models\TradingHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CopyTradeController extends Controller
{
    public function index()
    {
        $traders = Trader::all();
        $tradingHistories = TradingHistory::where('user_id', Auth::id())->with('trader')->get();
        $user = Auth::user();

        $data['depositBalance'] = Deposit::where('user_id', $user->id)
            ->where('status', 'approved') // Only include approved deposits
            ->sum('amount') ?? 0;
        $data['profit'] = Profit::where('user_id', $user->id)->sum('amount') ?? 0;

        $data['accountBalance'] = $data['depositBalance'] + $data['profit'];

        return view('user.copy_trade', [
            'traders' => $traders,
            'tradingHistories' => $tradingHistories,
            'accountBalance' => $data['accountBalance']
        ]);
    }

    // public function copyTrader(Request $request)
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Please login to copy traders'
    //         ], 401);
    //     }

    //     $validated = $request->validate([
    //         'trader_id' => 'required|exists:traders,id',
    //         'amount' => 'required|numeric|min:0'
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         // Get current account balance
    //         $depositBalance = Deposit::where('user_id', $user->id)
    //             ->where('status', 'approved')
    //             ->sum('amount') ?? 0;
    //         $profit = Profit::where('user_id', $user->id)->sum('amount') ?? 0;
    //         $currentBalance = $depositBalance + $profit;

    //         if ($currentBalance < $validated['amount']) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'account portfolio is low you need a mini of USD' . 
    //                  number_format($validated['amount'], 0) . 
    //                  ' to be able to copy this trader'
    //                 // 'message' => 'Insufficient balance. Your balance: $' . number_format($currentBalance, 2)
    //             ], 400);
    //         }

    //         // Create trading history record
    //         $transaction = TradingHistory::create([
    //             'user_id' => $user->id,
    //             'trader_id' => $validated['trader_id'],
    //             'amount' => $validated['amount'],
    //             'status' => 'active'
    //         ]);

    //         DB::commit();

    //         $newBalance = $currentBalance - $validated['amount'];

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Successfully copied trader',
    //             'new_balance' => $newBalance,
    //             'transaction_id' => $transaction->id
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to copy trader: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function copyTrader(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to copy traders'
            ], 401);
        }

        $validated = $request->validate([
            'trader_id' => 'required|exists:traders,id',
            'amount' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            // Get trader's minimum amount
            $trader = Trader::findOrFail($validated['trader_id']);
            $minAmount = $trader->min_amount ?? 0; // Assuming there's a min_amount column

            // Check if amount meets trader's minimum
            if ($validated['amount'] < $minAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'account portfolio is low you need a mini of USD' .
                        number_format($minAmount, 0) .
                        ' to be able to copy this trader'
                ], 400);
            }

            // Get current account balance
            $depositBalance = Deposit::where('user_id', $user->id)
                ->where('status', 'approved')
                ->sum('amount') ?? 0;
            $profit = Profit::where('user_id', $user->id)->sum('amount') ?? 0;
            $currentBalance = $depositBalance + $profit;

            if ($currentBalance < $validated['amount']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance. Your available balance is USD' .
                        number_format($currentBalance, 0)
                ], 400);
            }

            // Create trading history record
            $transaction = TradingHistory::create([
                'user_id' => $user->id,
                'trader_id' => $validated['trader_id'],
                'amount' => $validated['amount'],
                'status' => 'active'
            ]);

            DB::commit();

            $newBalance = $currentBalance - $validated['amount'];

            return response()->json([
                'success' => true,
                'message' => 'Successfully copied trader',
                'new_balance' => $newBalance,
                'transaction_id' => $transaction->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to copy trader: ' . $e->getMessage()
            ], 500);
        }
    }
}
