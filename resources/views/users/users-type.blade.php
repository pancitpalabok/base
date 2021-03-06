@php
    $user_type = Crypt::encryptString("user_type");

    /** obfuscated data names */
    $o_user_type_name = base64url_encode('user_type_name');
    $o_user_type = base64url_encode('user_type');
    $o_user_type_count = base64url_encode('user_type_count');
    $o_user_type_disable = base64url_encode('user_type_disable');

@endphp

<div class="card card-outline card-orange">
    <div class="card-header ">
        <h3 class="card-title">User Type</h3>
        <div class="card-tools">

            @if (in_array(14,session()->get('user_access')))
                <x-users
                    method="type-edit"
                ></x-users>
            @endif

            @if (in_array(18,session()->get('user_access')))
                <x-users
                    method="type-access"
                ></x-users>
            @endif

            @if (in_array(12,session()->get('user_access')))
                <x-users
                    method="type-add"
                ></x-users>
            @endif
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


        /* Add User*/
        $('.user-type').find('option').remove()

        $.ajax({
            type: "get",
            url: "{!! route('users.type') !!}",
            success: function (response) {
                tbl.html("")

                $.each(response, function (krow,vrow) {
                    rcount+=1
                    var data = "";
                    $.each(vrow, function (kcol, vcol) {
                        data    += ` data-`+kcol+`="`+vcol+`"`;
                    });
                        /* Add User*/
                        $('.user-type').append(new Option(vrow.user_type_name,vrow.user_type))

                    let disabled = ''
                    let udisabled = 'disabled'
                    if(vrow.{!! $o_user_type_count !!}) {
                        disabled = 'disabled'
                        udisabled = ''
                    }

                    a = vrow.{!! $o_user_type !!}
                    b = vrow.{!! $o_user_type_name !!}
                    c = vrow.{!! $o_user_type_count !!}
                    d = vrow.{!! $o_user_type_disable !!}
                    tbl.append(`
                        <tr `+data+`>
                            <td  onclick="users_list_data(`+vrow.user_type+`)">`+rcount+`.</td>
                            <td  onclick="users_list_data(`+vrow.user_type+`)">`+vrow.user_type_name+`</td>
                            <td>
                                <x-users method="type-action" :data="[
                                        'user_type'=>'`+vrow.user_type+`',
                                        'user_type_name'=>'`+vrow.user_type_name+`',
                                        'user_type_count'=>'`+vrow.user_type_count+`',
                                        'disabled'=>'`+disabled+`',
                                        'cog_disable'=>'`+vrow.$o_user_type_disable+`',
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
                        type : 'delete', url : "{!! route('users.type.delete') !!}", data : {  {!! $user_type !!} : user_type , _token : "{!! csrf_token() !!}" }
                    }).done(function(res){
                        swal(res.h,res.m,res.s)
                        users_type_data()
                    })
                }
            }
        );
    }


</script>

