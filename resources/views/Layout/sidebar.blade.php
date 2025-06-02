@php
    $logo = Session::get('logo');
    if ($logo == 'no_image.png') {
        $logo = '/assets/img/' . $logo;
    } else {
        $logo = '/storage/logo/' . $logo;
    }
@endphp

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative" style="padding: 10px;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div style="font-weight: bold; font-size: 25px;">{{ Session::get('nama_usaha') }}</div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20"
                        height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label" for="toggle-dark"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20"
                        height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m17.75 4.09-2.53 1.94.91 3.06-2.63-1.81-2.63 1.81.91-3.06-2.53-1.94L12.44 4l1.06-3 1.06 3 3.19.09m3.5 6.91-1.64 1.25.59 1.98-1.7-1.17-1.7 1.17.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95 2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14.4-.4.82-.76 1.27-1.08.75-.53 1.93.36 1.85 1.19-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82-2.81 3.14-2.7 7.96.31 10.98 3.02 3.01 7.84 3.12 10.98.31Z">
                        </path>
                    </svg>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        <hr>
        <div style="position: relative; padding: 0px; text-align: center;">
            <a href="/profil" style="text-decoration: none; color: inherit;">
                <div style="width: 80px; height: 80px; margin: 0 auto;">
                    <img src="{{ $logo }}" alt="User Avatar"
                        style="width: 110%; height: 110%; border-radius: 50%; object-fit: cover; border: 3px solid #b8b8b8;">
                </div><br>
                <div style="margin-top: 0px; font-size: 16px;">
                    <div class="page-heading">
                        <b>{{ Session::get('nama') }}</b>
                    </div>
                </div>
            </a>
        </div>

        <hr>
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
