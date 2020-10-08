<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light navbar-white">
<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
    <a onclick="load_page('{{ route('profile.index') }}')" class="nav-link">Profile</a>
    </li>
    {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
    </li> --}}
</ul>

<!-- SEARCH FORM -->
{{-- <form id='search_username' class="form-inline ml-3">
    @csrf
    <div class="input-group input-group-sm">
    <input class="form-control search_username form-control-navbar" name="user_id" type="search" placeholder="Search Username" aria-label="Search">
    <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
        <i class="fas fa-search"></i>
        </button>
    </div>
    </div>
</form> --}}

<!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item ">
        <a class="nav-link" href="{{ route('login.logout') }}">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
