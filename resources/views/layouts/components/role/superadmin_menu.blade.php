<ul id="sidebarnav">
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Home</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.dashboard.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
        </a>
    </li>
   
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Request</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.request.posts.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-send"></i>
            </span>
            <span class="hide-menu">Posting</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.request.boosts.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-rocket"></i>
            </span>
            <span class="hide-menu">Boosting</span>
        </a>
    </li>
    
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Setting</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.platforms.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-settings"></i>
            </span>
            <span class="hide-menu">Platform</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.users.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Users</span>
        </a>
    </li>
</ul>