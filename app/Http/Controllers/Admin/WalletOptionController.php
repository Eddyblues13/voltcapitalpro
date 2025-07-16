<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Support\Facades\Log;

class WalletOptionController extends Controller
{
    protected $cloudinary;
    protected $uploadApi;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary();
        $this->uploadApi = $this->cloudinary->uploadApi();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::paginate(10);
        return view('admin.update_wallet', compact('paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'wallet_address' => 'required|string|max:255',
            'coin_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'scan_code' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = [
                'name' => $validated['name'],
                'wallet_address' => $validated['wallet_address']
            ];

            // Upload coin picture to Cloudinary
            if ($request->hasFile('coin_pic')) {
                $uploadResult = $this->uploadApi->upload(
                    $request->file('coin_pic')->getRealPath(),
                    ['folder' => 'payment_methods/coin_pics']
                );
                $data['coin_pic_path'] = $uploadResult['secure_url'];
                $data['coin_pic_public_id'] = $uploadResult['public_id'];
            }

            // Upload scan code to Cloudinary
            if ($request->hasFile('scan_code')) {
                $uploadResult = $this->uploadApi->upload(
                    $request->file('scan_code')->getRealPath(),
                    ['folder' => 'payment_methods/scan_codes']
                );
                $data['scan_code_path'] = $uploadResult['secure_url'];
                $data['scan_code_public_id'] = $uploadResult['public_id'];
            }

            PaymentMethod::create($data);

            return redirect()->route('admin.wallet_options.index')
                ->with('success', 'Payment method created successfully.');
        } catch (\Exception $e) {
            Log::error('PaymentMethod creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create payment method. Please try again.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $wallet_option)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'wallet_address' => 'required|string|max:255',
            'coin_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'scan_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_coin_pic' => 'nullable|boolean',
            'remove_scan_code' => 'nullable|boolean',
        ]);

        try {
            $data = [
                'name' => $validated['name'],
                'wallet_address' => $validated['wallet_address']
            ];

            // Handle coin picture
            if ($request->has('remove_coin_pic') && $request->boolean('remove_coin_pic')) {
                if ($wallet_option->coin_pic_public_id) {
                    $this->uploadApi->destroy($wallet_option->coin_pic_public_id);
                }
                $data['coin_pic_path'] = null;
                $data['coin_pic_public_id'] = null;
            } elseif ($request->hasFile('coin_pic')) {
                // Delete old coin pic if exists
                if ($wallet_option->coin_pic_public_id) {
                    $this->uploadApi->destroy($wallet_option->coin_pic_public_id);
                }

                // Upload new coin pic
                $uploadResult = $this->uploadApi->upload(
                    $request->file('coin_pic')->getRealPath(),
                    ['folder' => 'payment_methods/coin_pics']
                );
                $data['coin_pic_path'] = $uploadResult['secure_url'];
                $data['coin_pic_public_id'] = $uploadResult['public_id'];
            }

            // Handle scan code
            if ($request->has('remove_scan_code') && $request->boolean('remove_scan_code')) {
                if ($wallet_option->scan_code_public_id) {
                    $this->uploadApi->destroy($wallet_option->scan_code_public_id);
                }
                $data['scan_code_path'] = null;
                $data['scan_code_public_id'] = null;
            } elseif ($request->hasFile('scan_code')) {
                // Delete old scan code if exists
                if ($wallet_option->scan_code_public_id) {
                    $this->uploadApi->destroy($wallet_option->scan_code_public_id);
                }

                // Upload new scan code
                $uploadResult = $this->uploadApi->upload(
                    $request->file('scan_code')->getRealPath(),
                    ['folder' => 'payment_methods/scan_codes']
                );
                $data['scan_code_path'] = $uploadResult['secure_url'];
                $data['scan_code_public_id'] = $uploadResult['public_id'];
            }

            $wallet_option->update($data);

            return redirect()->route('admin.wallet_options.index')
                ->with('success', 'Payment method updated successfully.');
        } catch (\Exception $e) {
            Log::error('PaymentMethod update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update payment method. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $wallet_option)
    {
        try {
            // Delete coin pic from Cloudinary if exists
            if ($wallet_option->coin_pic_public_id) {
                $this->uploadApi->destroy($wallet_option->coin_pic_public_id);
            }

            // Delete scan code from Cloudinary if exists
            if ($wallet_option->scan_code_public_id) {
                $this->uploadApi->destroy($wallet_option->scan_code_public_id);
            }

            $wallet_option->delete();

            return redirect()->route('admin.wallet_options.index')
                ->with('success', 'Payment method deleted successfully.');
        } catch (\Exception $e) {
            Log::error('PaymentMethod deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete payment method. Please try again.');
        }
    }
}
