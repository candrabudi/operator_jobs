<aside class="left-sidebar with-vertical" style="background: #152040;">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="index.html" class="text-nowrap logo-img">
                <img src="{{ asset('images/logos/tnai.jpg') }}"
                    class="dark-logo" alt="Logo-Dark" width="40" />
                <img src="{{ asset('images/logos/tnai.jpg') }}"
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
