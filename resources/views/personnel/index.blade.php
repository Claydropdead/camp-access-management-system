@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/personnel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rfidcards.css') }}">
@endsection

@section('content')
<div class="desktop-container">
    <h2 class="welcome-message">Personnel Management</h2>
    
    <div class="data-table-container">
        <div class="data-table-header">
            <div class="data-table-title">Personnel List</div>
            <div class="data-table-actions">
                <div class="search-box">
                    <i class="material-icons" style="color: rgba(0,0,0,0.54);">search</i>
                    <input type="text" placeholder="Search" id="personnelSearchInput">
                </div>
                <a href="{{ route('personnel.create') }}" class="add-button">
                    <i class="material-icons">person_add</i>
                    <span class="add-text">New Personnel</span>
                </a>
            </div>
        </div>

        <div class="responsive-table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="th-name">Name</th>
                        <th class="th-office">Office</th>
                        <th class="th-unit">Unit</th>
                        <th class="th-department">Department/Subunit</th>
                        <th class="th-contact">Contact Information</th>
                        <th class="th-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($personnel as $person)
                        <tr class="data-row">
                            <td data-label="Name">
                                <div class="personnel-profile">
                                    <div class="personnel-avatar">
                                        {{ strtoupper(substr($person->firstname, 0, 1)) }}{{ strtoupper(substr($person->lastname, 0, 1)) }}
                                    </div>
                                    <span class="personnel-name">{{ $person->full_name }}</span>
                                </div>
                            </td>
                            <td data-label="Office">{{ $person->office }}</td>
                            <td data-label="Unit">{{ $person->unit ?? 'N/A' }}</td>
                            <td data-label="Department/Subunit">{{ $person->department_subunit ?? 'N/A' }}</td>
                            <td data-label="Contact Information">
                                @if($person->email || $person->contact_number)
                                    <div class="contact-info">
                                        @if($person->email)
                                            <div class="contact-item">
                                                <i class="material-icons">email</i>
                                                <span class="contact-text">{{ $person->email }}</span>
                                            </div>
                                        @endif
                                        @if($person->contact_number)
                                            <div class="contact-item">
                                                <i class="material-icons">phone</i>
                                                <span class="contact-text">{{ $person->contact_number }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="unassigned">No contact info</span>
                                @endif
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons-container">
                                    <a href="{{ route('personnel.show', $person->id) }}" class="action-button" title="View Details">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                    <a href="{{ route('personnel.edit', $person->id) }}" class="action-button" title="Edit Personnel">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <form action="{{ route('personnel.destroy', $person->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-button" title="Delete Personnel"
                                            onclick="return confirm('Are you sure you want to delete this personnel record?');">
                                            <i class="material-icons reject-icon">delete</i>
                                        </button>
                                    </form>
                                    <button type="button" class="action-button toggle-details" title="View Details">
                                        <i class="material-icons">expand_more</i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="expandable-row-content" style="display: none;">
                            <td colspan="6">
                                <div class="expandable-content">
                                    <div class="info-section">
                                        <div class="info-section-title">Personnel Details</div>
                                        <p><strong>Full Name:</strong> {{ $person->full_name }}</p>
                                        <p><strong>Office:</strong> {{ $person->office }}</p>
                                        @if($person->unit)
                                            <p><strong>Unit:</strong> {{ $person->unit }}</p>
                                        @endif
                                        @if($person->department_subunit)
                                            <p><strong>Department/Subunit:</strong> {{ $person->department_subunit }}</p>
                                        @endif
                                    </div>
                                    
                                    @if($person->email || $person->contact_number)
                                    <div class="info-section">
                                        <div class="info-section-title">Contact Information</div>
                                        @if($person->email)
                                            <p><strong>Email:</strong> {{ $person->email }}</p>
                                        @endif
                                        @if($person->contact_number)
                                            <p><strong>Contact Number:</strong> {{ $person->contact_number }}</p>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-table">
                                <div class="empty-state">
                                    <i class="material-icons">person_off</i>
                                    <p>No personnel records found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="data-table-footer">
            <div class="rows-per-page">
                <span>Rows per page:</span>
                <select class="rows-select" id="rows-per-page">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="pagination-range">
                <span id="pagination-info">1-{{ min($personnel->count(), 10) }} of {{ $personnel->count() }}</span>
            </div>
            <div class="pagination-actions">
                <button class="pagination-button" id="prev-page" disabled>
                    <i class="material-icons">chevron_left</i>
                </button>
                <button class="pagination-button" id="next-page" {{ $personnel->count() <= 10 ? 'disabled' : '' }}>
                    <i class="material-icons">chevron_right</i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="toast success" id="success-toast">
    <i class="material-icons">check_circle</i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="toast error" id="error-toast">
    <i class="material-icons">error</i>
    <span>{{ session('error') }}</span>
</div>
@endif

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toast auto-hide
    setTimeout(() => {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(toast => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.remove();
            }, 300);
        });
    }, 4000);
    
    // Expandable rows
    const toggleDetailsBtns = document.querySelectorAll('.toggle-details');
    
    toggleDetailsBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const detailsRow = row.nextElementSibling;
            
            if (detailsRow.style.display === 'none' || !detailsRow.style.display) {
                detailsRow.style.display = 'table-row';
                this.querySelector('i').textContent = 'expand_less';
            } else {
                detailsRow.style.display = 'none';
                this.querySelector('i').textContent = 'expand_more';
            }
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('personnelSearchInput');
    const dataRows = document.querySelectorAll('.data-row');
    
    function filterPersonnel() {
        const searchTerm = searchInput.value.toLowerCase();
        
        dataRows.forEach(row => {
            const name = row.querySelector('[data-label="Name"]').textContent.toLowerCase();
            const office = row.querySelector('[data-label="Office"]').textContent.toLowerCase();
            const unit = row.querySelector('[data-label="Unit"]').textContent.toLowerCase();
            const department = row.querySelector('[data-label="Department/Subunit"]').textContent.toLowerCase();
            const contact = row.querySelector('[data-label="Contact Information"]').textContent.toLowerCase();
            
            // Match search term
            const matchesSearch = searchTerm === '' || 
                                 name.includes(searchTerm) || 
                                 office.includes(searchTerm) || 
                                 unit.includes(searchTerm) ||
                                 department.includes(searchTerm) ||
                                 contact.includes(searchTerm);
            
            // Show/hide row based on search
            if (matchesSearch) {
                row.classList.remove('filtered-out');
                row.style.display = '';
            } else {
                row.classList.add('filtered-out');
                row.style.display = 'none';
                
                // Hide the details row if exists
                const detailsRow = row.nextElementSibling;
                if (detailsRow && detailsRow.classList.contains('expandable-row-content')) {
                    detailsRow.style.display = 'none';
                }
            }
        });
        
        updatePagination();
    }
    
    searchInput.addEventListener('input', filterPersonnel);
    
    // Client-side pagination
    const rowsPerPageSelect = document.getElementById('rows-per-page');
    const paginationInfo = document.getElementById('pagination-info');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    
    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);
    const totalRows = dataRows.length;
    
    function updatePagination() {
        // Only count rows that aren't filtered out
        const visibleRows = document.querySelectorAll('tr.data-row:not(.filtered-out)');
        const totalVisibleRows = visibleRows.length;
        
        if (searchInput.value !== '') {
            // When filtering, show all visible rows
            paginationInfo.textContent = `${totalVisibleRows} of ${totalRows}`;
            prevPageBtn.disabled = true;
            nextPageBtn.disabled = true;
            return;
        }
        
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = Math.min(startIndex + rowsPerPage, totalRows);
        
        // Hide all rows
        dataRows.forEach((row, index) => {
            // Hide the row
            row.style.display = 'none';
            
            // Hide the details row if exists
            const detailsRow = row.nextElementSibling;
            if (detailsRow && detailsRow.classList.contains('expandable-row-content')) {
                detailsRow.style.display = 'none';
            }
        });
        
        // Show rows for current page
        for (let i = startIndex; i < endIndex; i++) {
            if (dataRows[i]) {
                dataRows[i].style.display = '';
            }
        }
        
        // Update pagination info
        paginationInfo.textContent = totalRows === 0 
            ? '0-0 of 0' 
            : `${startIndex + 1}-${endIndex} of ${totalRows}`;
        
        // Update button states
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage >= Math.ceil(totalRows / rowsPerPage);
    }
    
    // Initialize pagination
    updatePagination();
    
    // Change rows per page
    rowsPerPageSelect.addEventListener('change', function() {
        rowsPerPage = parseInt(this.value);
        currentPage = 1;
        updatePagination();
    });
    
    // Previous page
    prevPageBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    });
    
    // Next page
    nextPageBtn.addEventListener('click', function() {
        const maxPage = Math.ceil(totalRows / rowsPerPage);
        if (currentPage < maxPage) {
            currentPage++;
            updatePagination();
        }
    });
});
</script>
@endsection