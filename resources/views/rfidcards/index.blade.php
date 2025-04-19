@extends('layouts.app-dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/rfidcards.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="card fade-in">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h2 class="card-title">RFID Card Management</h2>
                <a href="{{ route('rfidcards.create') }}" class="btn btn-primary">
                    <i class="material-icons left">add</i> Register New Card
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
                    <input type="text" id="cardSearchInput" class="form-control" placeholder="Search cards...">
                </div>
                <div>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="lost">Lost</option>
                        <option value="damaged">Damaged</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="rfid-table" id="rfidCardsTable">
                    <thead>
                        <tr>
                            <th>Card Number</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Issued Date</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cards as $card)
                            <tr class="card-row" data-status="{{ $card->status }}">
                                <td data-label="Card Number">{{ $card->card_number }}</td>
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
                                        <a href="{{ route('personnel.edit', $card->personnel->id) }}" class="text-primary-color hover:underline">
                                            {{ $card->personnel->full_name }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">Not assigned</span>
                                    @endif
                                </td>
                                <td data-label="Issued Date">{{ $card->issued_at ? $card->issued_at->format('M d, Y') : 'N/A' }}</td>
                                <td data-label="Notes">{{ $card->notes ?? 'N/A' }}</td>
                                <td data-label="Actions">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('rfidcards.edit', $card->id) }}" class="btn btn-sm btn-info btn-icon" title="Edit Card">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        
                                        @if(!$card->personnel_id)
                                            <button type="button" class="btn btn-sm btn-success btn-icon assign-card" 
                                                    data-toggle="modal" data-target="#assignCardModal{{ $card->id }}" title="Assign to Personnel">
                                                <i class="material-icons">person_add</i>
                                            </button>
                                            
                                            <!-- Assign Card Modal -->
                                            <div id="assignCardModal{{ $card->id }}" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="rfid-modal">
                                                        <div class="rfid-modal-header">
                                                            <h5 class="rfid-modal-title">Assign Card to Personnel</h5>
                                                            <button type="button" class="rfid-modal-close" data-dismiss="modal" aria-label="Close">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('rfidcards.assign', $card->id) }}" method="POST">
                                                            @csrf
                                                            <div class="rfid-modal-body">
                                                                <div class="form-group">
                                                                    <label for="personnel_id">Select Personnel</label>
                                                                    <select name="personnel_id" id="personnel_id" class="form-select" required>
                                                                        <option value="">-- Select Personnel --</option>
                                                                        @foreach(App\Models\Personnel::orderBy('lastname')->get() as $personnel)
                                                                            <option value="{{ $personnel->id }}">
                                                                                {{ $personnel->full_name }} ({{ $personnel->department_subunit ?? $personnel->office }})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <p class="text-sm text-gray-500">
                                                                        <i class="material-icons" style="font-size: 16px; vertical-align: text-bottom;">info</i>
                                                                        Assigning this card as active will deactivate any other active cards for the selected personnel.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="rfid-modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Assign Card</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <form action="{{ route('rfidcards.unassign', $card->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unassign this card?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning btn-icon" title="Unassign Card">
                                                    <i class="material-icons">person_remove</i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('rfidcards.destroy', $card->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this card?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Delete Card">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border px-4 py-2 text-center">No RFID cards found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $cards->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any modals
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
        
        // Search functionality
        const searchInput = document.getElementById('cardSearchInput');
        const cardRows = document.querySelectorAll('.card-row');
        const statusFilter = document.getElementById('statusFilter');
        
        const filterCards = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            
            cardRows.forEach(row => {
                const cardNumber = row.querySelector('td:first-child').textContent.toLowerCase();
                const cardStatus = row.dataset.status.toLowerCase();
                const assignedTo = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
                // Match search term against card number or assigned personnel
                const matchesSearch = cardNumber.includes(searchTerm) || assignedTo.includes(searchTerm);
                
                // Match status filter
                const matchesStatus = statusValue === '' || cardStatus === statusValue;
                
                // Show/hide row based on both filters
                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        };
        
        searchInput.addEventListener('input', filterCards);
        statusFilter.addEventListener('change', filterCards);
    });
</script>
@endsection