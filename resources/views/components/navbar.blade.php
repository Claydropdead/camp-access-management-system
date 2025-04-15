<header class="app-header">
    <button class="menu-toggle" id="menu-toggle">
        <i class="material-icons">menu</i>
    </button>
    <div style="flex:1"></div>
    @if(request()->route()->getName() == 'dashboard')
    <div class="theme-switch-wrapper" style="margin-left:auto;">
        <span class="material-icons" style="color: white;">wb_sunny</span>
        <label class="theme-switch">
            <input type="checkbox" id="theme-toggle">
            <span class="slider"></span>
        </label>
        <span class="material-icons" style="color: white;">nightlight_round</span>
    </div>
    @endif
</header>
