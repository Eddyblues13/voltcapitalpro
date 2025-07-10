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
            'Name' => 'required|string|max:255',
            'MinPortfolio' => 'required|numeric|min:0',
            'Exprience' => 'required|numeric|min:0',
            'PercentageGain' => 'required|numeric|min:0',
            'CurrencyPair' => 'nullable|string|max:255',
            'Details' => 'nullable|string',
            'ProfilePic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle picture upload to Cloudinary
            $uploadResult = $this->uploadApi->upload(
                $request->file('ProfilePic')->getRealPath(),
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

            $trader = Trader::create([
                'name' => $validated['Name'],
                'min_amount' => $validated['MinPortfolio'],
                'return_rate' => $validated['Exprience'],
                'profit_share' => $validated['PercentageGain'],
                'currency_pairs' => $validated['CurrencyPair'] ?? null,
                'details' => $validated['Details'] ?? null,
                'picture_url' => $uploadResult['secure_url'],
                'picture_public_id' => $uploadResult['public_id'],
                'is_verified' => $request->has('is_verified'),
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
            'Name' => 'required|string|max:255',
            'MinPortfolio' => 'required|numeric|min:0',
            'Exprience' => 'required|numeric|min:0',
            'PercentageGain' => 'required|numeric|min:0',
            'CurrencyPair' => 'nullable|string|max:255',
            'Details' => 'nullable|string',
            'ProfilePic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $updateData = [
                'name' => $validated['Name'],
                'min_amount' => $validated['MinPortfolio'],
                'return_rate' => $validated['Exprience'],
                'profit_share' => $validated['PercentageGain'],
                'currency_pairs' => $validated['CurrencyPair'] ?? null,
                'details' => $validated['Details'] ?? null,
                'is_verified' => $request->has('is_verified'),
            ];

            // Handle picture upload if new picture is provided
            if ($request->hasFile('ProfilePic')) {
                // Delete old picture from Cloudinary if exists
                if ($trader->picture_public_id) {
                    try {
                        $this->uploadApi->destroy($trader->picture_public_id);
                    } catch (\Exception $e) {
                        Log::error("Failed to delete old trader photo: " . $e->getMessage());
                    }
                }

                // Upload new picture
                $uploadResult = $this->uploadApi->upload(
                    $request->file('ProfilePic')->getRealPath(),
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

                $updateData['picture_url'] = $uploadResult['secure_url'];
                $updateData['picture_public_id'] = $uploadResult['public_id'];
            }

            $trader->update($updateData);

            return redirect()->route('traders.index')->with('success', 'Trader updated successfully!');
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