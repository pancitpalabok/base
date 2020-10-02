
@if (in_array(21,session()->get('user_access')))
    <a class="btn btn-sm text-info" onclick="master_type_recover({{ $data->master_id }})" title="Recover Master File"><i class="fas fa-recycle"></i></a>

    <a class="btn btn-sm text-danger" onclick="master_type_dump({{ $data->master_id }})" title="Delete Master File Forever"><i class="fas fa-dumpster"></i></a>
@endif
