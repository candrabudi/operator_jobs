<style>
    #sidebarnav .hide-menu,
    #sidebarnav i {
        color: white;
    }
</style>
<ul id="sidebarnav">
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4" style="color: white;"></i>
        <span class="hide-menu" style="color: white;">Home</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.dashboard.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-home" style="color: white;"></i>
            </span>
            <span class="hide-menu" style="color: white;">Dashboard</span>
        </a>
    </li>

    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4" style="color: white;"></i>
        <span class="hide-menu" style="color: white;">Request</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.request.posts.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-send" style="color: white;"></i>
            </span>
            <span class="hide-menu" style="color: white;">Posting</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.request.boosts.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-rocket" style="color: white;"></i>
            </span>
            <span class="hide-menu" style="color: white;">Boosting</span>
        </a>
    </li>
</ul>
