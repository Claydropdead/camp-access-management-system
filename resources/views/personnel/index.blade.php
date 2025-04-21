@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/personnel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rfidcards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnify.css') }}">
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
                        <th class="th-rank">Rank</th>
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
                            <td data-label="Rank">{{ $person->rank ?? 'N/A' }}</td>
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
                                    <a href="{{ route('personnel.show', $person->id) }}" class="action-button toggle-details" title="View Details">
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
                                </div>
                            </td>
                        </tr>
                        <tr class="expandable-row-content" style="display: none;">
                            <td colspan="7">
                                <div class="expandable-content">                                
                                    <div class="info-card">
                                        <div class="info-card-header">
                                            <h3 class="info-card-title">Personnel Information</h3>
                                            <div class="info-card-badge">
                                                <span class="info-card-status">{{ $person->rank ?? 'No Rank' }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="info-card-body">
                                            <div class="details-with-picture">
                                                <div class="details-content">
                                                    <div class="personnel-header">
                                                        <h3 class="personnel-name-details">{{ $person->full_name }}</h3>
                                                        <div class="personnel-position">
                                                            <span class="office-badge">{{ $person->office }}</span>
                                                            @if($person->unit)
                                                                <span class="separator">•</span>
                                                                <span>{{ $person->unit }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="info-tabs">
                                                        <div class="info-tab active" data-tab="basic">Basic Info</div>
                                                        @if($person->email || $person->contact_number)
                                                            <div class="info-tab" data-tab="contact">Contact</div>
                                                        @endif
                                                        @if($person->rfidCards && $person->rfidCards->count() > 0)
                                                            <div class="info-tab" data-tab="cards">RFID Cards</div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="tab-content" id="tab-basic">
                                                        <div class="info-section-grid">
                                                            <div class="info-item">
                                                                <label>Office</label>
                                                                <p>{{ $person->office }}</p>
                                                            </div>
                                                            
                                                            @if($person->unit)
                                                            <div class="info-item">
                                                                <label>Unit</label>
                                                                <p>{{ $person->unit }}</p>
                                                            </div>
                                                            @endif
                                                            
                                                            @if($person->department_subunit)
                                                            <div class="info-item">
                                                                <label>Department/Subunit</label>
                                                                <p>{{ $person->department_subunit }}</p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    @if($person->email || $person->contact_number)
                                                    <div class="tab-content" id="tab-contact" style="display: none;">
                                                        <div class="info-section-grid">
                                                            @if($person->email)
                                                            <div class="info-item">
                                                                <label>Email</label>
                                                                <p><i class="material-icons contact-icon">email</i> {{ $person->email }}</p>
                                                            </div>
                                                            @endif
                                                            
                                                            @if($person->contact_number)
                                                            <div class="info-item">
                                                                <label>Contact Number</label>
                                                                <p><i class="material-icons contact-icon">phone</i> {{ $person->contact_number }}</p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endif
                                                    
                                                    @if($person->rfidCards && $person->rfidCards->count() > 0)
                                                    <div class="tab-content" id="tab-cards" style="display: none;">
                                                        <div class="cards-mini-list">
                                                            @foreach($person->rfidCards as $card)
                                                                <div class="card-mini-item">
                                                                    <div class="card-mini-badge status-{{ $card->status }}">
                                                                        <i class="material-icons">contactless</i>
                                                                    </div>
                                                                    <div class="card-mini-details">
                                                                        <div class="card-mini-number">{{ $card->card_number }}</div>
                                                                        <div class="card-mini-status">{{ ucfirst($card->status) }}</div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="profile-picture-container">
                                                    <div class="profile-picture-box magnify-container">
                                                        @if($person->picture)
                                                            <img src="{{ asset('storage/' . $person->picture) }}" alt="{{ $person->full_name }}" class="profile-image">
                                                        @else
                                                            <div class="no-profile-image">
                                                                <i class="material-icons">person</i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

<!-- Edit Personnel Modal -->
<div id="editPersonnelModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), #1565c0); color: white;">
            <h3>Edit Personnel</h3>
            <span class="close-modal" id="closeEditModal" style="color: white;">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editPersonnelForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="edit_firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                    <div class="input-wrapper" style="width: 100%;">
                        <input type="text" name="firstname" id="edit_firstname" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_middlename" class="form-label">Middle Name</label>
                    <div class="input-wrapper" style="width: 100%;">
                        <input type="text" name="middlename" id="edit_middlename" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <div class="input-wrapper" style="width: 100%;">
                        <input type="text" name="lastname" id="edit_lastname" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_rank" class="form-label">Rank</label>
                    <div class="input-wrapper" style="width: 100%;">
                        <input type="text" name="rank" id="edit_rank" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;">
                    </div>
                    <span class="form-helper-text">Military/Police rank or position title</span>
                </div>
                
                <div class="form-group">
                    <label for="edit_office" class="form-label">Office <span class="text-danger">*</span></label>
                    <div class="input-wrapper" style="width: 100%;">
                        <input type="text" name="office" id="edit_office" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_unit" class="form-label">Unit</label>
                    <div class="input-wrapper" style="width: 100%;">
                        <input type="text" name="unit" id="edit_unit" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_department_subunit" class="form-label">Department/Subunit</label>
                    <div class="input-wrapper" style="width: 100%;">
                        <input type="text" name="department_subunit" id="edit_department_subunit" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_email" class="form-label">Email</label>
                    <div class="input-wrapper" style="width: 100%;">
                        <input type="email" name="email" id="edit_email" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_contact_number" class="form-label">Contact Number</label>
                    <div class="input-wrapper" style="width: 100%;">
                        <input type="text" name="contact_number" id="edit_contact_number" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_picture" class="form-label">Profile Picture</label>
                    <div class="file-upload-container" style="width: 100%; position: relative;">
                        <div class="file-preview" id="edit-picture-preview" style="width: 150px; height: 150px; border-radius: 5px; border: 2px dashed #ddd; margin-bottom: 15px; display: flex; justify-content: center; align-items: center; background-size: cover; background-position: center;">
                            <i class="material-icons" style="font-size: 48px; color: #aaa;">add_a_photo</i>
                        </div>
                        <input type="file" name="picture" id="edit_picture" class="form-control" style="width: 100%; padding: 12px; box-sizing: border-box;" onchange="previewEditImage(this)">
                        <span class="form-helper-text">Upload a profile picture (JPEG, PNG, GIF - max 2MB)</span>
                    </div>
                </div>
                
                <div id="current_picture_container" style="display: none;">
                    <p>Current Picture:</p>
                    <img id="current_picture" src="" alt="Current profile picture" style="max-width: 150px; max-height: 150px; border-radius: 5px;">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-cancel" id="cancelEdit">Cancel</button>
            <button type="button" class="btn btn-primary" id="submitEdit">Update Personnel</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/magnify.js') }}"></script>
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
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent navigation to the show page
                    const row = this.closest('tr');
                    const detailsRow = row.nextElementSibling;
                    
                    if (detailsRow.style.display === 'none' || !detailsRow.style.display) {
                        detailsRow.style.display = 'table-row';
                        this.querySelector('i').textContent = 'visibility_off';
                        
                        // Initialize tabs when opening details row
                        initTabs(detailsRow);

                        // Initialize magnifiers for newly visible images
                        if (typeof window.initMagnifiers === 'function') {
                            window.initMagnifiers();
                        }
                    } else {
                        detailsRow.style.display = 'none';
                        this.querySelector('i').textContent = 'visibility';
                    }
                });
            });
            
            // Tab functionality for details sections
            function initTabs(detailsRow) {
                const tabs = detailsRow.querySelectorAll('.info-tab');
                const tabContents = detailsRow.querySelectorAll('.tab-content');
                
                if (!tabs.length) return;
                
                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Remove active class from all tabs
                        tabs.forEach(t => t.classList.remove('active'));
                        // Add active class to clicked tab
                        this.classList.add('active');
                        
                        // Hide all tab contents
                        tabContents.forEach(content => {
                            content.style.display = 'none';
                        });
                        
                        // Show the corresponding tab content
                        const tabName = this.getAttribute('data-tab');
                        const activeContent = detailsRow.querySelector(`#tab-${tabName}`);
                        if (activeContent) {
                            activeContent.style.display = 'block';
                        }
                    });
                });
            }
            
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

            // Edit Personnel Modal functionality
            const editModal = document.getElementById('editPersonnelModal');
            const editButtons = document.querySelectorAll('.action-button[title="Edit Personnel"]');
            const editCloseModal = document.getElementById('closeEditModal');
            const editCancelBtn = document.getElementById('cancelEdit');
            const editSubmitBtn = document.getElementById('submitEdit');
            const editForm = document.getElementById('editPersonnelForm');
            
            // Open edit modal when edit button is clicked
            editButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent navigation to the edit page
                    
                    // Extract the personnel ID directly from the data row
                    const row = this.closest('tr');
                    const deleteForm = row.querySelector('form[action^="/personnel/"]');
                    let personnelId;
                    
                    // Get the ID from the delete form action URL if available
                    if (deleteForm) {
                        const deleteUrl = deleteForm.getAttribute('action');
                        personnelId = deleteUrl.split('/').pop();
                    } else {
                        // Fallback: try to get ID from the edit button's href
                        const editUrl = this.getAttribute('href');
                        const urlParts = editUrl.split('/');
                        personnelId = urlParts[urlParts.length - 2]; // Get the ID part from the URL
                    }
                    
                    if (!personnelId) {
                        alert('Error: Could not determine which personnel record to edit.');
                        return;
                    }
                    
                    // Construct the full URL to ensure it's correct
                    const baseUrl = window.location.origin;
                    const editUrl = `${baseUrl}/personnel/${personnelId}/edit`;
                    
                    // Fetch personnel data via AJAX
                    fetch(editUrl, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Ensure that data.personnel exists before accessing its properties
                        if (data && data.personnel) {
                            // Populate form with personnel data
                            editForm.action = `/personnel/${personnelId}`;
                            document.getElementById('edit_firstname').value = data.personnel.firstname || '';
                            document.getElementById('edit_middlename').value = data.personnel.middlename || '';
                            document.getElementById('edit_lastname').value = data.personnel.lastname || '';
                            document.getElementById('edit_rank').value = data.personnel.rank || '';
                            document.getElementById('edit_office').value = data.personnel.office || '';
                            document.getElementById('edit_unit').value = data.personnel.unit || '';
                            document.getElementById('edit_department_subunit').value = data.personnel.department_subunit || '';
                            document.getElementById('edit_email').value = data.personnel.email || '';
                            document.getElementById('edit_contact_number').value = data.personnel.contact_number || '';
                            
                            // Display the current picture if available
                            if (data.personnel.picture) {
                                document.getElementById('current_picture_container').style.display = 'block';
                                document.getElementById('current_picture').src = data.personnel.picture;
                            } else {
                                document.getElementById('current_picture_container').style.display = 'none';
                            }
                            
                            // Display the modal
                            editModal.style.display = 'block';
                        } else {
                            throw new Error('Invalid response format from server');
                        }
                    })
                    .catch(error => {
                        alert('Failed to load personnel data. Please try again.');
                    });
                });
            });
            
            // Close edit modal when X is clicked
            editCloseModal.addEventListener('click', function() {
                editModal.style.display = 'none';
            });
            
            // Close edit modal when Cancel is clicked
            editCancelBtn.addEventListener('click', function() {
                editModal.style.display = 'none';
            });
            
            // Submit edit form when Update is clicked
            editSubmitBtn.addEventListener('click', function() {
                editForm.submit();
            });
            
            // Close modal when clicking outside of it
            window.addEventListener('click', function(event) {
                if (event.target == editModal) {
                    editModal.style.display = 'none';
                }
            });
            
            // Preview image before upload
            window.previewEditImage = function(input) {
                const preview = document.getElementById('edit-picture-preview');
                const file = input.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.style.backgroundImage = `url(${e.target.result})`;
                        preview.querySelector('i').style.display = 'none';
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    preview.style.backgroundImage = 'none';
                    preview.querySelector('i').style.display = 'block';
                }
            }
        });
    </script>
@endsection