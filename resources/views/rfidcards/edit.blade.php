@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/rfidcards.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="card fade-in">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Edit RFID Card</h2>
                <a href="{{ route('rfidcards.index') }}" class="btn btn-secondary">
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

            <form action="{{ route('rfidcards.update', $card->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                
                <div class="personnel-form-section">
                    <h3 class="personnel-form-title">Card Information</h3>
                    
                    <div class="personnel-form-grid">
                        <div class="form-group">
                            <label for="card_number" class="form-label">RFID Card Number <span class="text-danger">*</span></label>
                            <input type="text" name="card_number" id="card_number" class="form-control" 
                                   value="{{ old('card_number', $card->card_number) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select">
                                <option value="active" {{ old('status', $card->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $card->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="lost" {{ old('status', $card->status) == 'lost' ? 'selected' : '' }}>Lost</option>
                                <option value="damaged" {{ old('status', $card->status) == 'damaged' ? 'selected' : '' }}>Damaged</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="personnel_id" class="form-label">Assigned To</label>
                            <select name="personnel_id" id="personnel_id" class="form-select">
                                <option value="">-- Not Assigned --</option>
                                @foreach($personnel as $person)
                                    <option value="{{ $person->id }}" {{ old('personnel_id', $card->personnel_id) == $person->id ? 'selected' : '' }}>
                                        {{ $person->full_name }} ({{ $person->department_subunit ?? $person->office }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="material-icons" style="font-size: 14px; vertical-align: text-bottom;">info</i>
                                If this card is active and assigned to someone, any other active cards for that person will be deactivated.
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="issued_at" class="form-label">Issued Date</label>
                            <input type="date" name="issued_at" id="issued_at" class="form-control" 
                                   value="{{ old('issued_at', $card->issued_at ? $card->issued_at->format('Y-m-d') : '') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="expires_at" class="form-label">Expiration Date</label>
                            <input type="date" name="expires_at" id="expires_at" class="form-control" 
                                   value="{{ old('expires_at', $card->expires_at ? $card->expires_at->format('Y-m-d') : '') }}">
                            <small class="form-text text-muted">Optional: Leave blank if the card does not expire</small>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $card->notes) }}</textarea>
                </div>

                <div class="form-group mt-6 flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="material-icons left">save</i> Update Card
                    </button>
                    <a href="{{ route('rfidcards.index') }}" class="btn btn-secondary">
                        <i class="material-icons left">cancel</i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection