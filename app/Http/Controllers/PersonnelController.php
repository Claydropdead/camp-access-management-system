<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personnel = Personnel::latest()->paginate(10);
        return view('personnel.index', compact('personnel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('personnel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedPersonnel = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'office' => ['required', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:255'],
            'department_subunit' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:personnels'],
            'contact_number' => ['nullable', 'string', 'max:20'],
        ]);

        // Create personnel record
        $personnel = Personnel::create($validatedPersonnel);

        return redirect()->route('personnel.index')
            ->with('success', 'Personnel added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $personnel = Personnel::findOrFail($id);
        return view('personnel.show', compact('personnel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $personnel = Personnel::findOrFail($id);
        return view('personnel.edit', compact('personnel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $personnel = Personnel::findOrFail($id);
        
        $validatedPersonnel = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'office' => ['required', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:255'],
            'department_subunit' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('personnels')->ignore($personnel->id)],
            'contact_number' => ['nullable', 'string', 'max:20'],
        ]);

        $personnel->update($validatedPersonnel);

        return redirect()->route('personnel.index')
            ->with('success', 'Personnel information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $personnel = Personnel::findOrFail($id);
        $personnel->delete();

        return redirect()->route('personnel.index')
            ->with('success', 'Personnel record deleted successfully');
    }
}
