<?php

namespace App\Http\Controllers\Admin;

use App\Models\Trader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Support\Facades\Log;

class TraderController extends Controller
{
    protected $cloudinary;
    protected $uploadApi;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
        $this->uploadApi = $this->cloudinary->uploadApi();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $traders = Trader::all();
        return view('admin.traders.index', compact('traders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.traders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_portfolio' => 'required|numeric|min:0|max:999999999999.99',
            'experience' => 'nullable|string|max:255',
            'percentage' => 'nullable|string|max:255',
            'currency_pairs' => 'nullable|string|max:255',
            'details' => 'nullable|string',
            'picture_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_verified' => 'nullable|boolean',
        ]);

        try {
            if (!$request->hasFile('picture_url')) {
                return back()->with('error', 'Picture upload failed.');
            }

            // Upload picture to Cloudinary
            $uploadResult = $this->uploadApi->upload(
                $request->file('picture_url')->getRealPath(),
                [
                    'folder' => 'traders',
                    'transformation' => [
                        'width' => 300,
                        'height' => 300,
                        'crop' => 'fill',
                        'gravity' => 'face',
                    ]
                ]
            );

            Trader::create([
                'name' => $validated['name'],
                'min_portfolio' => $validated['min_portfolio'],
                'experience' => $validated['experience'] ?? null,
                'percentage' => $validated['percentage'] ?? null,
                'currency_pairs' => $validated['currency_pairs'] ?? null,
                'details' => $validated['details'] ?? null,
                'picture_url' => $uploadResult['secure_url'],
                'picture_public_id' => $uploadResult['public_id'],
                'is_verified' => $validated['is_verified'] ?? false,
                'verified_badge' => ($validated['is_verified'] ?? false) ? 'verified' : null,
            ]);

            return redirect()->route('traders.index')->with('success', 'Trader created successfully!');
        } catch (\Exception $e) {
            Log::error('Trader creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create trader. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Trader $trader)
    {
        return view('admin.traders.show', compact('trader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trader $trader)
    {
        return view('admin.traders.edit', compact('trader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trader $trader)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_portfolio' => 'required|numeric|min:0|max:999999999999.99',
            'experience' => 'nullable|string|max:255',
            'percentage' => 'nullable|string|max:255',
            'currency_pairs' => 'nullable|string|max:255',
            'details' => 'nullable|string',
            'is_verified' => 'required|boolean',
            'picture_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_picture' => 'nullable|boolean',
        ]);

        try {
            // Remove picture if requested
            if ($request->has('remove_picture') && $request->boolean('remove_picture')) {
                // Delete from cloud storage if needed
                if ($trader->picture_public_id) {
                    $this->uploadApi->destroy($trader->picture_public_id);
                }

                $trader->update([
                    'picture_url' => null,
                    'picture_public_id' => null,
                ]);
            }

            // Upload new picture if provided
            if ($request->hasFile('picture_url')) {
                // First delete the old picture if it exists
                if ($trader->picture_public_id) {
                    $this->uploadApi->destroy($trader->picture_public_id);
                }

                $uploadResult = $this->uploadApi->upload(
                    $request->file('picture_url')->getRealPath(),
                    [
                        'folder' => 'traders',
                        'transformation' => [
                            'width' => 300,
                            'height' => 300,
                            'crop' => 'fill',
                            'gravity' => 'face',
                        ]
                    ]
                );

                $validated['picture_url'] = $uploadResult['secure_url'];
                $validated['picture_public_id'] = $uploadResult['public_id'];
            }

            // Set verified_badge based on is_verified
            $validated['verified_badge'] = $validated['is_verified'] ? 'verified' : null;

            // Remove 'remove_picture' from validated to avoid filling unnecessary column
            unset($validated['remove_picture']);

            // Update the trader record
            $trader->update($validated);

            return back()->with('success', 'Trader updated successfully!');
        } catch (\Exception $e) {
            Log::error('Trader update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update trader. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trader $trader)
    {
        try {
            // Delete picture from Cloudinary if exists
            if ($trader->picture_public_id) {
                $this->uploadApi->destroy($trader->picture_public_id);
            }

            $trader->delete();

            return redirect()->route('traders.index')->with('success', 'Trader deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Trader deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete trader. Please try again.');
        }
    }
}
