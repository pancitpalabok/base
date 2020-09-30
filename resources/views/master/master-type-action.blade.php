
<a class="btn btn-sm text-info"  ><i class="fas fa-eye"></i></a>


@if (in_array(8,session()->get('user_access')))
    <a class="btn btn-sm text-success"><i class="fas fa-edit"></i></a>
@endif


@if (in_array(10,session()->get('user_access')))
    <a class="btn btn-sm text-danger"><i class="fas fa-trash"></i></a>
@endif
