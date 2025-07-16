@php
    $logo = Session::get('logo');
    if ($logo == 'default.png') {
        $logo = '/assets/img/' . $logo;
    } else {
        $logo = '/storage/logo/' . $logo;
    }

    $userlogo = Session::get('userlogo');
    if ($userlogo == 'default.png') {
        $userlogo = '/assets/img/' . $userlogo;
    } else {
        $userlogo = '/storage/profil/' . $userlogo;
    }

    $sidebarMenu = [];
    $listMenu = Session::get('menu');
    foreach ($listMenu as $menu) {
        $parent_class = '';
        if (count($menu->child) > 0) {
            $parent_class = 'has-sub';
        }

        $parent_active = false;
        $sidebarChildMenu = [];
        if (count($menu->child) > 0) {
            foreach ($menu->child as $child) {
                $child_class = '';
                if (count($child->subchild) > 0) {
                    $child_class = 'has-sub';
                }

                $child_active = false;
                $sidebarSubChildMenu = [];
                if (count($child->child) > 0) {
                    foreach ($child->child as $subchild) {
                        $is_active = request()->url() === url($subchild->link);
                        if ($is_active) {
                            $child_active = true;
                        }

                        $sidebarSubChildMenu[] = [
                            'title' => $subchild->title,
                            'link' => $subchild->link,
                            'icon' => $subchild->icon,
                            'class' => $is_active ? 'active' : '',
                        ];
                    }
                }

                $is_active = request()->url() === url($child->link);
                if ($child_active) {
                    $is_active = true;
                }

                if ($is_active) {
                    $parent_active = true;
                }

                $sidebarChildMenu[] = [
                    'title' => $child->title,
                    'link' => $child->link,
                    'icon' => $child->icon,
                    'class' => trim($is_active ? $child_class . ' active' : $child_class),
                    'subchild' => $sidebarSubChildMenu,
                ];
            }
        }

        $is_active = request()->url() === url($menu->link);
        if ($parent_active) {
            $is_active = true;
        }

        $sidebarMenu[] = [
            'title' => $menu->title,
            'link' => $menu->link,
            'icon' => $menu->icon,
            'class' => trim($is_active ? $parent_class . ' active' : $parent_class),
            'child' => $sidebarChildMenu,
        ];
    }
@endphp

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <br>
        <div style="position: relative; padding: 0px; text-align: center;">
            <button
                class="sidebar-hide btn btn-outline-primary btn-sm rounded-circle position-absolute top-0 end-0 m-2 d-xl-none"
                title="Tutup Menu">
                <i class="bi bi-x-lg"></i>
            </button>
            <a href="/pengaturan" style="text-decoration: none; color: inherit;">
                <div style="width: 80px; height: 80px; margin: 0 auto;">
                    <img class="previewLogo" src="{{ $logo }}" alt="User Avatar"
                        style="width: 110%; height: 110%; border-radius: 50%; object-fit: cover; border: 3px solid #b8b8b8;">
                </div><br>
                <div class="d-flex flex-column">
                    <div class="text-break">
                        <b style="font-size: 18px;">{{ Session::get('nama_usaha') }}</b>
                    </div>
                    <div class="text-break" style="font-size: 14px;">
                        {{ Session::get('describe') }}
                    </div>
                </div>
                <hr>
            </a>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @foreach ($sidebarMenu as $menu)
                    <li class="sidebar-item {{ $menu['class'] }}">
                        <a href="{{ $menu['link'] }}" class='sidebar-link'>
                            <i class="{{ $menu['icon'] }}"></i>
                            <span>{{ $menu['title'] }}</span>
                        </a>

                        @if (count($menu['child']) > 0)
                            <ul class="submenu">
                                @foreach ($menu['child'] as $child)
                                    <li class="submenu-item {{ $child['class'] }}">
                                        <a href="{{ $child['link'] }}" class="submenu-link">
                                            {{ $child['title'] }}
                                        </a>

                                        @if (count($child['subchild']) > 0)
                                            <ul class="submenu submenu-level-2">
                                                @foreach ($child['subchild'] as $subchild)
                                                    <li class="submenu-item {{ $subchild['class'] }}">
                                                        <a href="{{ $subchild['link'] }}" class="submenu-link">
                                                            {{ $subchild['title'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
