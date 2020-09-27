
{{-- USERS --}}
<a  class='btn btn-sm text-info {{ $data->udisabled }}'
    title='User List'
    onclick="users_list_data({{ $data->user_type}})">
        <i class='fas fa-user'></i> {{ $data->user_type_count  }}
</a>

{{-- ACESS --}}
<a  class='btn btn-sm text-warning '
    title='User Type Access'
    onClick="user_type_access($(this))">
        <i class='fas fa-users-cog'></i>
</a>

{{-- EDIT --}}
<a  class='btn btn-sm text-success {{ $data->disabled }}'
    onClick="user_type_edit($(this))"
    title='Edit User Type'>
        <i class='fas fa-edit'></i>
</a>

{{-- DELETE --}}
<a  class='btn btn-sm text-danger {{ $data->disabled }}'
    onClick="user_type_delete($(this))"
    title='Delete User Type'>
        <i class='fas fa-trash'></i>
</a>






