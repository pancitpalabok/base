<div class="card">
    <div class="card-header bg-lightblue">
        <h3 class="card-title">Master List</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="master_list_data()"><i class="fas fa-redo"></i></button>
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

                    tbl.append(`
                        <tr `+data+`>
                            <td>`+tblc+`
                            <td>`+rval.master_name+`
                            <td>`+rval.master_type_name+`
                            <td>
                                <x-master
                                    method="list-action"
                                    :data="[
                                        'master_id'=>'`+rval.master_id+`'
                                    ]"
                                />
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
                text: "Aare you sude you want to remove this master?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((v) => {
                if (v) {
                    $.ajax({
                        type: "delete",
                        url: "{!! route('master.list.delete') !!}",
                        data: { master_id : id, _token : "{!! csrf_token() !!}" },
                        success: function (res) {
                            swal(res.h,res.m,res.s)
                            master_list_data()
                        }
                    });
                }
            }
        );
    }

</script>
