<div class="card ">
    <div class="card-header bg-lightblue">
        <h3 class="card-title">User List</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="data_user_list()"><i class="fas fa-redo"></i></button>
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
    </div>
</div>
<script>
    $(function(){
        data_user_list()
    })

    function data_user_list(user_type = 0)
    {
        var tbl = $('.data-users-list')
        var rcount = 0;
        var output = "";


        $.ajax({
            type: "get",
            url: "{!! route('users.list') !!}",
            data : { user_type : user_type},
            beforeSend : function(){
                tbl.html('')
            },
            success: function (response) {
                $.each(response, function (krow,vrow) {
                    rcount+=1
                    var data = "";
                    $.each(vrow, function (kcol, vcol) {
                        data    += ` data-`+kcol+`="`+vcol+`"`;
                    });

                    let lock = 'lock'
                    let lock_icon = "<i class='fas fa-user text-green'></i> ";
                    let disabled = 'disabled'
                    let color = ''
                    if(vrow.user_locked == 1) {
                        lock = 'unlock'
                        lock_icon = "<i class='fas fa-user-slash text-red'></i>";
                        color = 'primary'
                        disabled = ''
                    }

                    // if(vrow.user_img == null)
                    //     console.log(1)

                    tbl.append(`
                        <tr `+data+`>
                            <td>`+rcount+`.</td>
                            <td>`+lock_icon+` `+vrow.user_email+`</td>
                            <td>`+vrow.user_type_name+`</td>
                            <td>
                                <x-users method='list-action' :data="[
                                    'user_id'           =>'`+vrow.user_id+`',
                                    'user_locked'       =>'`+lock+`',
                                    'disabled'          =>'`+disabled+`',
                                    'color'          =>'`+color+`',
                                ]"
                                />
                            </td>
                    `)
                })
            }
        });
    }


</script>
