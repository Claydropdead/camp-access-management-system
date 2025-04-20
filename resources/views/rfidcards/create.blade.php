@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/rfidcards.css') }}">
@endsection

@section('content')
<div class="desktop-container">
    <div class="page-header">
        <h1 class="page-title">RFID Card Management</h1>
        <a href="{{ route('rfidcards.index') }}" class="back-link">
            <i class="material-icons">arrow_back</i> Back to List
        </a>
    </div>
    
    <div class="desktop-form-layout">
        <div class="desktop-card primary-card">
            <div class="desktop-card-header">
                <h2 class="desktop-card-title">Register New RFID Card</h2>
                <div class="rfid-card-icon">
                    <i class="material-icons">contactless</i>
                </div>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger" style="margin: 1rem 1.5rem 0;">
                    <ul class="list-disc pl-5" style="padding-left: 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rfidcards.store') }}" method="POST">
                @csrf
                
                <div class="desktop-grid-layout">
                    <div class="desktop-card form-section-card">
                        <div class="desktop-card-content">
                            <h3 class="section-title">Card Information</h3>
                            
                            <div class="form-group">
                                <label for="card_number" class="form-label required-field">RFID Card Number</label>
                                <div class="scan-button-group">
                                    <input type="text" name="card_number" id="card_number" class="rfid-input" 
                                        value="{{ old('card_number') }}" required placeholder="Scan or enter card number">
                                    <button type="button" id="start-scan-button" class="scan-input-button" aria-label="Scan RFID Card">
                                        <i class="material-icons">contactless</i>
                                    </button>
                                </div>
                                <span class="form-helper-text">Enter manually or scan the RFID card</span>
                            </div>

                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="rfid-input rfid-select">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                                    <option value="damaged" {{ old('status') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                </select>
                                <span class="form-helper-text">Current operational status of the card</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="desktop-card form-section-card">
                        <div class="desktop-card-content">
                            <h3 class="section-title">Additional Information</h3>
                            
                            <div class="form-group">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" class="rfid-input rfid-notes" rows="5" 
                                    placeholder="Enter any comments, instructions, or details about this card">{{ old('notes') }}</textarea>
                                <span class="form-helper-text">Add any relevant information about this card or its assignment</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="desktop-card-actions">
                    <a href="{{ route('rfidcards.index') }}" class="cancel-card-btn">
                        <i class="material-icons">cancel</i> Cancel
                    </a>
                    <button type="submit" class="register-card-btn">
                        <i class="material-icons">save</i> Register Card
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- RFID Scanner Modal -->
<div id="scanner-modal" class="rfid-scanner-modal hidden">
    <div class="rfid-scanner-content">
        <div class="rfid-scanner-header">
            <h3 class="rfid-scanner-title">Scan RFID Card</h3>
            <button id="close-scanner-button" class="rfid-scanner-close" aria-label="Close scanner">&times;</button>
        </div>
        <div class="rfid-scanner-body">
            <div id="rfid-scanner-container" class="rfid-scanner-animation-container">
                <div class="rfid-card-placeholder">
                    <div class="rfid-card-chip"></div>
                    PLACE CARD ON SCANNER
                </div>
                <div id="scan-animation" class="scan-animation"></div>
                <div id="scanner-overlay" class="scanner-overlay"></div>
            </div>
            
            <div id="loading-animation" class="loading-animation">
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
                <span style="margin-left: 8px;">Scanning...</span>
            </div>
            
            <div id="success-scan" class="success-scan">
                <div class="success-icon">
                    <i class="material-icons">check</i>
                </div>
                <div class="success-message">Card Successfully Scanned!</div>
                <div>Card Number: <span class="scanned-number">-</span></div>
            </div>
        </div>
        <div class="rfid-scanner-footer">
            <button id="manual-input-button" class="scanner-button scanner-button-secondary">
                <i class="material-icons">edit</i>
                Manual Input
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/rfid-scanner.js') }}"></script>
@endsection