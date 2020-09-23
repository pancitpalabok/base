

<a title="{{ $data->title }} User"  
    class="btn btn-sm text-{{ $data->color }} {{ $validator }}" 
    onclick="users_list_lock({{ $data->user_id }},{{ $data->is_locked }})"><i class="fas fa-{{ $data->user_locked}}"></i></a>

<a title="Reset User"   
    class="btn btn-sm text-indigo  {{ $validator }}" 
    onclick="users_list_reset({{ $data->user_id }})"><i class="fas fa-sync-alt"></i></a>

<a title="User Access"  
    class="btn btn-sm text-warning {{ $validator }}" 
    onclick="alert({{ $data->user_id }})"><i class="fas fa-user-cog"></i></a>
<a title="Edit User"    
    class="btn btn-sm text-success {{ $validator }}" 
    onclick="users_list_edit($(this))"><i class="fas fa-edit"></i></a>
<a title="Delete User"  
    class="btn btn-sm text-danger  {{ $validator }} {{ $data->disabled }}" 
    onclick="users_list_delete({{ $data->user_id }})"><i class="fas fa-trash"></i></a>

