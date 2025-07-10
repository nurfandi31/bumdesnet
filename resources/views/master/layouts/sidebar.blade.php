@php
    $path = request()->path();
@endphp

<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item {{ $path == '/' ? 'active' : '' }} ">
            <a href="/" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item {{ str_contains($path, 'tenant') ? 'active' : '' }} has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-stack"></i>
                <span>Tenant</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item {{ str_contains($path, 'tenant/create') ? 'active' : '' }} ">
                    <a href="/tenant/create" class="submenu-link">
                        Tambah Lokasi
                    </a>
                </li>
                <li class="submenu-item {{ $path == 'tenant' ? 'active' : '' }} ">
                    <a href="/tenant" class="submenu-link">
                        Daftar Lokasi
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
