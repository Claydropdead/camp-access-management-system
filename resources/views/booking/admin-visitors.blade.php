@extends('layouts.app-dashboard')
@section('content')
<div class="container">
    <h2 class="mb-4">Visitor Management</h2>
    <div class="card">
        <div class="card-content">
            <table class="striped responsive-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>ID Type</th>
                        <th>Purpose</th>
                        <th>Visit Date</th>
                        <th>Visit Time</th>
                        <th>Contact Person</th>
                        <th>Office</th>
                        <th>Group</th>
                        <th>Vehicles</th>
                        <th>Status</th>
                        <th>Registered At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($registrations as $reg)
                    <tr>
                        <td>{{ $reg->name }}</td>
                        <td>{{ $reg->email }}</td>
                        <td>{{ $reg->contact_number }}</td>
                        <td>{{ $reg->id_type }}</td>
                        <td>{{ $reg->purpose }}</td>
                        <td>{{ $reg->visit_date }}</td>
                        <td>{{ $reg->visit_time }}</td>
                        <td>{{ $reg->contact_person }}</td>
                        <td>{{ $reg->office }}</td>
                        <td>
                            @if($reg->is_group)
                                <strong>Yes</strong><br>
                                <small>Group Size: {{ $reg->group_size }}</small>
                                @if($reg->additionalVisitors->count())
                                    <ul style="margin:0; padding-left:1em;">
                                    @foreach($reg->additionalVisitors as $visitor)
                                        <li>{{ $visitor->name }} ({{ $visitor->contact_number }})</li>
                                    @endforeach
                                    </ul>
                                @endif
                            @else
                                No
                            @endif
                        </td>
                        <td>
                            @if($reg->has_vehicle && $reg->vehicles->count())
                                <ul style="margin:0; padding-left:1em;">
                                @foreach($reg->vehicles as $vehicle)
                                    <li>{{ $vehicle->type }} - {{ $vehicle->plate_number }} ({{ $vehicle->color }}, {{ $vehicle->model }})</li>
                                @endforeach
                                </ul>
                            @else
                                None
                            @endif
                        </td>
                        <td>{{ ucfirst($reg->status) }}</td>
                        <td>{{ $reg->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($reg->status === 'pending')
                            <form action="{{ route('admin.visitors.action', $reg->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn green btn-small" onclick="return confirm('Approve this registration?')">Approve</button>
                            </form>
                            <form action="{{ route('admin.visitors.action', $reg->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="btn red btn-small" onclick="return confirm('Reject this registration?')">Reject</button>
                            </form>
                            @else
                                <span class="grey-text">No actions</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="14" class="center-align">No visitor registrations found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
