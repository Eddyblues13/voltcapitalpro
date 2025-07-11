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
        $this->cloudinary = new Cloudinary();
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
            'min_amount' => 'required|numeric|min:0|max:999999999999.99',
            'max_amount' => 'required|numeric|min:0|max:999999999999.99|gte:min_amount',
            'return_rate' => 'required|numeric|min:0|max:999999.99',
            'profit_share' => 'required|numeric|min:0|max:999.99',
            'followers' => 'nullable|integer|min:0',
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
            $uploadResult = Cloudinary::upload(
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
                'min_amount' => $validated['min_amount'],
                'max_amount' => $validated['max_amount'],
                'return_rate' => $validated['return_rate'],
                'profit_share' => $validated['profit_share'],
                'followers' => $validated['followers'] ?? 0,
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
            'min_amount' => 'required|numeric|min:0|max:999999999999.99',
            'max_amount' => 'required|numeric|min:0|max:999999999999.99|gte:min_amount',
            'return_rate' => 'required|numeric|min:0|max:999999.99',
            'profit_share' => 'required|numeric|min:0|max:999.99',
            'followers' => 'nullable|integer|min:0',
            'is_verified' => 'required|boolean',
            'picture_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_picture' => 'nullable|boolean',
        ]);

        try {
            // Remove picture if requested
            if ($request->has('remove_picture') && $request->boolean('remove_picture')) {
                // Optionally: delete from cloud storage if needed
                if ($trader->picture_public_id) {
                    Cloudinary::destroy($trader->picture_public_id);
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
                    Cloudinary::destroy($trader->picture_public_id);
                }

                $uploadResult = Cloudinary::upload(
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
