<?php

namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TemplesRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
class TempleLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
  public function TempledoLogin(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->with('error', 'Invalid email or password')
            ->with('login_type', 'temple')
            ->withInput();
    }

    // Find active temple
    $temple = TemplesRegistration::where('email', $request->email)
        ->where('status', 'active')
        ->first();

    // Check whether temple exists
    if (!$temple) {
        return redirect()->back()
            ->with('error', 'Invalid email or password')
            ->with('login_type', 'temple')
            ->withInput();
    }

    try {

        // Decrypt password stored in database
        $decryptedPassword = Crypt::decryptString($temple->password);

        // Compare entered password with decrypted password
        if ($request->password !== $decryptedPassword) {
            return redirect()->back()
                ->with('error', 'Invalid email or password')
                ->with('login_type', 'temple')
                ->withInput();
        }

    } catch (\Exception $e) {

        return redirect()->back()
            ->with('error', 'Invalid email or password')
            ->with('login_type', 'temple')
            ->withInput();
    }

    // Store logged-in temple details in session
    session([
        'temple_id' => $temple->id,
        'temple_name' => $temple->temple_name,
        'temple_email' => $temple->email,
        'temple_logged_in' => true,
    ]);

    // Redirect to temple dashboard
    return redirect()->route('temple.dashboard');
}
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
