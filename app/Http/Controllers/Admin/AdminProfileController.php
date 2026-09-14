<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    /**
     * Show the update profile form.
     */
    public function edit()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.settings.profile', compact('admin'));
    }

    /**
     * Update the admin's name and email.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
        ]);

        $admin->update($validated);

        return redirect()
            ->route('admin.settings.profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the change password form.
     */
    public function editPassword()
    {
        return view('admin.settings.password');
    }

 /**
 * Update the admin's password.
 */
public function updatePassword(Request $request)
{
    $admin = Auth::guard('admin')->user();

    $validated = $request->validate([
        'password' => [
            'required',
            'confirmed',
            Password::min(8)->letters()->numbers(),
            function ($attribute, $value, $fail) use ($admin) {
                if (Hash::check($value, $admin->password)) {
                    $fail('The new password must be different from your current password.');
                }
            },
        ],
    ]);

    $admin->update([
        'password' => Hash::make($validated['password']),
    ]);

    return redirect()
        ->route('admin.settings.password')
        ->with('success', 'Password changed successfully.');
}
}