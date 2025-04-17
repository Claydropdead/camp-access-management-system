@extends('layouts.app-dashboard')

@section('styles')
<link href="{{ asset('css/visitor-approvals.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="approvals-container">
    <h2 class="welcome-message">Visitor Approvals</h2>
    
    <div class="data-table-container">
        <div class="data-table-header">
            <div class="data-table-title">Visitor Registration List</div>
            <div class="data-table-actions">
                <div class="search-box">
                    <i class="material-icons" style="color: rgba(0,0,0,0.54);">search</i>
                    <input type="text" placeholder="Search" id="search-input">
                </div>
                <div class="action-icon" title="Download">
                    <i class="material-icons">cloud_download</i>
                </div>
                <div class="action-icon" title="Print">
                    <i class="material-icons">print</i>
                </div>
                <div class="action-icon" title="View options">
                    <i class="material-icons">view_column</i>
                </div>
                <div class="action-icon" title="More options">
                    <i class="material-icons">more_vert</i>
                </div>
            </div>
        </div>
        
        <form id="bulk-action-form" action="{{ route('admin.visitors.bulk-action') }}" method="POST">
            @csrf
            <input type="hidden" name="bulk_action" id="bulk_action" value="">
            
            <div class="bulk-actions-bar" id="bulk-actions-bar">
                <span class="bulk-count"><span id="selected-count">0</span> selected</span>
                <button type="button" id="bulk-approve-btn" class="bulk-button approve">
                    <i class="material-icons">check_circle</i> Approve
                </button>
                <button type="button" id="bulk-reject-btn" class="bulk-button reject">
                    <i class="material-icons">cancel</i> Reject
                </button>
            </div>
            
            <div class="responsive-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="checkbox-cell">
                                <div class="checkbox-container">
                                    <div class="checkbox" id="select-all-checkbox">
                                        <input type="checkbox" id="select-all">
                                    </div>
                                </div>
                            </th>
                            <th class="th-name">Name</th>
                            <th class="th-email">Email</th>
                            <th class="th-contact">Contact</th>
                            <th class="th-purpose">Purpose</th>
                            <th class="th-date">Visit Date</th>
                            <th class="th-person">Contact Person</th>
                            <th class="th-office">Office</th>
                            <th class="th-status">Status</th>
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($registrations as $reg)
                        <tr data-id="{{ $reg->id }}" class="data-row">
                            <td class="checkbox-cell">
                                <div class="checkbox-container">
                                    @if($reg->status === 'pending')
                                    <div class="checkbox">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $reg->id }}" class="row-checkbox">
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td data-label="Name">{{ $reg->name }}</td>
                            <td data-label="Email">{{ $reg->email }}</td>
                            <td data-label="Contact">{{ $reg->contact_number }}</td>
                            <td data-label="Purpose">
                                <div class="expandable-text" title="{{ $reg->purpose }}">{{ Str::limit($reg->purpose, 30) }}</div>
                            </td>
                            <td data-label="Visit Date">{{ $reg->visit_date }}</td>
                            <td data-label="Contact Person">{{ $reg->contact_person }}</td>
                            <td data-label="Office">{{ $reg->office }}</td>
                            <td data-label="Status">
                                @if($reg->status === 'pending')
                                    <span class="status-badge status-pending">Pending</span>
                                @elseif($reg->status === 'approved')
                                    <span class="status-badge status-approved">Approved</span>
                                @elseif($reg->status === 'rejected')
                                    <span class="status-badge status-rejected">Rejected</span>
                                @endif
                            </td>
                            <td data-label="Actions">
                                @if($reg->status === 'pending')
                                <div class="action-buttons-container">
                                    <form action="{{ route('admin.visitors.action', $reg->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="action-button" title="Approve" onclick="return confirm('Approve this registration?')">
                                            <i class="material-icons approve-icon">check_circle</i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.visitors.action', $reg->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="action-button" title="Reject" onclick="return confirm('Reject this registration?')">
                                            <i class="material-icons reject-icon">cancel</i>
                                        </button>
                                    </form>
                                    <button type="button" class="action-button toggle-details" title="View Details">
                                        <i class="material-icons">visibility</i>
                                    </button>
                                </div>
                                @else
                                <button type="button" class="action-button toggle-details" title="View Details">
                                    <i class="material-icons">visibility</i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        <tr class="expandable-row-content" style="display: none;">
                            <td colspan="10">
                                <div class="expandable-content">
                                    <div class="info-section">
                                        <div class="info-section-title">Visit Purpose</div>
                                        <p>{{ $reg->purpose }}</p>
                                    </div>
                                    
                                    <div class="info-section">
                                        <div class="info-section-title">ID Information</div>
                                        <p><strong>ID Type:</strong> {{ $reg->id_type }}</p>
                                        @if($reg->id_picture)
                                        <p>
                                            <a href="{{ asset('storage/id_pictures/' . $reg->id_picture) }}" target="_blank">
                                                View ID Picture
                                            </a>
                                        </p>
                                        @endif
                                    </div>
                                    
                                    @if($reg->message)
                                    <div class="info-section">
                                        <div class="info-section-title">Additional Message</div>
                                        <p>{{ $reg->message }}</p>
                                    </div>
                                    @endif
                                    
                                    <div class="info-section">
                                        <div class="info-section-title">Visit Details</div>
                                        <p><strong>Date:</strong> {{ $reg->visit_date }}</p>
                                        <p><strong>Time:</strong> {{ $reg->visit_time }}</p>
                                        <p><strong>Submitted:</strong> {{ $reg->created_at->format('Y-m-d H:i:s') }}</p>
                                    </div>
                                    
                                    @if($reg->is_group && $reg->additionalVisitors->count() > 0)
                                    <div class="info-section">
                                        <div class="info-section-title">Group Members ({{ $reg->group_size }})</div>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Name</th>
                                                    <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Contact</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reg->additionalVisitors as $visitor)
                                                <tr>
                                                    <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $visitor->name }}</td>
                                                    <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $visitor->contact_number ?: '-' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    
                                    @if($reg->has_vehicle && $reg->vehicles->count() > 0)
                                    <div class="info-section">
                                        <div class="info-section-title">Vehicles</div>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Type</th>
                                                    <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Plate</th>
                                                    <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Color</th>
                                                    <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Model</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reg->vehicles as $vehicle)
                                                <tr>
                                                    <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $vehicle->type ?: '-' }}</td>
                                                    <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $vehicle->plate_number }}</td>
                                                    <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $vehicle->color ?: '-' }}</td>
                                                    <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $vehicle->model ?: '-' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 24px;">No visitor registrations found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        
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
                <span id="pagination-info">1-{{ min($registrations->count(), 10) }} of {{ $registrations->count() }}</span>
            </div>
            <div class="pagination-actions">
                <button class="pagination-button" id="prev-page" disabled>
                    <i class="material-icons">chevron_left</i>
                </button>
                <button class="pagination-button" id="next-page" {{ $registrations->count() <= 10 ? 'disabled' : '' }}>
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
    
    // Checkbox functionality
    const checkboxes = document.querySelectorAll('.checkbox');
    checkboxes.forEach(checkbox => {
        const input = checkbox.querySelector('input[type="checkbox"]');
        if (input) {
            checkbox.addEventListener('click', function(e) {
                if (e.target.tagName !== 'INPUT') {
                    input.checked = !input.checked;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
            
            input.addEventListener('change', function() {
                if (this.checked) {
                    checkbox.classList.add('checked');
                } else {
                    checkbox.classList.remove('checked');
                }
                
                // If it's a row checkbox, update selected count
                if (this.classList.contains('row-checkbox')) {
                    updateSelectedCount();
                }
            });
        }
    });
    
    // Select All functionality
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const selectAllInput = document.getElementById('select-all');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    selectAllInput.addEventListener('change', function() {
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllInput.checked;
            
            // Update checkbox styling
            const checkboxDiv = checkbox.closest('.checkbox');
            if (checkboxDiv) {
                if (selectAllInput.checked) {
                    checkboxDiv.classList.add('checked');
                } else {
                    checkboxDiv.classList.remove('checked');
                }
            }
        });
        
        updateSelectedCount();
    });
    
    // Bulk actions bar
    const bulkActionsBar = document.getElementById('bulk-actions-bar');
    const selectedCountElement = document.getElementById('selected-count');
    
    function updateSelectedCount() {
        const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        const count = selectedCheckboxes.length;
        
        selectedCountElement.textContent = count;
        
        if (count > 0) {
            bulkActionsBar.classList.add('active');
        } else {
            bulkActionsBar.classList.remove('active');
        }
    }
    
    // Bulk action buttons
    const bulkActionForm = document.getElementById('bulk-action-form');
    const bulkActionInput = document.getElementById('bulk_action');
    const bulkApproveBtn = document.getElementById('bulk-approve-btn');
    const bulkRejectBtn = document.getElementById('bulk-reject-btn');
    
    bulkApproveBtn.addEventListener('click', function() {
        if (confirm('Approve all selected registrations?')) {
            bulkActionInput.value = 'approve';
            bulkActionForm.submit();
        }
    });
    
    bulkRejectBtn.addEventListener('click', function() {
        if (confirm('Reject all selected registrations?')) {
            bulkActionInput.value = 'reject';
            bulkActionForm.submit();
        }
    });
    
    // Expandable rows
    const toggleDetailsBtns = document.querySelectorAll('.toggle-details');
    
    toggleDetailsBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const detailsRow = row.nextElementSibling;
            
            if (detailsRow.style.display === 'none' || !detailsRow.style.display) {
                detailsRow.style.display = 'table-row';
                this.querySelector('i').textContent = 'visibility_off';
            } else {
                detailsRow.style.display = 'none';
                this.querySelector('i').textContent = 'visibility';
            }
        });
    });
    
    // Client-side pagination
    const rowsPerPageSelect = document.getElementById('rows-per-page');
    const paginationInfo = document.getElementById('pagination-info');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const dataRows = document.querySelectorAll('tr.data-row');
    
    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);
    const totalRows = dataRows.length;
    
    function updatePagination() {
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
    
    // Search functionality
    const searchInput = document.getElementById('search-input');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        if (searchTerm.length === 0) {
            // Reset to show all rows based on pagination
            dataRows.forEach(row => row.classList.remove('filtered-out'));
            currentPage = 1;
            updatePagination();
            return;
        }
        
        // Filter rows
        dataRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
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
        
        // Disable pagination when searching
        const filteredCount = document.querySelectorAll('tr.data-row:not(.filtered-out)').length;
        paginationInfo.textContent = `${filteredCount} of ${totalRows}`;
        prevPageBtn.disabled = true;
        nextPageBtn.disabled = true;
    });
    
    // Responsive table handling
    function adjustTableForMobile() {
        if (window.innerWidth < 768) {
            document.querySelector('.data-table').classList.add('mobile-view');
        } else {
            document.querySelector('.data-table').classList.remove('mobile-view');
        }
    }
    
    // Call on load and resize
    adjustTableForMobile();
    window.addEventListener('resize', adjustTableForMobile);
});
</script>
@endsection