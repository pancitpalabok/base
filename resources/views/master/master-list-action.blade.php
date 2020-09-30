

@if (in_array(7,session()->get('user_access')))
    <a class="btn btn-sm text-success"><i class="fas fa-edit"></i></a>
@endif


@if (in_array(9,session()->get('user_access')))
    <a class="btn btn-sm text-danger" onclick="master_list_delete({{ $data->master_id }})"><i class="fas fa-trash"></i></a>
@endif
