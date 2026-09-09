<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vazhipad;
use Illuminate\Http\Request;

class VazhipadController extends Controller
{
    public function index()
{
    $vazhipads = \App\Models\Vazhipad::latest()->get();

    return view('temple.vazhipad.index', compact('vazhipads'));
}
    public function create()
    {
        return view('temple.vazhipad.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        Vazhipad::create($validated);

        return redirect()
            ->route('temple.vazhipad.index')
            ->with('success', 'Vazhipad created successfully.');
    }

    public function show(Vazhipad $vazhipad)
    {
        return view('temple.vazhipad.show', compact('vazhipad'));
    }

    public function edit(Vazhipad $vazhipad)
    {
        return view('temple.vazhipad.edit', compact('vazhipad'));
    }

    public function update(Request $request, Vazhipad $vazhipad)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        $vazhipad->update($validated);

        return redirect()
            ->route('temple.vazhipad.index')
            ->with('success', 'Vazhipad updated successfully.');
    }

    public function destroy(Vazhipad $vazhipad)
    {
        $vazhipad->delete();

        return redirect()
            ->route('temple.vazhipad.index')
            ->with('success', 'Vazhipad deleted successfully.');
    }
}