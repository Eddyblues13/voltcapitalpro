<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ManageUserController extends Controller
{
    public function dashboard()
    {
        $users = User::with(['holdingBalance', 'profitBalance', 'referralBalance'])->get();
        return view('admin.dashboard', compact('users'));
    }

    public function showClient(User $user)
    {
        $user->load(['holdingBalance', 'profitBalance', 'referralBalance']);

        // Calculate account balance and profit
        $accountBalance = $user->holdingBalance ? $user->holdingBalance->balance : 0;
        $profit = $user->profitBalance ? $user->profitBalance->balance : 0;

        return view('admin.user-details', compact('user', 'accountBalance', 'profit'));
    }

    public function deposit($userId)
    {
        return view('admin.deposit-user', ['userId' => $userId]);
    }

    public function profit($userId)
    {
        return view('admin.add-profit', ['userId' => $userId]);
    }

    public function upgrade(User $user)
    {
        return view('admin.upgrade', compact('user'));
    }

    public function trade(User $user)
    {
        return view('admin.trade', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.edit-client', compact('user'));
    }

    public function editBill(User $user)
    {
        return view('admin.edit-bill', compact('user'));
    }

    // AJAX Actions
    public function topup(Request $request, User $user)
    {
        $user->update(['top_up_status' => !$user->top_up_status]);

        return response()->json([
            'success' => true,
            'message' => 'Top-up status toggled successfully',
            'new_status' => $user->top_up_status
        ]);
    }

    public function paidRegisterFee(Request $request, User $user)
    {
        $user->update(['confirmed_registration_fee' => !$user->confirmed_registration_fee]);

        return response()->json([
            'success' => true,
            'message' => 'Registration fee status toggled successfully',
            'new_status' => $user->confirmed_registration_fee
        ]);
    }

    public function onNotify(Request $request, User $user)
    {
        $user->update(['notification_status' => !$user->notification_status]);

        return response()->json([
            'success' => true,
            'message' => 'Notification status toggled successfully',
            'new_status' => $user->notification_status
        ]);
    }

    public function onTopup(Request $request, User $user)
    {
        $user->update(['top_up_status' => !$user->top_up_status]);

        return response()->json([
            'success' => true,
            'message' => 'Top-up status toggled successfully',
            'new_status' => $user->top_up_status
        ]);
    }

    public function onSub(Request $request, User $user)
    {
        $user->update(['subscription_status' => !$user->subscription_status]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription status toggled successfully',
            'new_status' => $user->subscription_status
        ]);
    }

    public function onNetwork(Request $request, User $user)
    {
        $user->update(['network_status' => !$user->network_status]);

        return response()->json([
            'success' => true,
            'message' => 'Network status toggled successfully',
            'new_status' => $user->network_status
        ]);
    }

    public function sendVerification(Request $request, User $user)
    {
        // Implementation for sending verification email
        // You'll need to implement your email sending logic here

        return response()->json([
            'success' => true,
            'message' => 'Verification email sent successfully'
        ]);
    }

    public function resetPassword(Request $request, User $user)
    {
        // Send password reset link
        $status = Password::sendResetLink(
            ['email' => $user->email]
        );

        return response()->json([
            'success' => $status === Password::RESET_LINK_SENT,
            'message' => $status === Password::RESET_LINK_SENT
                ? 'Password reset link sent successfully'
                : 'Failed to send password reset link'
        ]);
    }

    public function manageTrades(User $user)
    {
        $trades = $user->trades()->orderBy('created_at', 'desc')->get();
        return view('admin.manage-trades', compact('user', 'trades'));
    }

    public function storeTrade(Request $request, User $user)
    {
        $validated = $request->validate([
            'symbol'      => 'required|string|max:20',
            'type'        => 'required|in:spot,futures,margin',
            'direction'   => 'required|in:UP,DOWN',
            'entry_price' => 'required|numeric|min:0',
            'exit_price'  => 'nullable|numeric|min:0',
            'amount'      => 'required|numeric|min:0',
            'profit'      => 'required|numeric',
            'status'      => 'required|in:active,closed',
            'entry_date'  => 'required|date',
            'exit_date'   => 'nullable|date|required_if:status,closed',
            'trader_name' => 'nullable|string|max:255',
            'notes'       => 'nullable|string',
        ]);

        $user->trades()->create($validated);

        return redirect()->route('admin.manage.trades', $user->id)
            ->with('success', 'Trade added successfully.');
    }

    public function deleteTrade(User $user, Trade $trade)
    {
        $trade->delete();

        return redirect()->route('admin.manage.trades', $user->id)
            ->with('success', 'Trade deleted successfully.');
    }
}
