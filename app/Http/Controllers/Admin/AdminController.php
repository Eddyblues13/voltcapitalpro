<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Trade;
use App\Models\Document;
use App\Mail\sendUserEmail;
use App\Models\User\Profit;
use App\Models\StockHistory;
use App\Models\TradeHistory;
use App\Models\User\Deposit;
use Illuminate\Http\Request;
use App\Models\AccountBalance;
use App\Models\User\Withdrawal;
use App\Models\User\MiningBalance;
use App\Mail\AdminNotificationMail;
use App\Models\User\HoldingBalance;
use App\Models\User\StakingBalance;
use App\Models\User\TradingBalance;
use Illuminate\Support\Facades\Log;
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


    public function showChangePasswordForm()
    {
        return view('admin.change_password');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = Auth::guard('admin')->user();

        if (!$admin || !Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect')
                ->withInput();
        }

        try {
            $admin->password = Hash::make($request->new_password);
            $admin->save();

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Password updated successfully'])
                : redirect()->back()->with('success', 'Password updated successfully');
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to update password'], 500)
                : redirect()->back()->with('error', 'Failed to update password');
        }
    }


    public function showSendEmailForm()
    {
        $users = User::select('id', 'name', 'email')->get();
        return view('admin.send_mail', compact('users'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            $user = User::findOrFail($request->user_id);

            Mail::to($user->email)->send(new AdminNotificationMail(
                $request->subject,
                $request->message
            ));

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Email sent successfully'])
                : redirect()->back()->with('success', 'Email sent successfully');
        } catch (\Exception $e) {
            Log::error('Email sending error: ' . $e->getMessage());

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to send email'], 500)
                : redirect()->back()->with('error', 'Failed to send email');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? response()->json(['success' => true, 'message' => 'Logged out successfully'])
            : redirect('/admin/login')->with('success', 'Logged out successfully');
    }
}
