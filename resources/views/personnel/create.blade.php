@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/personnel.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="card fade-in">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Add New Personnel</h2>
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

            <form action="{{ route('personnel.store') }}" method="POST" class="mt-4">
                @csrf
                
                <div class="personnel-form-section">
                    <h3 class="personnel-form-title">Basic Information</h3>
                    
                    <div class="personnel-form-grid">
                        <div class="form-group">
                            <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="firstname" id="firstname" class="form-control" 
                                   value="{{ old('firstname') }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="middlename" class="form-label">Middle Name</label>
                            <input type="text" name="middlename" id="middlename" class="form-control" 
                                   value="{{ old('middlename') }}">
                        </div>

                        <div class="form-group">
                            <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lastname" id="lastname" class="form-control" 
                                   value="{{ old('lastname') }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="personnel-form-section">
                    <h3 class="personnel-form-title">Assignment Information</h3>
                    
                    <div class="personnel-form-grid">
                        <div class="form-group">
                            <label for="office" class="form-label">Office <span class="text-danger">*</span></label>
                            <input type="text" name="office" id="office" class="form-control" 
                                   value="{{ old('office') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" name="unit" id="unit" class="form-control" 
                                   value="{{ old('unit') }}">
                        </div>

                        <div class="form-group">
                            <label for="department_subunit" class="form-label">Department/Subunit</label>
                            <input type="text" name="department_subunit" id="department_subunit" class="form-control" 
                                   value="{{ old('department_subunit') }}">
                        </div>
                    </div>
                </div>
                
                <div class="personnel-form-section">
                    <h3 class="personnel-form-title">Contact Information</h3>
                    
                    <div class="personnel-form-grid">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" id="contact_number" class="form-control" 
                                   value="{{ old('contact_number') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-6 flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="material-icons left">save</i> Create Personnel
                    </button>
                    <a href="{{ route('personnel.index') }}" class="btn btn-secondary">
                        <i class="material-icons left">cancel</i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection