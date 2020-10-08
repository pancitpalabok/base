@php
    $master_id = Crypt::encryptString('master_id');
@endphp
<div class="card">
    <div class="card-header bg-lightblue">
        <h3 class="card-title">Master List</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="master_list_deleted()" title="Deleted List"><i class="fas fa-trash-restore-alt"></i></button>
            <button type="button" class="btn btn-tool" onclick="master_list_data()" title="Reload List"><i class="fas fa-redo"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body" style="display: block;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width=50px colspan=1>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="master-list-data"></tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        @if (in_array(5,session()->get('user_access')))
            <x-master
                method="list-add"
            ></x-master>
        @endif
        @if (in_array(7,session()->get('user_access')))
            <x-master
                method="list-edit"
            ></x-master>
        @endif
    </div>
</div>

<script>
    $(function(){
        master_list_data()
    })



    function master_list_data(master_type = 0)
    {
        var tbl = $('.master-list-data')
        var tblc = 0;

        $.get("{!! route('master.list.data') !!}", { master_type : master_type },
            function (res) {
                tbl.html("")
                $.each(res, function (key, rval) {
                    tblc+=1


                    let data = ""
                    $.each(rval, function (ckey, cval) {
                        data += ` data-`+ckey+`="`+cval+`"`;
                    });

                    let action = `<x-master
                                    method='list-action'
                                    :data="[
                                        'master_id'=>'`+rval.master_id+`',
                                    ]"
                                />`
                    let is_deleted = ""
                    if(rval.master_deleted == 1) {
                        is_deleted = "table-danger"
                        action = `<x-master
                                        method='list-recover'
                                        :data="[
                                            'master_id'=>'`+rval.master_id+`',
                                        ]"
                                    />`

                    }


                    tbl.append(`
                        <tr `+data+` class="`+is_deleted+`">
                            <td>`+tblc+`
                            <td>`+rval.master_name+`
                            <td>`+rval.master_type_name+`
                            <td>`+action+`

                        </tr>
                    `)
                });

            }
        );
    }


    function master_list_delete(id)
    {
        swal({
                title: "Are you sure?",
                text: "Are you sure you want to remove this master file?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((v) => {
                if (v) {
                    $.ajax({
                        type: "delete",
                        url: "{!! route('master.list.delete') !!}",
                        data: { {!!$master_id!!} : id, _token : "{!! csrf_token() !!}" },
                        success: function (res) {
                            swal(res.h,res.m,res.s)
                            master_list_data()
                            master_type_data()
                        }
                    }).fail(function(){
                        swal("Error has occurred!","Please contact your system administrator for assistance regarding this error","error")
                        btn.html("Confirm")
                        btn.removeClass('disabled')
                    })
                }
            }
        );
    }

    function master_type_recover(id)
    {
        swal({
                title: "Are you sure?",
                text: "Are you sure you want to recover this master file?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((v) => {
                if (v) {
                    $.ajax({
                        type: "put",
                        url: "{!! route('master.list.recover') !!}",
                        data: { {!!$master_id!!} : id, _token : "{!! csrf_token() !!}" },
                        success: function (res) {
                            swal(res.h,res.m,res.s)
                            master_list_data()
                        }
                    }).fail(function(){
                        swal("Error has occurred!","Please contact your system administrator for assistance regarding this error","error")
                        btn.html("Confirm")
                        btn.removeClass('disabled')
                    })
                }
            }
        );
    }


    function master_type_dump(id)
    {
        swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this master file forever?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((v) => {
                if (v) {
                    $.ajax({
                        type: "delete",
                        url: "{!! route('master.list.dump') !!}",
                        data: { {!!$master_id!!} : id, _token : "{!! csrf_token() !!}" },
                        success: function (res) {
                            swal(res.h,res.m,res.s)
                            master_list_data()
                            master_type_data()
                        }
                    }).fail(function(){
                        swal("Error has occurred!","Please contact your system administrator for assistance regarding this error","error")
                        btn.html("Confirm")
                        btn.removeClass('disabled')
                    })
                }
            }
        );
    }

    function master_list_deleted()
    {

        var tbl = $('.master-list-data')
        var tblc = 0;

        $.get("{!! route('master.list.deleted') !!}", {},
            function (res) {
                tbl.html("")
                $.each(res, function (key, rval) {
                    tblc+=1

                    let is_deleted = ""
                    let data = ""

                    $.each(rval, function (ckey, cval) {
                        data += ` data-`+ckey+`="`+cval+`"`;
                    });


                    let action = `<x-master
                                    method='list-action'
                                    :data="[
                                        'master_id'=>'`+rval.master_id+`',
                                    ]"
                                />`

                    if(rval.master_deleted == 1) {
                        is_deleted = "table-danger"
                        action = `<x-master
                                        method='list-recover'
                                        :data="[
                                            'master_id'=>'`+rval.master_id+`',
                                        ]"
                                    />`

                    }

                    tbl.append(`
                        <tr `+data+` class="`+is_deleted+`">
                            <td>`+tblc+`
                            <td>`+rval.master_name+`
                            <td>`+rval.master_type_name+`
                            <td>`+action+`

                        </tr>
                    `)
                });

            }
        );
    }

</script>
