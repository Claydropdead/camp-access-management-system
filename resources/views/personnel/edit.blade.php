@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/personnel.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="card fade-in">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Edit Personnel</h2>
                <a href="{{ route('personnel.index') }}" class="btn btn-secondary">
                    <i class="material-icons left">arrow_back</i> Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="personnel-tabs">
                <div class="personnel-tab active" data-tab="personal-info">Personal Information</div>
                <div class="personnel-tab" data-tab="rfid-cards">RFID Cards</div>
            </div>

            <div id="personal-info" class="personnel-tab-content active">
                <form action="{{ route('personnel.update', $personnel->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="personnel-form-section">
                        <h3 class="personnel-form-title">Basic Information</h3>
                        
                        <div class="personnel-form-grid">
                            <div class="form-group">
                                <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="firstname" id="firstname" class="form-control" 
                                    value="{{ old('firstname', $personnel->firstname) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" name="middlename" id="middlename" class="form-control" 
                                    value="{{ old('middlename', $personnel->middlename) }}">
                            </div>

                            <div class="form-group">
                                <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="lastname" id="lastname" class="form-control" 
                                    value="{{ old('lastname', $personnel->lastname) }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="personnel-form-section">
                        <h3 class="personnel-form-title">Assignment Information</h3>
                        
                        <div class="personnel-form-grid">
                            <div class="form-group">
                                <label for="office" class="form-label">Office <span class="text-danger">*</span></label>
                                <input type="text" name="office" id="office" class="form-control" 
                                    value="{{ old('office', $personnel->office) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" name="unit" id="unit" class="form-control" 
                                    value="{{ old('unit', $personnel->unit) }}">
                            </div>

                            <div class="form-group">
                                <label for="department_subunit" class="form-label">Department/Subunit</label>
                                <input type="text" name="department_subunit" id="department_subunit" class="form-control" 
                                    value="{{ old('department_subunit', $personnel->department_subunit) }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="personnel-form-section">
                        <h3 class="personnel-form-title">Contact Information</h3>
                        
                        <div class="personnel-form-grid">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" 
                                    value="{{ old('email', $personnel->email) }}">
                            </div>

                            <div class="form-group">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" name="contact_number" id="contact_number" class="form-control" 
                                    value="{{ old('contact_number', $personnel->contact_number) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-6 flex gap-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="material-icons left">save</i> Update Personnel
                        </button>
                        <a href="{{ route('personnel.index') }}" class="btn btn-secondary">
                            <i class="material-icons left">cancel</i> Cancel
                        </a>
                    </div>
                </form>
            </div>

            <div id="rfid-cards" class="personnel-tab-content">
                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-2">Associated RFID Cards</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        <i class="material-icons align-middle" style="font-size: 18px;">info</i>
                        Below are all RFID cards associated with this personnel. Cards can be managed via the 
                        <a href="{{ route('rfidcards.index') }}" class="text-primary-color hover:underline">RFID Card Management</a> section.
                    </p>

                    @if($personnel->rfidCards->count() > 0)
                        <div class="rfid-cards-grid">
                            @foreach($personnel->rfidCards as $card)
                                <div class="rfid-card">
                                    <div class="rfid-card-header">
                                        <h4 class="rfid-card-number">{{ $card->card_number }}</h4>
                                    </div>
                                    <div class="rfid-card-body">
                                        <div class="rfid-card-status">
                                            <span class="status-badge status-{{ $card->status }}">
                                                <i class="material-icons">
                                                    @if ($card->status == 'active')
                                                        check_circle
                                                    @elseif ($card->status == 'inactive')
                                                        pause_circle
                                                    @elseif ($card->status == 'lost')
                                                        error
                                                    @else
                                                        broken_image
                                                    @endif
                                                </i>
                                                {{ ucfirst($card->status) }}
                                            </span>
                                        </div>
                                        <div class="rfid-card-info">
                                            <strong>Issued:</strong> {{ $card->issued_at ? $card->issued_at->format('M d, Y') : 'N/A' }}
                                        </div>
                                        @if($card->expires_at)
                                            <div class="rfid-card-info">
                                                <strong>Expires:</strong> {{ $card->expires_at->format('M d, Y') }}
                                            </div>
                                        @endif
                                        @if($card->notes)
                                            <div class="rfid-card-info">
                                                <strong>Notes:</strong> {{ $card->notes }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="rfid-card-actions">
                                        <a href="{{ route('rfidcards.edit', $card->id) }}" class="btn btn-sm btn-primary">
                                            <i class="material-icons left">edit</i> Edit
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 p-6 text-center rounded-lg border border-gray-200">
                            <p class="text-gray-500">No RFID cards associated with this personnel.</p>
                            <a href="{{ route('rfidcards.create') }}" class="btn btn-primary mt-4">
                                <i class="material-icons left">add</i> Add New Card
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabs = document.querySelectorAll('.personnel-tab');
        const tabContents = document.querySelectorAll('.personnel-tab-content');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.tab;
                
                // Update active tab
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                // Update visible content
                tabContents.forEach(content => {
                    if (content.id === target) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }
                });
            });
        });
    });
</script>
@endsection