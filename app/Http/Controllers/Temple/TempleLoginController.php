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
                ->withErrors($validator)
                ->with('error', 'Invalid email or password')
                ->with('login_type', 'temple')
                ->withInput();
        }

        $temple = TemplesRegistration::where('email', $request->email)
            ->where('status', 'active')
            ->first();

        if (!$temple) {
            return redirect()->back()
                ->with('error', 'Invalid email or password')
                ->with('login_type', 'temple')
                ->withInput();
       
                }

        try {
            // Decrypt the encrypted password
            $decryptedPassword = Crypt::decryptString($temple->password);

            // Compare entered password
            if (!hash_equals($decryptedPassword, $request->password)) {
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
 
        // Store temple session
        session([
            'temple_id' => $temple->id,
            'temple_name' => $temple->temple_name,
            'temple_email' => $temple->email,
            'temple_logged_in' => true,
        ]);
        
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