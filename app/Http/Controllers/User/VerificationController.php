<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User\HoldingBalance;
use App\Models\User\StakingBalance;
use App\Models\User\TradingBalance;
use App\Http\Controllers\Controller;
use App\Models\IdentityVerification;
use App\Models\User\ContactInfo;
use App\Models\User\ReferralBalance;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;


        $data['email_verification'] = $user->email_verification;
        $data['id_verification'] = $user->id_verification;
        $data['address_verification'] = $user->address_verification;




        return view('user.verification.index', $data);
    }


    public function identity(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;


        $data['email_verification'] = $user->email_verification;
        $data['id_verification'] = $user->id_verification;
        $data['address_verification'] = $user->address_verification;




        return view('user.verification.id_verification', $data);
    }


    public function identityVerify(Request $request)
    {
        $request->validate([
            'front_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'back_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Check if user already has a pending or approved verification
        $existingVerification = IdentityVerification::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingVerification) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a verification request that is pending or approved.'
            ], 422);
        }

        // Handle front photo upload
        if ($request->hasFile('front_photo')) {
            $frontPhoto = $request->file('front_photo');
            $frontFilename = 'front_' . time() . '.' . $frontPhoto->getClientOriginalExtension();
            $destinationPath = public_path('uploads/identity_verifications/');
            $frontPhoto->move($destinationPath, $frontFilename);
            $frontPhotoPath = 'uploads/identity_verifications/' . $frontFilename;
        }

        // Handle back photo upload
        if ($request->hasFile('back_photo')) {
            $backPhoto = $request->file('back_photo');
            $backFilename = 'back_' . time() . '.' . $backPhoto->getClientOriginalExtension();
            $destinationPath = public_path('uploads/identity_verifications/');
            $backPhoto->move($destinationPath, $backFilename);
            $backPhotoPath = 'uploads/identity_verifications/' . $backFilename;
        }

        // Create the verification record
        $verification = IdentityVerification::create([
            'user_id' => $user->id,
            'front_photo_path' => $frontPhotoPath,
            'back_photo_path' => $backPhotoPath,

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Identity verification submitted successfully. It will be reviewed shortly.'
        ]);
    }

    public function address(Request $request)
    {
        $user = Auth::user();
        $data['user'] = Auth::user();

        $data['holdingBalance'] = HoldingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['stakingBalance'] = StakingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['tradingBalance'] = TradingBalance::where('user_id', $user->id)->sum('amount') ?? 0;
        $data['referralBalance'] = ReferralBalance::where('user_id', $user->id)->sum('amount') ?? 0;


        $data['email_verification'] = $user->email_verification;
        $data['id_verification'] = $user->id_verification;
        $data['address_verification'] = $user->address_verification;




        return view('user.verification.address_verification', $data);
    }

    public function addressVerify(Request $request)
    {
        $request->validate([
            'utility_bill' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        $user = Auth::user();

        // Check if user already has a verification
        $existingVerification = ContactInfo::where('user_id', $user->id)->first();

        if ($existingVerification) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an address verification on file.'
            ], 422);
        }

        // Handle utility bill upload
        if ($request->hasFile('utility_bill')) {
            $utilityBill = $request->file('utility_bill');
            $utilityFilename = 'utility_bill_' . time() . '.' . $utilityBill->getClientOriginalExtension();
            $destinationPath = public_path('uploads/address_verifications/');

            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $utilityBill->move($destinationPath, $utilityFilename);
            $utilityBillPath = 'uploads/address_verifications/' . $utilityFilename;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Utility bill file is required.'
            ], 422);
        }

        // Create the verification record
        $verification = ContactInfo::create([
            'user_id' => $user->id,
            'mobile_number' => $request->mobile_number ?? null, // Assuming this might be optional
            'street_address' => $request->street_address ?? null,
            'zip_code' => $request->zip_code ?? null,
            'city' => $user->city ?? null,
            'state' => $user->state ?? null,
            'country' =>  $user->country ?? null, // Fallback to user's country
            'bill' => $utilityBillPath,

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address verification submitted successfully. It will be reviewed shortly.',
            'data' => $verification
        ]);
    }
}
