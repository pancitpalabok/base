@php
    $user_info = (array) session()->get('user_data');
@endphp


<aside class="main-sidebar elevation-4 sidebar-light-navy">
    <!-- Brand Logo -->
    <a href="{{ route('startup.index') }}" class="brand-link">
      <img src="{{ url("/adminlte/dist/img/AdminLTELogo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
    <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">{{ $user_info['user_email'] }}</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">



            @foreach ($navigation as $link)

                {{-- IF ACCESS = 0 THEN DO NOT DISPLAY NAVIGATION --}}
                @if (isset($user_info[$link->access]))
                    @if (!$user_info[$link->access])
                        @continue
                    @endif
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


