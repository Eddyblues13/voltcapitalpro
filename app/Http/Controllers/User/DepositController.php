<?php

namespace App\Http\Controllers\User;

use App\Models\User\Deposit;
use Illuminate\Http\Request;
use App\Models\User\MiningBalance;
use App\Models\User\HoldingBalance;
use App\Models\User\StakingBalance;
use App\Models\User\TradingBalance;
use App\Http\Controllers\Controller;
use App\Models\User\ReferralBalance;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::where('user_id', auth()->id())
            ->latest()
            ->paginate(10); // Adjust pagination as needed

        return view('user.deposit.home', compact('deposits'));
    }

    public function buyCrypto()
    {
        // Adjust pagination as needed

        return view('user.deposit.buy_crypto');
    }

    public function stepOne()
    {

        $user = Auth::user();

        return view('user.deposit.fund_one');
    }

    public function stepOneSubmit(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:10', // Minimum deposit of 10
        ]);

        // Store amount in session
        session(['deposit_amount' => $validatedData['amount']]);

        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Deposit amount stored successfully!',
            'data' => [
                'amount' => $validatedData['amount'],
            ],
        ]);
    }

    public function stepTwo(Request $request)
    {
        // Retrieve the amount from the session
        $amount = session('deposit_amount');

        // Optional: Redirect back if amount is not set in session
        if (!$amount) {
            return redirect()->route('deposit.step.one')->with('error', 'Please enter a deposit amount first.');
        }

        // Pass data to the view
        return view('user.deposit.fund_two', [
            'amount' => $amount,
        ]);
    }


    public function stepTwoSubmit(Request $request)
    {
        // Validate input
        $request->validate([
            'amount' => 'required|numeric|min:1',

        ]);

        // Process the data (e.g., save to database)
        $amount = $request->input('amount');


        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully!',
            'amount' => $amount,

        ]);
    }


    public function stepThree(Request $request)
    {
        // Retrieve data from query parameters
        $amount = $request->query('amount');


        // Pass data to the view
        return view('user.deposit.fund_three', [
            'amount' => $amount,

        ]);
    }

    public function stepThreeSubmit(Request $request)
    {
        // Validate input
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Process the data (e.g., save to database)
        $amount = $request->input('amount');


        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully!',
            'amount' => $amount,

        ]);
    }

    public function payment(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:10',
            'payment_method' => 'required|in:Bitcoin,Ethereum,XRP,Solana,Tether,Dogecoin,Litecoin,Cardano',
            'crypto_amount' => 'required|numeric|gt:0',
            'currency' => 'required|string|max:3'
        ]);

        try {
            // Generate a unique transaction ID
            $txnId = 'txn_' . uniqid();
            $user = Auth::user();

            // Create the deposit record
            $deposit = Deposit::create([
                'user_id' => $user->id,
                'amount' => $validatedData['amount'],
                'account_type' => $validatedData['payment_method'],
                'status' => 'pending'
            ]);
            // Generate a crypto address (in a real app, this would come from your payment processor)
            $address = 'crypto_' . bin2hex(random_bytes(8));

            return response()->json([
                'success' => true,
                'message' => 'Payment initiated successfully',
                'redirect_url' => route('pay.crypto', [
                    'txn_id' => $txnId,
                    'crypto' => $request->payment_method,
                    'amount' => $request->crypto_amount,
                    'address' => $address
                ])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function payCrypto(Request $request)
    {

        // Retrieve data from query parameters
        $txn_id = $request->query('txn_id');
        $crypto = $request->query('crypto');
        $amount = $request->query('amount');

        // Fetch payment method details from database based on cryptocurrency name
        $paymentMethod = \App\Models\PaymentMethod::where('name', $crypto)->first();

        if (!$paymentMethod) {
            return redirect()->back()->with('error', 'Payment method for this cryptocurrency is not available');
        }

        // Pass all data to the view
        return view('user.deposit.pay_crypto', [
            'txn_id' => $txn_id,
            'crypto' => $crypto,
            'crypto_amount' => $amount,
            'wallet_address' => $paymentMethod->wallet_address,
            'payment_method' => $crypto,
            'coin_name' => $paymentMethod->name,
            'coin_image' => $paymentMethod->coin_pic_path, // Added coin image
            'scan_code' => $paymentMethod->scan_code_path // Added scan code if needed
        ]);
    }
}
