<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletOption;
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
        $walletOptions = WalletOption::all();
        return view('admin.update_wallet', compact('walletOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'coin_code' => 'required|string|max:10',
            'coin_name' => 'required|string|max:100',
            'wallet_name' => 'required|string|max:100',
            'wallet_type' => 'required|string|max:50',
            'network_type' => 'required|string|max:50',
            'wallet_address' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = $validated;

            // Handle icon upload to Cloudinary
            if ($request->hasFile('icon')) {
                $uploadResult = $this->uploadApi->upload(
                    $request->file('icon')->getRealPath(),
                    [
                        'folder' => 'wallet_icons',
                        'transformation' => [
                            'width' => 100,
                            'height' => 100,
                            'crop' => 'fill'
                        ]
                    ]
                );

                $data['icon'] = $uploadResult['secure_url'];
                $data['icon_public_id'] = $uploadResult['public_id'];
            } elseif ($request->has('icon_url')) {
                $data['icon'] = $request->icon_url;
                $data['icon_public_id'] = null;
            }

            WalletOption::create($data);

            return redirect()->route('admin.wallet_options.index')
                ->with('success', 'Wallet option created successfully.');
        } catch (\Exception $e) {
            Log::error('WalletOption creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create wallet option. Please try again.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WalletOption $walletOption)
    {
        $validated = $request->validate([
            'coin_code' => 'required|string|max:10',
            'coin_name' => 'required|string|max:100',
            'wallet_name' => 'required|string|max:100',
            'wallet_type' => 'required|string|max:50',
            'network_type' => 'required|string|max:50',
            'wallet_address' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_icon' => 'nullable|boolean',
        ]);

        try {
            $data = $validated;

            // Remove icon if requested
            if ($request->has('remove_icon') && $request->boolean('remove_icon')) {
                if ($walletOption->icon_public_id) {
                    $this->uploadApi->destroy($walletOption->icon_public_id);
                }

                $data['icon'] = null;
                $data['icon_public_id'] = null;
            }

            // Handle icon upload to Cloudinary if new icon is provided
            if ($request->hasFile('icon')) {
                // First delete old icon if exists
                if ($walletOption->icon_public_id) {
                    $this->uploadApi->destroy($walletOption->icon_public_id);
                }

                $uploadResult = $this->uploadApi->upload(
                    $request->file('icon')->getRealPath(),
                    [
                        'folder' => 'wallet_icons',
                        'transformation' => [
                            'width' => 100,
                            'height' => 100,
                            'crop' => 'fill'
                        ]
                    ]
                );

                $data['icon'] = $uploadResult['secure_url'];
                $data['icon_public_id'] = $uploadResult['public_id'];
            } elseif ($request->has('icon_url')) {
                $data['icon'] = $request->icon_url;
                $data['icon_public_id'] = null;
            }

            // Remove 'remove_icon' from data to avoid filling unnecessary column
            unset($data['remove_icon']);

            $walletOption->update($data);

            return redirect()->route('admin.wallet_options.index')
                ->with('success', 'Wallet option updated successfully.');
        } catch (\Exception $e) {
            Log::error('WalletOption update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update wallet option. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WalletOption $walletOption)
    {
        try {
            // Delete icon from Cloudinary if exists
            if ($walletOption->icon_public_id) {
                $this->uploadApi->destroy($walletOption->icon_public_id);
            }

            $walletOption->delete();

            return redirect()->route('admin.wallet_options.index')
                ->with('success', 'Wallet option deleted successfully.');
        } catch (\Exception $e) {
            Log::error('WalletOption deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete wallet option. Please try again.');
        }
    }
}
