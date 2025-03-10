<ul id="sidebarnav">
    <li class="nav-small-cap" style="color: white;">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Home</span>
    </li>
    <li class="sidebar-item" >
        <a class="sidebar-link" href="{{ route('system.dashboard.index') }}" aria-expanded="false" style="color: white;">
            <span>
                <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
        </a>
    </li>
   
    <li class="nav-small-cap" style="color: white;">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Request</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.request.posts.index') }}" aria-expanded="false" style="color: white;">
            <span>
                <i class="ti ti-send"></i>
            </span>
            <span class="hide-menu">Posting</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.request.boosts.index') }}" aria-expanded="false" style="color: white;">
            <span>
                <i class="ti ti-rocket"></i>
            </span>
            <span class="hide-menu">Boosting</span>
        </a>
    </li>
    
    <li class="nav-small-cap" style="color: white;">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Setting</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link has-arrow"
           href="javascript:void(0)"
           aria-expanded="false" style="color: white;">
            <span>
                <i class="ti ti-settings"></i>
            </span>
            <span class="hide-menu">Social Media</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level">
            <li class="sidebar-item">
                <a href="{{ route('system.topics.index') }}" class="sidebar-link" style="color: white;">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Topics</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('system.social_media_platforms.index') }}" class="sidebar-link" style="color: white;">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Platforms</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('system.engagements.index') }}" class="sidebar-link" style="color: white;">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Engagements</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('system.social_media_accounts.index') }}" class="sidebar-link" style="color: white;">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Accounts</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('system.users.index') }}" aria-expanded="false" style="color: white;">
            <span>
                <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Users</span>
        </a>
    </li>
</ul>