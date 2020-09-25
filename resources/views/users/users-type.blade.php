<div class="card card-success">
    <div class="card-header bg-lightblue">
        <h3 class="card-title">User Type</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table " >
                <thead>
                    <tr>
                        <th width=50px>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="data-users-type">

                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <x-users
            method="type-add"
        ></x-users>
        <x-users
            method="type-edit"
        ></x-users>
        <x-users
            method="type-access-edit"
        ></x-users>
    </div>
</div>
<script>
    $(function(){
        users_type_data()
    })

    function users_type_data()
    {
        var tbl = $('.data-users-type')
        var rcount = 0;
        var output = "";

        tbl.html("")

        /* Add User*/
        $('.user_type').find('option').remove()

        $.ajax({
            type: "get",
            url: "{!! route('users.type') !!}",
            success: function (response) {
                $.each(response, function (krow,vrow) {
                    rcount+=1
                    var data = "";
                    $.each(vrow, function (kcol, vcol) {
                        data    += ` data-`+kcol+`="`+vcol+`"`;
                    });
                        /* Add User*/
                        $('.user_type').append(new Option(vrow.user_type_name,vrow.user_type))

                    let disabled = ''
                    let udisabled = 'disabled'
                    if(vrow.user_type_count) {
                        disabled = 'disabled'
                        udisabled = ''
                    }


                    tbl.append(`
                        <tr `+data+`>
                            <td  onclick="data_user_list(`+vrow.user_type+`)">`+rcount+`.</td>
                            <td  onclick="data_user_list(`+vrow.user_type+`)">`+vrow.user_type_name+`</td>
                            <td>
                                <x-users method="type-action" :data="[
                                        'user_type'=>'`+vrow.user_type+`',
                                        'user_type_name'=>'`+vrow.user_type_name+`',
                                        'user_type_count'=>'`+vrow.user_type_count+`',
                                        'disabled'=>'`+disabled+`',
                                        'cog_disable'=>'`+vrow.user_type_disable+`',
                                        'udisabled'=>'`+udisabled+`',
                                    ]"
                                />
                            </td>
                    `)
                })
            }
        });
    }

    function user_type_delete(tr)
    {
        var data = tr.parents("tr")
        var user_type = data.data('user_type')
        var user_type_name = data.data('user_type_name')


        swal({
                title: "Are you sure?",
                text: "Once deleted, you cannot recover linked users to this user type, you want to continue removing "+user_type_name+"? ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type : 'delete', url : "{!! route('users.type.delete') !!}", data : { user_type : user_type , _token : "{!! csrf_token() !!}" }
                    }).done(function(res){
                        swal(res.h,res.m,res.s)
                        users_type_data()
                    })
                }
            }
        );
    }


    function user_type_edit(tr)
    {
        var data = tr.parents('tr')
        var modal = $('#mod-user-type-edit')
        modal.modal('show')
        modal.find('.user_type').val(data.data('user_type'))
        modal.find('.user_type_name').val(data.data('user_type_name'))
    }

    function edit_user_access(tr)
    {
        var data = tr.parents('tr')
        var modal = $('#mod-user-type-access-edit')
        modal.modal('show')
        modal.find('input:checkbox').prop('checked',false)
        modal.find('.user_type').val(data.data('user_type'))
        var access = []


        modal.find('.btn-primary').addClass('disabled')
        if(data.data('user_type') != 1)
            modal.find('.btn-primary').removeClass('disabled')


        $.each(data.data(), function (access_key, access_val) {
            if(access_key.includes('access'))
                access[access_key] = access_val
        })


        access = access['user_access'].split(',');
        $.each(access, function (indexInArray, val) {
            modal.find('.'+val).prop('checked',true)

        });




    }

</script>

