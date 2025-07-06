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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $traders = Trader::all();
        return view('admin.traders.index', compact('traders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.traders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trader_name' => 'required|string|max:255',
            'followers' => 'required|numeric|min:0',
            'copier_roi' => 'required|numeric|min:0',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'risk_index' => 'required|numeric|min:0|max:100',
            'total_copied_trade' => 'required|numeric|min:0',
            'verified_status' => 'required',
        ]);

        try {
            // Handle picture upload to Cloudinary
            if ($request->hasFile('picture')) {
                $uploadResult = $this->uploadApi->upload(
                    $request->file('picture')->getRealPath(),
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

            Trader::create($validated);

            return redirect()->route('traders.index')->with('success', 'Trader created successfully!');
        } catch (\Exception $e) {
            Log::error('Trader creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create trader. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trader  $trader
     * @return \Illuminate\Http\Response
     */
    public function show(Trader $trader)
    {
        return view('admin.traders.show', compact('trader'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trader  $trader
     * @return \Illuminate\Http\Response
     */
    public function edit(Trader $trader)
    {
        return view('admin.traders.edit', compact('trader'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trader  $trader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trader $trader)
    {
        $validated = $request->validate([
            'trader_name' => 'required|string|max:255',
            'followers' => 'required|numeric|min:0',
            'copier_roi' => 'required|numeric|min:0',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'risk_index' => 'required|numeric|min:0|max:100',
            'total_copied_trade' => 'required|numeric|min:0',
            'verified_status' => 'required',
        ]);

        try {
            // Handle picture upload to Cloudinary if new picture is provided
            if ($request->hasFile('picture')) {
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
                    $request->file('picture')->getRealPath(),
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

            $trader->update($validated);

            return redirect()->route('traders.index')->with('success', 'Trader updated successfully!');
        } catch (\Exception $e) {
            Log::error('Trader update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update trader. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trader  $trader
     * @return \Illuminate\Http\Response
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
