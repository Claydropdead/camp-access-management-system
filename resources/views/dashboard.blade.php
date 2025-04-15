@extends('layouts.app-dashboard')
@section('content')
    <div class="welcome-section fade-in">
        <h2 class="welcome-message">Welcome Back!</h2>
        <p class="welcome-subtitle">{{ __("Here's an overview of your system") }}</p>
    </div>
    
    <div class="cards-grid fade-in" style="animation-delay: 0.1s;">
        <div class="card stat-card">
            <i class="material-icons stat-icon">trending_up</i>
            <span class="stat-label">Total Visits</span>
            <h2 class="stat-value">145</h2>
        </div>
        
        <div class="card stat-card">
            <i class="material-icons stat-icon">people</i>
            <span class="stat-label">New Users</span>
            <h2 class="stat-value">25</h2>
        </div>
        
        <div class="card stat-card">
            <i class="material-icons stat-icon">assignment</i>
            <span class="stat-label">Pending Tasks</span>
            <h2 class="stat-value">12</h2>
        </div>
        
        <div class="card stat-card">
            <i class="material-icons stat-icon">check_circle</i>
            <span class="stat-label">Completed</span>
            <h2 class="stat-value">78</h2>
        </div>
    </div>
    
    <div class="card wide-card fade-in" style="animation-delay: 0.2s;">
        <div class="card-header">
            <h3 class="card-title">Recent Activity</h3>
        </div>
        <div class="card-content">
            <p>Your recent activity will appear here. The system will track your interactions and display them in this section.</p>
        </div>
        <div class="card-actions">
            <a href="#" class="btn btn-secondary">
                <span class="material-icons">visibility</span>
                View All
            </a>
        </div>
    </div>
    
    <div class="card wide-card fade-in" style="animation-delay: 0.3s;">
        <div class="card-header">
            <h3 class="card-title">Quick Actions</h3>
        </div>
        <div class="card-content">
            <div class="action-buttons">
                <button class="btn btn-primary">
                    <span class="material-icons">add</span>
                    New Task
                </button>
                <button class="btn btn-primary">
                    <span class="material-icons">file_download</span>
                    Export Data
                </button>
                <button class="btn btn-primary">
                    <span class="material-icons">person_add</span>
                    Add User
                </button>
                <button class="btn btn-primary">
                    <span class="material-icons">settings</span>
                    Settings
                </button>
            </div>
        </div>
    </div>
@endsection
