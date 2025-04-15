<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\VisitorRegistration;
use App\Models\AdditionalVisitor;
use App\Models\VisitorVehicle;

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
            'is_group' => 'nullable',
            'group_size' => 'nullable|integer|min:2|max:20',
            'additional_visitors' => 'nullable|array',
            'additional_visitors.*.name' => 'nullable|string|max:255',
            'additional_visitors.*.contact_number' => 'nullable|string|max:20',
            'has_vehicle' => 'nullable',
            'vehicles' => 'nullable|array',
            'vehicles.*.type' => 'nullable|string|max:255',
            'vehicles.*.plate_number' => 'nullable|string|max:255',
            'vehicles.*.color' => 'nullable|string|max:255',
            'vehicles.*.model' => 'nullable|string|max:255',
        ]);

        // Handle the ID picture upload
        if ($request->hasFile('picture_of_id')) {
            $idPicture = $request->file('picture_of_id');
            $filename = time() . '.' . $idPicture->getClientOriginalExtension();
            $idPicture->storeAs('public/id_pictures', $filename);
            $validated['id_picture'] = $filename;
        }

        // Prepare main registration data
        $registration = VisitorRegistration::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact_number' => $validated['contact_number'],
            'id_type' => $validated['id'],
            'id_picture' => $validated['id_picture'],
            'purpose' => $validated['purpose'],
            'message' => $validated['message'] ?? null,
            'is_group' => $request->has('is_group'),
            'group_size' => $request->input('group_size'),
            'visit_date' => $validated['visit_date'],
            'visit_time' => $validated['visit_time'],
            'contact_person' => $validated['contact_person'],
            'office' => $validated['office'],
            'has_vehicle' => $request->has('has_vehicle'),
            'status' => 'pending',
        ]);

        // Store additional visitors if group
        if ($request->has('is_group') && is_array($request->input('additional_visitors'))) {
            foreach ($request->input('additional_visitors') as $visitor) {
                if (!empty($visitor['name'])) {
                    AdditionalVisitor::create([
                        'visitor_registration_id' => $registration->id,
                        'name' => $visitor['name'],
                        'contact_number' => $visitor['contact_number'] ?? null,
                    ]);
                }
            }
        }

        // Store vehicles if has_vehicle
        if ($request->has('has_vehicle') && is_array($request->input('vehicles'))) {
            foreach ($request->input('vehicles') as $vehicle) {
                if (!empty($vehicle['plate_number'])) {
                    VisitorVehicle::create([
                        'visitor_registration_id' => $registration->id,
                        'type' => $vehicle['type'] ?? null,
                        'plate_number' => $vehicle['plate_number'],
                        'color' => $vehicle['color'] ?? null,
                        'model' => $vehicle['model'] ?? null,
                    ]);
                }
            }
        }

        // Flash success message to the session
        return redirect()->route('booking.index')->with('success', 'Your visitor pre-registration has been submitted successfully. You will receive a confirmation soon.');
    }

    public function adminIndex()
    {
        $registrations = \App\Models\VisitorRegistration::with(['additionalVisitors', 'vehicles'])->orderBy('created_at', 'desc')->get();
        return view('admin.visitor-approvals', compact('registrations'));
    }

    public function adminAction(Request $request, $id)
    {
        $registration = \App\Models\VisitorRegistration::findOrFail($id);
        $action = $request->input('action');
        if ($registration->status !== 'pending') {
            return redirect()->route('admin.visitors')->with('error', 'Action not allowed.');
        }
        if ($action === 'approve') {
            $registration->status = 'approved';
            $registration->save();
            return redirect()->route('admin.visitors')->with('success', 'Registration approved.');
        } elseif ($action === 'reject') {
            $registration->status = 'rejected';
            $registration->save();
            return redirect()->route('admin.visitors')->with('success', 'Registration rejected.');
        }
        return redirect()->route('admin.visitors')->with('error', 'Invalid action.');
    }

    public function bulkAction(Request $request)
    {
        $selectedIds = $request->input('selected_ids', []);
        $action = $request->input('bulk_action');
        
        if (empty($selectedIds) || !in_array($action, ['approve', 'reject'])) {
            return redirect()->route('admin.visitors')->with('error', 'Invalid action or no items selected.');
        }
        
        $count = 0;
        foreach ($selectedIds as $id) {
            $registration = VisitorRegistration::find($id);
            if ($registration && $registration->status === 'pending') {
                $registration->status = $action === 'approve' ? 'approved' : 'rejected';
                $registration->save();
                $count++;
            }
        }
        
        $actionText = $action === 'approve' ? 'approved' : 'rejected';
        return redirect()->route('admin.visitors')
            ->with('success', "{$count} " . ($count === 1 ? 'registration' : 'registrations') . " {$actionText} successfully.");
    }
}
