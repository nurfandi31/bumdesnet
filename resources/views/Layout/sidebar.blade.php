@php
    $logo = Session::get('logo');
    if ($logo == 'no_image.png') {
        $logo = '/assets/img/' . $logo;
    } else {
        $logo = '/storage/logo/' . $logo;
    }

    $userlogo = Session::get('userlogo');
    if ($userlogo == 'no_image.png') {
        $userlogo = '/storage/logo/' . $userlogo;
    } else {
        $userlogo = '/storage/profil/' . $userlogo;
    }
@endphp

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative p-2 pb-0 pt-3 pe-2 ps-2">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <!-- Logo + Nama Usaha -->
                <div class="d-flex align-items-center flex-grow-1 me-2" style="min-width: 0;">
                    <!-- Gambar Logo -->
                    <div style="width: 50px; height: 50px; margin-right: 15px; flex-shrink: 0;">
                        <img src="{{ $logo }}" alt="User Avatar"
                            style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid #b8b8b8;">
                    </div>

                    <!-- Nama Usaha -->
                    <div class="text-break" style="line-height: 1.2; font-size: 14px;">
                        Bumdes.NET Maju Jaya<br>Indonesia
                        <!-- atau pakai ini kalau ingin dinamis -->
                        <!-- {{ Session::get('nama_usaha') }} -->
                    </div>
                </div>

                <!-- Sidebar Close Button -->
                <div class="sidebar-toggler x d-xl-none mt-2 mt-md-0">
                    <a href="#" class="sidebar-hide">
                        <i class="bi bi-text-indent-left fs-5"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr class="m-10 mt-2">
        <div style="position: relative; padding: 0px; text-align: center;">
            <a href="/profil" style="text-decoration: none; color: inherit;">
                <div style="width: 80px; height: 80px; margin: 0 auto;">
                    <img src="{{ $userlogo }}" alt="User Avatar"
                        style="width: 110%; height: 110%; border-radius: 50%; object-fit: cover; border: 3px solid #b8b8b8;">
                </div><br>
                <div style="margin-top: 0px; font-size: 16px;">
                    <div class="page-heading">
                        <b>{{ Session::get('nama') }}</b>
                        <hr>
                    </div>
                </div>
            </a>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @foreach (Session::get('menu') as $menu)
                    @php
                        $parent_class = 'sidebar-item';

                        $is_active = request()->url() === url($menu->link);

                        if (count($menu->child) > 0) {
                            $parent_class .= ' has-sub';
                        }
                        if ($is_active) {
                            $parent_class .= ' active';
                        }

                    @endphp

                    <li class="{{ $parent_class }}">
                        <a href="{{ url($menu->link) }}" class='sidebar-link'>
                            <i class="{{ $menu->icon }}"></i>
                            <span>{{ $menu->title }}</span>
                        </a>

                        @if (count($menu->child) > 0)
                            <ul class="submenu">
                                @foreach ($menu->child as $child)
                                    @if ($child->status == 'A')
                                        @php
                                            $child_class = 'submenu-item';
                                            $is_active = request()->url() === url($child->link);
                                            if (count($child->subchild) > 0) {
                                                $child_class .= ' has-sub';
                                            }

                                            if ($is_active) {
                                                $parent_class .= ' active';
                                            }
                                        @endphp
                                        <li class="{{ $child_class }}">
                                            <a href="{{ url($child->link) }}" class="{{ $child->icon }}">
                                                {{ $child->title }}
                                            </a>
                                            @if (count($child->subchild) > 0)
                                                <ul class="submenu submenu-level-2 ">
                                                    @foreach ($child->subchild as $subchild)
                                                        <li class="submenu-item ">
                                                            <a href="{{ url($subchild->link) }}"
                                                                class="{{ $subchild->icon }}">
                                                                {{ $subchild->title }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                <hr>
                <li class="sidebar-item  ">
                    <a href="#" id="logoutButton" class='sidebar-link'>
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
