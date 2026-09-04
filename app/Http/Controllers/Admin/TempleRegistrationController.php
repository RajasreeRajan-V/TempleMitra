<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplesRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\TemplePasswordGeneratedMail;
class TempleRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Base query
        $query = TemplesRegistration::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('temple_name', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('district', 'like', '%' . $search . '%')
                    ->orWhere('registration_number', 'like', '%' . $search . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // District filter
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        // Paginated temples
        $temples = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Statistics
        $totalTemples = TemplesRegistration::count();

        $activeTemples = TemplesRegistration::where('status', 'active')->count();

        $inactiveTemples = TemplesRegistration::where('status', 'inactive')->count();

        $districtsCount = TemplesRegistration::whereNotNull('district')
            ->where('district', '!=', '')
            ->distinct('district')
            ->count('district');

        // District list for filter dropdown
        $districts = TemplesRegistration::whereNotNull('district')
            ->where('district', '!=', '')
            ->distinct()
            ->orderBy('district')
            ->pluck('district');

        // Growth percentage
        $growthPercentage = 8;

        // Inactive percentage
        $inactivePercentage = $totalTemples > 0
            ? round(($inactiveTemples / $totalTemples) * 100)
            : 0;

        return view('admin.registration.temple_registration', compact(
            'temples',
            'districts',
            'totalTemples',
            'activeTemples',
            'inactiveTemples',
            'districtsCount',
            'growthPercentage',
            'inactivePercentage'
        ));
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
        $validated = $request->validate([
            'temple_name' => 'required|string|max:255',
            'address' => 'required|string',
            'district' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'contact_number' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s()]{10,20}$/',
            ],
            'email' => 'nullable|email|max:255|unique:temples_registration,email',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'registration_number' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('temples/logos', 'public');
        }

        // Generate original password
        $plainPassword = Str::random(12);

        // Store encrypted password in the SAME password column
        $validated['password'] = Crypt::encryptString($plainPassword);

        $validated['status'] = $request->input('status', 'active');

        $temple = TemplesRegistration::create($validated);

        // Send original password by email
        if (!empty($temple->email)) {
            Mail::to($temple->email)->send(
                new TemplePasswordGeneratedMail(
                    $temple,
                    $plainPassword
                )
            );
        }
        return redirect()
            ->route('admin.temples-registration.show', $temple->id)
            ->with('success', 'Temple registered successfully and login credentials sent to the email.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $temple = TemplesRegistration::findOrFail($id);

        return view('admin.registration.show', compact('temple'));
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
