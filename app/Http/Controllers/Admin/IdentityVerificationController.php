<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdentityVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class IdentityVerificationController extends Controller
{
    public function index()
    {
        $verifications = IdentityVerification::with('user')->latest()->get();
        return view('admin.manage_kyc', compact('verifications'));
    }

    public function update(Request $request, IdentityVerification $identityVerification)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ]);

        try {
            $originalStatus = $identityVerification->status;
            $identityVerification->update([
                'status' => $request->status,
                'rejection_reason' => $request->rejection_reason,
            ]);

            // If status changed to approved, mark user as verified
            if ($originalStatus != 'approved' && $request->status == 'approved') {
                $user = User::find($identityVerification->user_id);
                $user->identity_verified = true;
                $user->save();
            }

            // If status changed from approved to something else, mark user as unverified
            if ($originalStatus == 'approved' && $request->status != 'approved') {
                $user = User::find($identityVerification->user_id);
                $user->identity_verified = false;
                $user->save();
            }

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Verification status updated'])
                : redirect()->route('admin.identity-verifications.index')->with('success', 'Verification status updated');
        } catch (\Exception $e) {
            Log::error('Verification update error: ' . $e->getMessage());

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to update verification'], 500)
                : redirect()->back()->with('error', 'Failed to update verification');
        }
    }

    public function destroy(IdentityVerification $identityVerification)
    {
        try {
            // Delete images from Cloudinary if they exist
            if ($identityVerification->front_photo_public_id) {
                Cloudinary::destroy($identityVerification->front_photo_public_id);
            }
            if ($identityVerification->back_photo_public_id) {
                Cloudinary::destroy($identityVerification->back_photo_public_id);
            }

            // If verification was approved, mark user as unverified
            if ($identityVerification->status == 'approved') {
                $user = User::find($identityVerification->user_id);
                $user->identity_verified = false;
                $user->save();
            }

            $identityVerification->delete();

            return request()->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Verification deleted successfully'])
                : redirect()->route('admin.identity-verifications.index')->with('success', 'Verification deleted successfully');
        } catch (\Exception $e) {
            Log::error('Verification deletion error: ' . $e->getMessage());

            return request()->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to delete verification'], 500)
                : redirect()->back()->with('error', 'Failed to delete verification');
        }
    }
}
