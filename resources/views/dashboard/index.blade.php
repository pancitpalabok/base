
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            </div>
            {{--
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
            --}}
        </div>
    </div>
</div>
<section class="content">
    Dashboard Content

    @php
        $user_access = (session()->get('user_access'));

        if(in_array('usertype_add',$user_access))
            echo 1
    @endphp


</section>
