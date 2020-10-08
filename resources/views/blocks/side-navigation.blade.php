@php
    $user_info = (object) session()->get('user_data');
    $user_access = session()->get('user_access');
@endphp


<aside class="main-sidebar elevation-4 sidebar-light-orange">
    <!-- Brand Logo -->
    <a href="{{ route('startup.index') }}" class="brand-link">
      <img src="{{ url("/adminlte/dist/img/AdminLTELogo.png") }}" alt="AdminLTE Logo" class="brand-image img img-circle elevation-3"
           style="opacity: .8">
    <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ url('images/placeholder.png') }}" class="img-circle elevation-2" style="height:35px;width:35px" alt="User Image">
          </div>
        <div class="info">
          <a href="#" class="d-block">{{ "$user_info->user_firstname $user_info->user_lastname" }}</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @foreach ($navigation as $link)

                @if (!in_array($link->access,$user_access) && $link->type != 'header')
                    @continue
                @endif


                {{-- GENERATE HEADER TYPE --}}
                @if ($link->type == 'header')
                    <li class="nav-header">{{ $link->title }} </li>
                    @continue
                @endif

                {{-- MULTI LEVEL NAVIGATION --}}
                @if ($link->type == 'tree')

                    <li class="nav-item has-treeview">
                        <a class="nav-link">
                            <i class="nav-icon fas fa-{{ $link->icon}}"></i>
                            <p>
                                {{ $link->title }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            @foreach ($link->items as $item)
                                <li class="nav-item">
                                    <a onClick="load_page('{{$item->link}}')" class="nav-link">
                                        <i class="fas fa-{{$item->icon}} nav-icon"></i>
                                        <p>{{$item->title}}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @continue
                @endif

                {{-- DEFAULT NAVIGATION --}}
                <li class="nav-item">
                    <a class="nav-link {{ isset($link->status) ? $link->status : "" }} " onClick="load_page('{{$link->link}}')">
                    <i class="nav-icon fas fa-{{ $link->icon }}"></i>
                        <p>
                        {{ $link->title }}
                        </p>
                    </a>
                </li>
            @endforeach

            <li class="nav-item">
                <a onclick="load_page('{{ route('dashboard.index') }}')" class="nav-link">
                    <i class="nav-icon fas fa-question-circle"></i>
                    <p>
                        Help
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('login.logout') }}" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                        Logout
                    </p>
                </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


