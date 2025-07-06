<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\User\ContactInfo;
use App\Models\User\HoldingBalance;
use App\Models\User\StakingBalance;
use App\Models\User\TradingBalance;
use App\Http\Controllers\Controller;
use App\Models\User\ReferralBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;





        return view('user.account.index', $data);
    }

    public function transfer(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;






        return view('user.account.transfer', $data);
    }

    // Transfer from Trading to Holding Balance
    public function transferToHolding(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Get the user's trading and holding balances
        $tradingBalance = $user->tradingBalance;
        $holdingBalance = $user->holdingBalance;

        // Check if the trading balance has sufficient funds
        if ($tradingBalance->amount < $request->input('amount')) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient trading balance.',
            ], 422);
        }

        // Perform the transfer using increment and decrement
        $tradingBalance->decrement('amount', $request->input('amount')); // Decrease trading balance
        $holdingBalance->increment('amount', $request->input('amount')); // Increase holding balance

        return response()->json([
            'success' => true,
            'message' => 'Transfer to holding balance successful!',
        ]);
    }

    // Transfer from Holding to Trading Balance
    public function transferToTrading(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Get the user's trading and holding balances
        $tradingBalance = $user->tradingBalance;
        $holdingBalance = $user->holdingBalance;

        // Check if the holding balance has sufficient funds
        if ($holdingBalance->amount < $request->input('amount')) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient holding balance.',
            ], 422);
        }

        // Perform the transfer using increment and decrement
        $holdingBalance->decrement('amount', $request->input('amount')); // Decrease holding balance
        $tradingBalance->increment('amount', $request->input('amount')); // Increase trading balance

        return response()->json([
            'success' => true,
            'message' => 'Transfer to trading balance successful!',
        ]);
    }

    public function email(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;





        return view('user.account.email', $data);
    }
    public function updateEmail(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'new_email' => 'required|email|unique:users,email', // Ensure the email is unique
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Update the user's email
        $user = Auth::user();
        $user->email = $request->input('new_email');
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Email updated successfully!',
            'redirect' => route('account.email'), // Redirect to the user's profile page
        ]);
    }


    public function referrals(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();



        // Get referred users
        $data['referredUsers'] = User::where('referred_by', $user->id)->get();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;





        return view('user.account.referrals', $data);
    }
    public function password(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;





        return view('user.account.password', $data);
    }

    public function updatePassword(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Ensure new password matches confirmation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Verify the current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The current password is incorrect.',
            ], 422);
        }

        // Update the user's password
        $user->password = Hash::make($request->input('new_password'));

        // Encrypt and store the plain password (optional, but not recommended for security reasons)
        $user->plain = Crypt::encryptString($request->input('new_password'));

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!',
            'redirect' => route('account.password'), // Redirect to the user's profile page
        ]);
    }

    public function notifications(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;





        return view('user.account.notifications', $data);
    }

    public function address(Request $request)
    {
        $user = Auth::user();
        $data['user'] = ContactInfo::where('user_id', $user->id)->first();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;





        return view('user.account.address', $data);
    }

    public function updateContactInfo(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Update or create contact info
        $contactInfo = ContactInfo::updateOrCreate(
            ['user_id' => $user->id], // Find by user_id
            [
                'mobile_number' => $request->input('mobile_number'),
                'street_address' => $request->input('street_address'),
                'zip_code' => $request->input('zip_code'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'country' => $request->input('country'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Contact info updated successfully!',
            'redirect' => route('account.address'), // Redirect to the user's profile page
        ]);
    }
    public function photo(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;





        return view('user.account.photo', $data);
    }

    public function updatePhoto(Request $request)
    {
        // Validate the request
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        ]);

        // Handle file upload 
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension(); // Generate unique filename
            $destinationPath = public_path('uploads/photos/'); // Define destination path

            // Move the file to the destination folder
            $photo->move($destinationPath, $filename);

            // Save the file path to the database
            Auth::user()->update(['profile_photo' => 'uploads/photos/' . $filename]);

            return response()->json([
                'success' => true,
                'message' => 'Photo updated successfully!',
                'redirect' => route('account.photo'), // Redirect to the user's profile page
            ]);
        }


        return response()->json([
            'success' => false,
            'message' => 'No photo uploaded.',
        ], 400);
    }
}
