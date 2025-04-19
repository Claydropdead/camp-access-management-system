<?php

namespace App\Http\Controllers;

use App\Models\RFIDCard;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class RFIDCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = RFIDCard::with('personnel')->latest()->paginate(10);
        return view('rfidcards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rfidcards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_number' => ['required', 'string', 'max:50', 'unique:rfid_cards'],
            'status' => ['nullable', 'in:active,inactive,lost,damaged'],
            'notes' => ['nullable', 'string'],
        ]);

        $card = RFIDCard::create([
            'card_number' => $validated['card_number'],
            'status' => $validated['status'] ?? 'active',
            'notes' => $validated['notes'] ?? null,
            'issued_at' => Carbon::now(),
        ]);

        return redirect()->route('rfidcards.index')
            ->with('success', 'RFID card registered successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $card = RFIDCard::with('personnel')->findOrFail($id);
        return view('rfidcards.show', compact('card'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $card = RFIDCard::with('personnel')->findOrFail($id);
        $personnel = Personnel::orderBy('lastname')->get();
        return view('rfidcards.edit', compact('card', 'personnel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $card = RFIDCard::findOrFail($id);
        
        $validated = $request->validate([
            'card_number' => ['required', 'string', 'max:50', Rule::unique('rfid_cards')->ignore($card->id)],
            'status' => ['required', 'in:active,inactive,lost,damaged'],
            'personnel_id' => ['nullable', 'exists:personnels,id'],
            'notes' => ['nullable', 'string'],
        ]);

        // If this card is becoming active and is assigned to someone, deactivate other active cards
        if ($validated['status'] === 'active' && !empty($validated['personnel_id'])) {
            RFIDCard::where('personnel_id', $validated['personnel_id'])
                  ->where('id', '!=', $card->id)
                  ->where('status', 'active')
                  ->update(['status' => 'inactive']);
        }

        $card->update($validated);

        return redirect()->route('rfidcards.index')
            ->with('success', 'RFID card updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $card = RFIDCard::findOrFail($id);
        $card->delete();

        return redirect()->route('rfidcards.index')
            ->with('success', 'RFID card deleted successfully');
    }
    
    /**
     * Assign an RFID card to personnel.
     */
    public function assignToPersonnel(Request $request, string $id)
    {
        $card = RFIDCard::findOrFail($id);
        
        $validated = $request->validate([
            'personnel_id' => ['required', 'exists:personnels,id'],
        ]);
        
        // If card is active, deactivate other active cards for this personnel
        if ($card->status === 'active') {
            RFIDCard::where('personnel_id', $validated['personnel_id'])
                  ->where('id', '!=', $card->id)
                  ->where('status', 'active')
                  ->update(['status' => 'inactive']);
        }
        
        $card->update([
            'personnel_id' => $validated['personnel_id'],
        ]);
        
        $personnel = Personnel::find($validated['personnel_id']);
        return redirect()->route('rfidcards.index')
            ->with('success', 'RFID card assigned to ' . $personnel->full_name);
    }
    
    /**
     * Unassign an RFID card from personnel.
     */
    public function unassign(string $id)
    {
        $card = RFIDCard::findOrFail($id);
        $personnel = $card->personnel;
        
        $card->update([
            'personnel_id' => null,
        ]);
        
        return redirect()->route('rfidcards.index')
            ->with('success', 'RFID card unassigned from ' . ($personnel ? $personnel->full_name : 'personnel'));
    }
}
