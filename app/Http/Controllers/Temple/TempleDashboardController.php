<?php

namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use App\Models\TemplesRegistration;
use App\Models\TempleImage;

class TempleDashboardController extends Controller
{
    /**
     * Display the temple dashboard.
     */
    public function index()
    {
        $templeId = session('temple_id');

        // Check temple login session
        if (!$templeId || !session('temple_logged_in')) {
            return redirect()->route('login')
                ->with('error', 'Please login to continue.');
        }

        // Get logged-in temple
        $temple = TemplesRegistration::find($templeId);

        // Check temple exists and is active
        if (!$temple || $temple->status !== 'active') {

            session()->forget([
                'temple_id',
                'temple_name',
                'temple_email',
                'temple_logged_in',
            ]);

            return redirect()->route('login')
                ->with('error', 'Your temple account is inactive.');
        }

        // Get temple gallery images
        $templeImages = TempleImage::where('temple_id', $temple->id)
            ->first();

        return view('temple.index', compact(
            'temple',
            'templeImages'
        ));
    }
}

