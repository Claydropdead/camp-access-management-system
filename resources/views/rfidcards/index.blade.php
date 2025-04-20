@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/rfidcards.css') }}">
@endsection

@section('content')
<div class="desktop-container">
    <h2 class="welcome-message">RFID Card Management</h2>
    
    <div class="data-table-container">
        <div class="data-table-header">
            <div class="data-table-title">RFID Cards List</div>
            <div class="data-table-actions">
                <div class="search-box">
                    <i class="material-icons" style="color: rgba(0,0,0,0.54);">search</i>
                    <input type="text" placeholder="Search" id="cardSearchInput">
                </div>
                <div class="filter-box">
                    <select id="statusFilter" class="filter-select">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="lost">Lost</option>
                        <option value="damaged">Damaged</option>
                    </select>
                </div>
                <a href="{{ route('rfidcards.create') }}" class="add-button">
                    <i class="material-icons">add</i>
                    <span class="add-text">New Card</span>
                </a>
            </div>
        </div>

        <form id="bulkActionForm" action="{{ route('rfidcards.bulk-action') }}" method="POST">
            @csrf
            <input type="hidden" name="bulk_action" id="bulk_action" value="">
            
            <div class="bulk-actions-bar" id="bulk-actions-bar">
                <span class="bulk-count"><span id="selected-count">0</span> selected</span>
                <button type="button" id="bulk-activate-btn" class="bulk-button approve">
                    <i class="material-icons">check_circle</i> Activate
                </button>
                <button type="button" id="bulk-deactivate-btn" class="bulk-button neutral">
                    <i class="material-icons">pause_circle</i> Deactivate
                </button>
                <button type="button" id="bulk-delete-btn" class="bulk-button reject">
                    <i class="material-icons">delete</i> Delete
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
                            <th class="th-card-number">Card Number</th>
                            <th class="th-status">Status</th>
                            <th class="th-assigned">Assigned To</th>
                            <th class="th-date">Issued Date</th>
                            <th class="th-notes">Notes</th>
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cards as $card)
                            <tr class="data-row" data-status="{{ $card->status }}">
                                <td class="checkbox-cell">
                                    <div class="checkbox-container">
                                        <div class="checkbox">
                                            <input type="checkbox" name="selected_ids[]" value="{{ $card->id }}" class="row-checkbox">
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Card Number">
                                    <span class="card-number">{{ $card->card_number }}</span>
                                </td>
                                <td data-label="Status">
                                    <span class="status-badge status-{{ $card->status }}">
                                        <i class="material-icons">
                                            @if ($card->status == 'active')
                                                check_circle
                                            @elseif ($card->status == 'inactive')
                                                pause_circle
                                            @elseif ($card->status == 'lost')
                                                error
                                            @else
                                                broken_image
                                            @endif
                                        </i>
                                        {{ ucfirst($card->status) }}
                                    </span>
                                </td>
                                <td data-label="Assigned To">
                                    @if ($card->personnel)
                                        <div class="assigned-personnel">
                                            <span class="personnel-icon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <a href="{{ route('personnel.edit', $card->personnel->id) }}" class="personnel-name">
                                                {{ $card->personnel->full_name }}
                                            </a>
                                        </div>
                                    @else
                                        <span class="unassigned">Not assigned</span>
                                    @endif
                                </td>
                                <td data-label="Issued Date">{{ $card->issued_at ? $card->issued_at->format('M d, Y') : 'N/A' }}</td>
                                <td data-label="Notes">
                                    <div class="expandable-text" title="{{ $card->notes }}">
                                        {{ Str::limit($card->notes ?? 'N/A', 30) }}
                                    </div>
                                </td>
                                <td data-label="Actions">
                                    <div class="action-buttons-container">
                                        <a href="{{ route('rfidcards.edit', $card->id) }}" class="action-button" title="Edit Card">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        
                                        @if(!$card->personnel_id)
                                            <button type="button" class="action-button assign-button" 
                                                    title="Assign to Personnel" data-card-id="{{ $card->id }}">
                                                <i class="material-icons">person_add</i>
                                            </button>
                                        @else
                                            <form action="{{ route('rfidcards.unassign', $card->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="action-button" title="Unassign Card" 
                                                    onclick="return confirm('Are you sure you want to unassign this card?');">
                                                    <i class="material-icons reject-icon">person_remove</i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('rfidcards.destroy', $card->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-button" title="Delete Card"
                                                onclick="return confirm('Are you sure you want to delete this card?');">
                                                <i class="material-icons reject-icon">delete</i>
                                            </button>
                                        </form>
                                        
                                        <button type="button" class="action-button toggle-details" title="View Details">
                                            <i class="material-icons">visibility</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="expandable-row-content" style="display: none;">
                                <td colspan="7">
                                    <div class="expandable-content">
                                        <div class="info-section">
                                            <div class="info-section-title">Card Details</div>
                                            <p><strong>Card Number:</strong> {{ $card->card_number }}</p>
                                            <p><strong>Status:</strong> {{ ucfirst($card->status) }}</p>
                                            <p><strong>Issued Date:</strong> {{ $card->issued_at ? $card->issued_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
                                        </div>
                                        
                                        @if($card->personnel)
                                        <div class="info-section">
                                            <div class="info-section-title">Assigned Personnel</div>
                                            <p><strong>Name:</strong> {{ $card->personnel->full_name }}</p>
                                            <p><strong>Office:</strong> {{ $card->personnel->office }}</p>
                                            @if($card->personnel->department_subunit)
                                                <p><strong>Department:</strong> {{ $card->personnel->department_subunit }}</p>
                                            @endif
                                            @if($card->personnel->email)
                                                <p><strong>Email:</strong> {{ $card->personnel->email }}</p>
                                            @endif
                                            @if($card->personnel->contact_number)
                                                <p><strong>Contact:</strong> {{ $card->personnel->contact_number }}</p>
                                            @endif
                                        </div>
                                        @endif
                                        
                                        @if($card->notes)
                                        <div class="info-section">
                                            <div class="info-section-title">Notes</div>
                                            <p>{{ $card->notes }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-table">
                                    <div class="empty-state">
                                        <i class="material-icons">contactless</i>
                                        <p>No RFID cards found</p>
                                    </div>
                                </td>
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
                <span id="pagination-info">1-{{ min($cards->count(), 10) }} of {{ $cards->count() }}</span>
            </div>
            <div class="pagination-actions">
                <button class="pagination-button" id="prev-page" disabled>
                    <i class="material-icons">chevron_left</i>
                </button>
                <button class="pagination-button" id="next-page" {{ $cards->count() <= 10 ? 'disabled' : '' }}>
                    <i class="material-icons">chevron_right</i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Assign Personnel Modal -->
<div id="assignPersonnelModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Assign RFID Card to Personnel</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="assignForm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="personnel_id" class="form-label">Select Personnel</label>
                    <select name="personnel_id" id="personnel_id" class="form-select" required>
                        <option value="">-- Select Personnel --</option>
                        @foreach(App\Models\Personnel::orderBy('lastname')->get() as $personnel)
                            <option value="{{ $personnel->id }}">
                                {{ $personnel->full_name }} ({{ $personnel->department_subunit ?? $personnel->office }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="info-note">
                    <i class="material-icons">info</i>
                    <span>Assigning this card as active will deactivate any other active cards for the selected personnel.</span>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-cancel" id="cancelAssign">Cancel</button>
            <button type="button" class="btn btn-primary" id="submitAssign">Assign Card</button>
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
    const bulkActionForm = document.getElementById('bulkActionForm');
    const bulkActionInput = document.getElementById('bulk_action');
    const bulkActivateBtn = document.getElementById('bulk-activate-btn');
    const bulkDeactivateBtn = document.getElementById('bulk-deactivate-btn');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    
    bulkActivateBtn.addEventListener('click', function() {
        if (confirm('Activate all selected cards?')) {
            bulkActionInput.value = 'activate';
            bulkActionForm.submit();
        }
    });
    
    bulkDeactivateBtn.addEventListener('click', function() {
        if (confirm('Deactivate all selected cards?')) {
            bulkActionInput.value = 'deactivate';
            bulkActionForm.submit();
        }
    });
    
    bulkDeleteBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to delete all selected cards?')) {
            bulkActionInput.value = 'delete';
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
    
    // Search and filter functionality
    const searchInput = document.getElementById('cardSearchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dataRows = document.querySelectorAll('.data-row');
    
    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        
        dataRows.forEach(row => {
            const cardNumber = row.querySelector('[data-label="Card Number"]').textContent.toLowerCase();
            const cardStatus = row.dataset.status.toLowerCase();
            const assignedTo = row.querySelector('[data-label="Assigned To"]').textContent.toLowerCase();
            const notes = row.querySelector('[data-label="Notes"]').textContent.toLowerCase();
            
            // Match search term
            const matchesSearch = searchTerm === '' || 
                                 cardNumber.includes(searchTerm) || 
                                 assignedTo.includes(searchTerm) || 
                                 notes.includes(searchTerm);
            
            // Match status filter
            const matchesStatus = statusValue === '' || cardStatus === statusValue;
            
            // Show/hide row based on both filters
            if (matchesSearch && matchesStatus) {
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
    
    searchInput.addEventListener('input', filterCards);
    statusFilter.addEventListener('change', filterCards);
    
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
        
        if (searchInput.value !== '' || statusFilter.value !== '') {
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
    
    // Modal functionality for assigning personnel
    const modal = document.getElementById('assignPersonnelModal');
    const assignButtons = document.querySelectorAll('.assign-button');
    const closeModal = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancelAssign');
    const submitBtn = document.getElementById('submitAssign');
    const assignForm = document.getElementById('assignForm');
    
    // Open modal when assign button is clicked
    assignButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cardId = this.getAttribute('data-card-id');
            assignForm.action = `/rfidcards/${cardId}/assign`;
            modal.style.display = 'block';
        });
    });
    
    // Close modal when X is clicked
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Close modal when Cancel is clicked
    cancelBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Submit form when Assign is clicked
    submitBtn.addEventListener('click', function() {
        const personnelId = document.getElementById('personnel_id').value;
        if (personnelId) {
            assignForm.submit();
        } else {
            alert('Please select a personnel to assign this card to.');
        }
    });
    
    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
@endsection