<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display the visitor pre-registration form
     */
    public function index()
    {
        return view('booking.index');
    }

    /**
     * Store a new visitor pre-registration
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'id' => 'required|string|max:255',
            'picture_of_id' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'purpose' => 'required|string|max:1000',
            'message' => 'nullable|string|max:1000',
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required',
            'contact_person' => 'required|string|max:255',
            'office' => 'required|string|max:255',
        ]);

        // Handle the ID picture upload
        if ($request->hasFile('picture_of_id')) {
            $idPicture = $request->file('picture_of_id');
            $filename = time() . '.' . $idPicture->getClientOriginalExtension();
            $idPicture->storeAs('public/id_pictures', $filename);
            $validated['picture_of_id'] = $filename;
        }

        // In a real application, you would store this in the database
        // For now, we'll just return a success message
        
        // Flash success message to the session
        return redirect()->route('booking.index')->with('success', 'Your visitor pre-registration has been submitted successfully. You will receive a confirmation soon.');
    }
}
