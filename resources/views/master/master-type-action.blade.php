
@if (in_array(8,session()->get('user_access')))
    <a class="btn btn-sm text-success" onclick="master_type_edit($(this))" title="Edit Master Type"><i class="fas fa-edit"></i></a>
@endif


@if (in_array(10,session()->get('user_access')))
    <a class="btn btn-sm text-danger" onclick="master_type_delete($(this))" title="Delete Master Type"><i class="fas fa-trash"></i></a>
@endif



