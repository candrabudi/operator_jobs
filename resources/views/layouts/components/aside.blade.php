<aside class="left-sidebar with-vertical">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="index.html" class="text-nowrap logo-img">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/48/Insignia_of_the_Indonesian_National_Armed_Forces.svg/1200px-Insignia_of_the_Indonesian_National_Armed_Forces.svg.png"
                    class="dark-logo" alt="Logo-Dark" width="40" />
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/48/Insignia_of_the_Indonesian_National_Armed_Forces.svg/1200px-Insignia_of_the_Indonesian_National_Armed_Forces.svg.png"
                    class="light-logo" alt="Logo-light" width="40" />
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>

            @if (Auth::user()->role == 'superadmin')
                @include('layouts.components.role.superadmin_menu')
            @else
                @include('layouts.components.role.operator_menu')
            @endif
        </nav>
    </div>
</aside>
