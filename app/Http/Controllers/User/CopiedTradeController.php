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

class CopiedTradeController extends Controller
{
    /**
     * Display all copied traders
     */
    public function index()
    {
        $tradingHistory = TradingHistory::with(['trader' => function ($query) {
            $query->select('id', 'name', 'picture', 'return_rate');
        }])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.copied-traders', [
            'tradingHistory' => $tradingHistory,
            'tradingBalance' => $this->getAccountBalance()
        ]);
    }

    /**
     * Stop copying a trader
     */
    public function stop(Request $request)
    {
        $request->validate([
            'trade_id' => 'required|exists:trading_histories,id'
        ]);

        try {
            DB::beginTransaction();

            $trade = TradingHistory::where('user_id', Auth::id())
                ->where('id', $request->trade_id)
                ->where('status', 'active')
                ->firstOrFail();

            // Update trade status (no longer refunding to TradingBalance)
            $trade->update([
                'status' => 'closed',
                'closed_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully stopped copying this trader',
                'refund_amount' => $trade->amount
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to stop trade: ' . $e->getMessage()
            ], 500);
        }
    }



    public function copyTrader(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'trader_id' => 'required|exists:traders,id',
            'amount' => 'required|numeric|min:0' // Changed from nullable to required
        ]);

        try {
            DB::beginTransaction();

            // Get trader's minimum amount requirement
            $trader = Trader::findOrFail($validated['trader_id']);
            $minAmount = $trader->min_amount ?? 0; // Assuming traders have min_amount column

            // Check if amount meets trader's minimum
            if ($validated['amount'] < $minAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'account portfolio is low you need a mini of USD' .
                        number_format($minAmount, 0) .
                        ' to be able to copy this trader'
                ], 400);
            }

            // Check available balance
            $currentBalance = $this->getAccountBalance();

            if ($currentBalance < $validated['amount']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance. Your balance: $' . number_format($currentBalance, 2)
                ], 400);
            }

            // Create trading history record
            $trade = TradingHistory::create([
                'user_id' => $user->id,
                'trader_id' => $validated['trader_id'],
                'amount' => $validated['amount'],
                'status' => 'active'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully copied trader',
                'new_balance' => $currentBalance - $validated['amount'],
                'trade_id' => $trade->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to copy trader: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's current account balance
     */
    private function getAccountBalance()
    {
        $user = Auth::user();

        $depositBalance = Deposit::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount') ?? 0;

        $profit = Profit::where('user_id', $user->id)
            ->sum('amount') ?? 0;

        return $depositBalance + $profit;
    }
}
