

<a title="Unlock/Lock User"  class="btn btn-sm text-{{ $data->color }} " onclick="alert(1)"><i class="fas fa-{{ $data->user_locked}}"></i></a>
<a title="Reset User"   class="btn btn-sm text-indigo  " onclick="alert(1)"><i class="fas fa-sync-alt"></i></a>
<a title="User Access"  class="btn btn-sm text-warning " onclick="alert(1)"><i class="fas fa-user-cog"></i></a>
<a title="Edit User"    class="btn btn-sm text-success " onclick="alert(1)"><i class="fas fa-edit"></i></a>
<a title="Delete User"  class="btn btn-sm text-danger {{ $data->disabled }}" onclick="alert(1)"><i class="fas fa-trash"></i></a>

