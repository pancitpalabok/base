<div class="card ">
    <div class="card-header bg-lightblue">
        <h3 class="card-title">User List</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="users_list_data()"><i class="fas fa-redo"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body users-content" style="display: block;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width=50px colspan=1>#</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="data-users-list"></tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <x-users
            method="list-add"
        ></x-users>
        <x-users
            method="list-edit"
        ></x-users>
        <x-users
            method="list-access"
        ></x-users>
    </div>
</div>
<script>
    $(function(){
        users_list_data()
    })

    function users_list_data(user_type = 0)
    {
        var tbl = $('.data-users-list')
        var rcount = 0;
        var output = "";


        $.ajax({
            type: "get",
            url: "{!! route('users.list') !!}",
            data : { user_type : user_type},
            success: function (response) {
                tbl.html('')
                $.each(response, function (krow,vrow) {
                    rcount+=1
                    var data = "";
                    $.each(vrow, function (kcol, vcol) {
                        data    += ` data-`+kcol+`="`+vcol+`"`;
                    });

                    let lock = 'lock'
                    let is_logged = '';
                    let locked = 'Lock'
                    let lock_icon = "<i class='fas fa-user text-green'></i> ";
                    let disabled = 'disabled'
                    let color = ''
                    if(vrow.user_locked == 1) {
                        lock = 'unlock'
                        locked = 'Unlock'
                        lock_icon = "<i class='fas fa-user-slash text-red'></i>";
                        color = 'primary'
                        disabled = ''
                    }

                    if(vrow.user_logged == 1) {
                        is_logged = 'disabled'
                    }

                    tbl.append(`
                        <tr `+data+`>
                            <td>`+rcount+`.</td>
                            <td>`+lock_icon+` `+vrow.user_email+`</td>
                            <td>`+vrow.user_type_name+`</td>
                            <td>
                                <x-users
                                    method='list-action'
                                    validator='`+is_logged+`'
                                    :data="[
                                        'user_id'           =>'`+vrow.user_id+`',
                                        'is_locked'         =>'`+vrow.user_locked+`',
                                        'user_locked'       =>'`+lock+`',
                                        'disabled'          =>'`+disabled+`',
                                        'color'             =>'`+color+`',
                                        'title'             =>'`+locked+`',
                                    ]"
                                />
                            </td>
                    `)
                })
            }
        });
    }

    function users_list_lock(id,locked)
    {
        let url ="{!! route('users.list.unlock') !!}"
        let text ="Unlock User, are you sure you want to unlock this user?"

        if(!locked) {
            url = "{!! route('users.list.lock') !!}"
            text = "Lock User, are you sure you want to lock this user?"
        }

        swal({
                title: "Are you sure?",
                text: text,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((v) => {
                if (v) {
                    $.ajax({
                        type: "put",
                        url: url,
                        data: { user_id : id, _token : "{!! csrf_token() !!}" },
                        success: function (res) {
                            swal(res.h,res.m,res.s)
                            users_list_data()
                        }
                    });
                }
            }
        );
    }

    function users_list_reset(id)
    {
        swal({
                title: "Are you sure?",
                text: "Reset User, are you sude you want to reset this user's password?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((v) => {
                if (v) {
                    $.ajax({
                        type: "put",
                        url: "{!! route('users.list.reset') !!}",
                        data: { user_id : id, _token : "{!! csrf_token() !!}" },
                        success: function (res) {
                            swal(res.h,res.m,res.s)
                            users_list_data()
                        }
                    });
                }
            }
        );
    }

    function users_list_delete(id)
    {
        swal({
                title: "Are you sure?",
                text: "Delete User, are you sude you want to remove this user?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((v) => {
                if (v) {
                    $.ajax({
                        type: "delete",
                        url: "{!! route('users.list.delete') !!}",
                        data: { user_id : id, _token : "{!! csrf_token() !!}" },
                        success: function (res) {
                            swal(res.h,res.m,res.s)
                            users_list_data()
                            users_type_data()
                        }
                    });
                }
            }
        );
    }

    function users_list_edit(tr)
    {
        let data = tr.parents('tr')
        var modal = $('#mod-user-list-edit')
        modal.modal('show')
        modal.find('.user_type').val(data.data('user_type'))
        modal.find('.user_id').val(data.data('user_id'))
        modal.find('.user_access_ip').val(data.data('user_access_ip'))
        modal.find('.user_email').html(data.data('user_email'))
    }

    function user_list_access(tr)
    {
        let data = tr.parents('tr')
        var modal = $('#mod-users-list-access')
        modal.modal('show')
        modal.find('.user_email').html(data.data('user_email'))
        modal.find('.user_id').val(data.data('user_id'))

        var access = []

        let user_access = data.data('user_access')

        if(user_access) {
            if(!Number.isInteger(user_access)) {
                access = user_access.split(',');
                $.each(access, function (indexInArray, val) {
                    modal.find('input:checkbox[data-id='+val+']').prop('checked',true)
                });
                return
            }
            modal.find('input:checkbox[data-id="'+user_access+'"]').prop('checked',true)
        }

    }

</script>
