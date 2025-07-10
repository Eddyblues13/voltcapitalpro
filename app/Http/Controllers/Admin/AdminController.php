<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Trade;
use App\Models\User\Profit;
use App\Models\Document;
use App\Mail\sendUserEmail;
use App\Models\StockHistory;
use App\Models\TradeHistory;
use App\Models\User\Deposit;
use Illuminate\Http\Request;
use App\Models\AccountBalance;
use App\Models\User\Withdrawal;
use App\Models\User\MiningBalance;
use App\Models\User\HoldingBalance;
use App\Models\User\StakingBalance;
use App\Models\User\TradingBalance;
use App\Http\Controllers\Controller;
use App\Models\User\ReferralBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionNotificationMail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::with(['holdingBalance', 'stakingBalance', 'tradingBalance', 'referralBalance'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.home', compact('users'));
    }

    public function show($id)
    {
        $user = User::with(['holdingBalance', 'stakingBalance', 'tradingBalance', 'referralBalance'])
            ->findOrFail($id);

        return view('admin.user-details', compact('user'));
    }

    public function verifyUser($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'email_verification' => true,
            'id_verification' => true,
            'address_verification' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User verified successfully'
        ]);
    }

    public function memberVerify($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'subscription_status' => true,
            'confirmed_registration_fee' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Membership verified successfully'
        ]);
    }

    public function paidCF($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'top_up_status' => true,
            'confirmed_registration_fee' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Commission fee status updated'
        ]);
    }

    public function deactivateAccount($id)
    {
        $user = User::findOrFail($id);
        $user->update(['user_status' => 'inactive']);

        return response()->json([
            'success' => true,
            'message' => 'Account deactivated successfully'
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
