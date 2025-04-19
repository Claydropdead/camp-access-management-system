<div class="drawer" id="app-drawer">
    <div class="drawer-header">
        <div class="drawer-logo">
            <i class="material-icons logo-icon">security</i>
            <h2 class="drawer-title">Camp Access Management <span class="centered-system">System</span></h2>
        </div>
    </div>
    <div class="drawer-user">
        <div class="user-avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=random" alt="User Avatar" width="64" height="64">
        </div>
        <p><strong>Welcome,</strong></p>
        <p>{{ Auth::user()->name ?? 'User' }}</p>
    </div>
    <nav class="drawer-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}">
            <i class="material-icons">dashboard</i>
            <span>Dashboard</span>
        </a>
        
        <!-- Visitor Management Module -->
        <div class="nav-item-with-submenu{{ request()->is('admin/visitors*') || request()->is('visitor*') ? ' active' : '' }}">
            <div class="nav-item-header">
                <i class="material-icons">supervisor_account</i>
                <span>Visitor Management</span>
                <i class="material-icons submenu-toggle">expand_more</i>
            </div>
            <div class="submenu">
                <a href="{{ route('admin.dashboard') }}#visitor-registration" class="nav-link submenu-item{{ request()->is('visitor/registration*') ? ' active' : '' }}">
                    <i class="material-icons">how_to_reg</i>
                    <span>Registration</span>
                </a>
                <a href="{{ route('admin.visitors') }}" class="nav-link submenu-item{{ request()->routeIs('admin.visitors') ? ' active' : '' }}">
                    <i class="material-icons">thumb_up_alt</i>
                    <span>Visitor Approvals</span>
                    @php
                        $pendingCount = \App\Models\VisitorRegistration::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="notification-badge">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.dashboard') }}#visitor-logs" class="nav-link submenu-item{{ request()->is('visitor/logs*') ? ' active' : '' }}">
                    <i class="material-icons">history</i>
                    <span>Visitor Logs</span>
                </a>
            </div>
        </div>
        
        <!-- Personnel Management Module -->
        <div class="nav-item-with-submenu{{ request()->is('admin/personnel*') || request()->is('personnel*') ? ' active' : '' }}">
            <div class="nav-item-header">
                <i class="material-icons">people</i>
                <span>Personnel Management</span>
                <i class="material-icons submenu-toggle">expand_more</i>
            </div>
            <div class="submenu">
                <a href="{{ route('personnel.create') }}" class="nav-link submenu-item{{ request()->is('personnel/create*') ? ' active' : '' }}">
                    <i class="material-icons">person_add</i>
                    <span>Add Personnel</span>
                </a>
            </div>
        </div>
        
        <!-- RFID Card Management Module -->
        <div class="nav-item-with-submenu{{ request()->is('rfidcards*') ? ' active' : '' }}">
            <div class="nav-item-header">
                <i class="material-icons">credit_card</i>
                <span>RFID Cards</span>
                <i class="material-icons submenu-toggle">expand_more</i>
            </div>
            <div class="submenu">
                <a href="{{ route('rfidcards.create') }}" class="nav-link submenu-item{{ request()->is('rfidcards/create*') ? ' active' : '' }}">
                    <i class="material-icons">add_card</i>
                    <span>Register Card</span>
                </a>
                <a href="{{ route('rfidcards.index') }}" class="nav-link submenu-item{{ request()->is('rfidcards') ? ' active' : '' }}">
                    <i class="material-icons">credit_card</i>
                    <span>Manage Cards</span>
                </a>
            </div>
        </div>
        
        <a href="#reports" class="nav-link">
            <i class="material-icons">assessment</i>
            <span>Reports</span>
        </a>
        <a href="#calendar" class="nav-link">
            <i class="material-icons">calendar_today</i>
            <span>Calendar</span>
        </a>
        <div class="nav-divider"></div>
        <a href="{{ route('profile.edit') }}" class="nav-link{{ request()->routeIs('profile.edit') ? ' active' : '' }}">
            <i class="material-icons">person</i>
            <span>Profile</span>
        </a>
        <a href="#settings" class="nav-link">
            <i class="material-icons">settings</i>
            <span>Settings</span>
        </a>
        <div class="nav-divider"></div>
        <form method="POST" action="{{ route('logout') }}" class="nav-link" style="cursor: pointer;">
            @csrf
            <button type="submit" style="background: none; border: none; display: flex; align-items: center; width: 100%; text-align: left; cursor: pointer; padding: 0; color: inherit;">
                <i class="material-icons">exit_to_app</i>
                <span>Logout</span>
            </button>
        </form>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all submenu headers
        const submenuHeaders = document.querySelectorAll('.nav-item-header');
        
        // Add click event listener to each header
        submenuHeaders.forEach(header => {
            header.addEventListener('click', function() {
                // Toggle active class on parent element
                const parent = this.parentElement;
                parent.classList.toggle('active');
            });
        });
        
        // Auto-open submenu if any of its children is active
        const activeSubmenuItems = document.querySelectorAll('.submenu-item.active');
        activeSubmenuItems.forEach(item => {
            const parent = item.closest('.nav-item-with-submenu');
            if (parent) {
                parent.classList.add('active');
            }
        });
    });
</script>
