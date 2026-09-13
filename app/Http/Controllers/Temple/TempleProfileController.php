<?php

namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplesRegistration;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Models\TempleImage;

class TempleProfileController extends Controller
{
    /**
     * Display the temple profile.
     */
    public function index()
    {
        return redirect()->route('temple.profile');
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
        //
    }

    /**
     * Display the temple profile.
     */
    public function show()
    {
        $templeId = session('temple_id');

        $temple = TemplesRegistration::find($templeId);
        $templeImages = TempleImage::where('temple_id', $temple->id)->first();
        if (!$temple) {
            return redirect('/')
                ->with('error', 'Please login first.');
        }

        return view('temple.profile.show', compact('temple','templeImages'));
    }

    /**
     * Show the form for editing the temple profile.
     */
    public function edit()
    {
        $templeId = session('temple_id');

        $temple = TemplesRegistration::find($templeId);

        if (!$temple) {
            return redirect('/')
                ->with('error', 'Please login first.');
        }

        return view('temple.profile.edit', compact('temple'));
    }

    /**
     * Update the temple profile.
     */
    public function update(Request $request)
    {
        $templeId = session('temple_id');

        $temple = TemplesRegistration::find($templeId);

        if (!$temple) {
            return redirect('/')
                ->with('error', 'Please login first.');
        }

        $validated = $request->validate([
            'temple_name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'district' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        /*
         * Handle logo upload
         */
        if ($request->hasFile('logo')) {

            // Delete old logo
            if ($temple->logo) {
                Storage::disk('public')->delete($temple->logo);
            }

            // Store new logo
            $validated['logo'] = $request
                ->file('logo')
                ->store('temple_logos', 'public');
        }

        /*
         * Update temple profile
         */
        $temple->update($validated);

        return redirect()
            ->route('temple.profile')
            ->with('success', 'Temple profile updated successfully.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(string $id)
    {
        //
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $temple = TemplesRegistration::find(session('temple_id'));

        if (!$temple) {
            return redirect('/')
                ->with('error', 'Please login first.');
        }

        /*
         * Decrypt the existing password
         */
        try {
            $oldPassword = Crypt::decryptString($temple->password);
        } catch (\Exception $e) {
            return back()->withErrors([
                'current_password' => 'Unable to verify the current password.'
            ]);
        }

        /*
         * Check current password
         */
        if (!hash_equals($oldPassword, $request->current_password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.'
            ]);
        }

        /*
         * Encrypt and save new password
         */
        $temple->password = Crypt::encryptString($request->password);
        $temple->save();

        return redirect()
            ->route('temple.profile')
            ->with('success', 'Password updated successfully.');
    }
    public function editPassword()
    {
        $templeId = session('temple_id');

        $temple = TemplesRegistration::find($templeId);

        if (!$temple) {
            return redirect('/')
                ->with('error', 'Please login first.');
        }

        $currentPassword = '';

        if ($temple->password) {
            try {
                $currentPassword = Crypt::decryptString($temple->password);
            } catch (\Exception $e) {
                $currentPassword = '';
            }
        }

        return view(
            'temple.profile.password',
            compact('temple', 'currentPassword')
        );
    }
}
