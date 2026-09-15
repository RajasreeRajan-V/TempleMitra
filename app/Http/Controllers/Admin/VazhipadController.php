<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vazhipad;
use Illuminate\Http\Request;

class VazhipadController extends Controller
{
    public function index()
    {
        $templeId = session('temple_id');

        $vazhipads = Vazhipad::where('temple_id', $templeId)
            ->latest()
            ->get();

        return view(
            'temple.vazhipad.index',
            compact('vazhipads')
        );
    }

    public function create()
    {
        return view('temple.vazhipad.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $validated['temple_id'] = session('temple_id');

        Vazhipad::create($validated);

        return redirect()
            ->route('temple.vazhipad.index')
            ->with('success', 'Vazhipad created successfully.');
    }

    public function show(Vazhipad $vazhipad)
    {
        $this->checkTempleOwnership($vazhipad);

        return view(
            'temple.vazhipad.show',
            compact('vazhipad')
        );
    }

    public function edit(Vazhipad $vazhipad)
    {
        $this->checkTempleOwnership($vazhipad);

        return view(
            'temple.vazhipad.edit',
            compact('vazhipad')
        );
    }

    public function update(
        Request $request,
        Vazhipad $vazhipad
    ) {
        $this->checkTempleOwnership($vazhipad);

        $validated = $this->validateRequest($request);

        $vazhipad->update($validated);

        return redirect()
            ->route('temple.vazhipad.index')
            ->with('success', 'Vazhipad updated successfully.');
    }

    public function destroy(Vazhipad $vazhipad)
    {
        $this->checkTempleOwnership($vazhipad);

        $vazhipad->update([
            'status' => 'inactive',
        ]);

        return redirect()
            ->route('temple.vazhipad.index')
            ->with(
                'success',
                'Vazhipad deactivated successfully.'
            );
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);
    }

    private function checkTempleOwnership(Vazhipad $vazhipad): void
    {
        abort_if(
            $vazhipad->temple_id != session('temple_id'),
            403,
            'Unauthorized access.'
        );
    }
}