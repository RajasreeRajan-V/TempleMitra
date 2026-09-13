<?php

namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleImage;
use App\Models\TemplesRegistration;
use Illuminate\Support\Facades\Storage;

class TempleImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->update($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update temple images.
     */
    public function update(Request $request)
    {
        // Validate uploaded images
        $request->validate([
            'image1' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // Get logged-in temple ID from session
        $templeId = session('temple_id');

        if (!$templeId) {
            return redirect('/')
                ->with('error', 'Please login first.');
        }

        // Get temple from temples_registration table
        $temple = TemplesRegistration::find($templeId);

        if (!$temple) {
            session()->forget([
                'temple_id',
                'temple_name',
                'temple_email',
                'temple_logged_in',
            ]);

            return redirect('/')
                ->with('error', 'Temple account not found.');
        }

        // Get existing image record or create a new one
        $templeImages = TempleImage::firstOrNew([
            'temple_id' => $temple->id,
        ]);

        // Upload Image 1, Image 2 and Image 3
        foreach (['image1', 'image2', 'image3'] as $field) {

            if ($request->hasFile($field)) {

                // Delete old image if it exists
                if ($templeImages->$field) {
                    Storage::disk('public')->delete(
                        $templeImages->$field
                    );
                }

                // Store new image
                $templeImages->$field = $request
                    ->file($field)
                    ->store('temple_images', 'public');
            }
        }

        // Make sure temple_id is set
        $templeImages->temple_id = $temple->id;

        // Save images
        $templeImages->save();

        return redirect()
            ->route('temple.profile')
            ->with('success', 'Temple images updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

