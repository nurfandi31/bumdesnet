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
            </ul>
        </div>
    </div>
</div>
