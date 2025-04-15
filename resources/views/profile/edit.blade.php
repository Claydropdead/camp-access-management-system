@php $user = Auth::user(); @endphp
@extends('layouts.app-dashboard')
@section('content')
    <div class="welcome-section fade-in">
        <h2 class="welcome-message">Profile</h2>
        <p class="welcome-subtitle">{{ __("Manage your account information, password, and more.") }}</p>
    </div>
    <div class="card wide-card" style="margin-bottom:2rem;">
        <div class="card-header">
            <h3 class="card-title">{{ __('Profile Information') }}</h3>
        </div>
        <div class="card-content">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
    <div class="card wide-card" style="margin-bottom:2rem;">
        <div class="card-header">
            <h3 class="card-title">{{ __('Update Password') }}</h3>
        </div>
        <div class="card-content">
            @include('profile.partials.update-password-form')
        </div>
    </div>
    <div class="card wide-card">
        <div class="card-header">
            <h3 class="card-title red-text">{{ __('Delete Account') }}</h3>
        </div>
        <div class="card-content">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
