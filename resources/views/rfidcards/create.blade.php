@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/rfidcards.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="card fade-in">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Register New RFID Card</h2>
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

            <form action="{{ route('rfidcards.store') }}" method="POST" class="mt-4">
                @csrf
                
                <div class="personnel-form-section">
                    <h3 class="personnel-form-title">Card Information</h3>
                    
                    <div class="personnel-form-grid">
                        <div class="form-group">
                            <label for="card_number" class="form-label">RFID Card Number <span class="text-danger">*</span></label>
                            <input type="text" name="card_number" id="card_number" class="form-control" value="{{ old('card_number') }}" required autofocus>
                            <small class="form-text text-muted">Enter or scan the RFID card number</small>
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Status (Optional)</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">-- Default: Active --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                                <option value="damaged" {{ old('status') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                            </select>
                            <small class="form-text text-muted">Leave blank to set as 'Active' by default</small>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    <small class="form-text text-muted">Optional additional information about this card</small>
                </div>

                <div class="form-group mt-6 flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="material-icons left">save</i> Register Card
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