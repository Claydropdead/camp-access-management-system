@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/personnel.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="card fade-in">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Personnel Management</h2>
                <a href="{{ route('personnel.create') }}" class="btn btn-primary">
                    <i class="material-icons left">person_add</i> Add New Personnel
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="personnel-filters">
                <div class="personnel-search">
                    <i class="material-icons">search</i>
                    <input type="text" id="personnelSearchInput" class="form-control" placeholder="Search by name, office, or unit...">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="personnel-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Office</th>
                            <th>Unit</th>
                            <th>Department/Subunit</th>
                            <th>Contact Information</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($personnel as $person)
                            <tr class="personnel-row">
                                <td data-label="Name">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-primary-light text-white font-bold">
                                                {{ strtoupper(substr($person->firstname, 0, 1)) }}{{ strtoupper(substr($person->lastname, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="font-medium text-primary-color">{{ $person->full_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Office">{{ $person->office }}</td>
                                <td data-label="Unit">{{ $person->unit ?? 'N/A' }}</td>
                                <td data-label="Department/Subunit">{{ $person->department_subunit ?? 'N/A' }}</td>
                                <td data-label="Contact Information">
                                    @if($person->email || $person->contact_number)
                                        <div>
                                            @if($person->email)
                                                <div class="flex items-center text-sm">
                                                    <i class="material-icons mr-2 text-primary-color" style="font-size: 16px;">email</i>
                                                    {{ $person->email }}
                                                </div>
                                            @endif
                                            @if($person->contact_number)
                                                <div class="flex items-center text-sm mt-1">
                                                    <i class="material-icons mr-2 text-primary-color" style="font-size: 16px;">phone</i>
                                                    {{ $person->contact_number }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-500">No contact info</span>
                                    @endif
                                </td>
                                <td data-label="Actions">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('personnel.show', $person->id) }}" class="btn btn-sm btn-info btn-icon" title="View Details">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <a href="{{ route('personnel.edit', $person->id) }}" class="btn btn-sm btn-primary btn-icon" title="Edit Personnel">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <form action="{{ route('personnel.destroy', $person->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this personnel record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Delete Personnel">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No personnel records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $personnel->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('personnelSearchInput');
        const personnelRows = document.querySelectorAll('.personnel-row');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            personnelRows.forEach(row => {
                const name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const office = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const unit = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const dept = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || office.includes(searchTerm) || 
                    unit.includes(searchTerm) || dept.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection