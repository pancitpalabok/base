<div class="card">
    <div class="card-header bg-lightblue">
        <h3 class="card-title">Master Type</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body" style="display: block;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width=50px colspan=1>#</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="master-type-data"></tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        @if (in_array(6,session()->get('user_access')))
            <x-master method="type-add"></x-master>
        @endif

        @if (in_array(8,session()->get('user_access')))
            <x-master method="type-edit"></x-master>
        @endif
    </div>
</div>

<script>


    $(function(){
        master_type_data()
    })


    function master_type_data()
    {
        let list = $('.master-type-data')


        $('.master_type').find('option').remove()

        $.ajax({
            type : 'get', url : "{!! route('master.type.data')  !!}"
        }).done(function(res){
            let list_c = 0;
            list.html(``)
            $.each(res, function (key, val) {
                list_c+=1;
                let data = '';
                $.each(val, function (dkey, dval) {
                    data += ` data-`+dkey+`="`+dval+`"`
                });

                /* Add to Master*/
                $('.master_type').append(new Option(val.master_type_name,val.master_type))

                list.append(`
                    <tr `+data+`>
                        <td onclick="master_list_data(`+val.master_type+`)">`+list_c+`.
                        <td onclick="master_list_data(`+val.master_type+`)">`+val.master_type_name+`
                        <td><x-master method="type-action" />
                    </tr>
                `)
            });
        })
    }


    function master_type_delete(tr)
    {
        var data = tr.parents("tr")
        var master_type = data.data('master_type')
        var master_type_name = data.data('master_type_name')


        swal({
                title: "Are you sure?",
                text: "Once deleted, you cannot recover linked master to this master type, you want to continue removing "+master_type_name+"? ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type : 'delete', url : "{!! route('master.type.delete') !!}", data : { master_type : master_type , _token : "{!! csrf_token() !!}" }
                    }).done(function(res){
                        swal(res.h,res.m,res.s)
                        master_type_data()
                    })
                }
            }
        );
    }
</script>
