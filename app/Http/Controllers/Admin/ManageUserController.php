<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        return view('admin.client-details', compact('user'));
    }


    public function deposit($userId)
    {
        return view('admin.deposit-user', ['userId' => $userId]);
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
        $user->update(['top_up_status' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Account top-up enabled successfully'
        ]);
    }

    public function paidRegisterFee(Request $request, User $user)
    {
        $user->update(['confirmed_registration_fee' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Registration fee confirmed successfully'
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
}
