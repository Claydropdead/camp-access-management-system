@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/personnel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rfidcards.css') }}">
@endsection

@section('content')
<div class="desktop-container">
    <div class="page-header">
        <h1 class="page-title">Personnel Management</h1>
        <a href="{{ route('personnel.index') }}" class="back-link">
            <i class="material-icons">arrow_back</i> Back to List
        </a>
    </div>
    
    <div class="desktop-form-layout">
        <div class="desktop-card primary-card">
            <div class="desktop-card-header">
                <h2 class="desktop-card-title">Add New Personnel</h2>
                <div class="rfid-card-icon">
                    <i class="material-icons">person_add</i>
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

            <form action="{{ route('personnel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="desktop-grid-layout">
                    <div class="desktop-card form-section-card">
                        <div class="desktop-card-content">
                            <h3 class="section-title">Basic Information</h3>
                            
                            <div class="form-group">
                                <label for="firstname" class="form-label required-field">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="rfid-input" 
                                       value="{{ old('firstname') }}" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" name="middlename" id="middlename" class="rfid-input" 
                                       value="{{ old('middlename') }}">
                            </div>

                            <div class="form-group">
                                <label for="lastname" class="form-label required-field">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="rfid-input" 
                                       value="{{ old('lastname') }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="rank" class="form-label">Rank</label>
                                <input type="text" name="rank" id="rank" class="rfid-input" 
                                       value="{{ old('rank') }}">
                                <span class="form-helper-text">Military/Police rank or position title</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="desktop-card form-section-card">
                        <div class="desktop-card-content">
                            <h3 class="section-title">Assignment Information</h3>
                            
                            <div class="form-group">
                                <label for="office" class="form-label required-field">Office</label>
                                <input type="text" name="office" id="office" class="rfid-input" 
                                       value="{{ old('office') }}" required>
                                <span class="form-helper-text">Primary office or department</span>
                            </div>

                            <div class="form-group">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" name="unit" id="unit" class="rfid-input" 
                                       value="{{ old('unit') }}">
                            </div>

                            <div class="form-group">
                                <label for="department_subunit" class="form-label">Department/Subunit</label>
                                <input type="text" name="department_subunit" id="department_subunit" class="rfid-input" 
                                       value="{{ old('department_subunit') }}">
                                <span class="form-helper-text">Specific division or team within the office</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="desktop-card form-section-card">
                        <div class="desktop-card-content">
                            <h3 class="section-title">Contact Information</h3>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="rfid-input" 
                                       value="{{ old('email') }}">
                                <span class="form-helper-text">Work email address</span>
                            </div>

                            <div class="form-group">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" name="contact_number" id="contact_number" class="rfid-input" 
                                       value="{{ old('contact_number') }}">
                                <span class="form-helper-text">Mobile or office phone number</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="desktop-card form-section-card">
                        <div class="desktop-card-content">
                            <h3 class="section-title">Profile Picture</h3>
                            
                            <div class="form-group">
                                <label for="picture" class="form-label">Personnel Photo</label>
                                <div class="file-upload-container">
                                    <div class="file-preview" id="picture-preview">
                                        <i class="material-icons">add_a_photo</i>
                                    </div>
                                    <input type="file" name="picture" id="picture" class="rfid-input" 
                                           onchange="previewImage(this)">
                                    <span class="form-helper-text">Upload a profile picture (JPEG, PNG, GIF - max 2MB)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="desktop-card-actions">
                    <a href="{{ route('personnel.index') }}" class="cancel-card-btn">
                        <i class="material-icons">cancel</i> Cancel
                    </a>
                    <button type="submit" class="register-card-btn">
                        <i class="material-icons">save</i> Create Personnel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('picture-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.style.backgroundImage = `url('${e.target.result}')`;
                preview.innerHTML = '';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.backgroundImage = '';
            preview.innerHTML = '<i class="material-icons">add_a_photo</i>';
        }
    }
</script>
@endsection