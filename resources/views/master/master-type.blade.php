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
    </div>
</div>

<script>


    $(function(){
        master_type_data()
    })


    function master_type_data()
    {
        let list = $('.master-type-data')

        list.html(``)

        $('.master_type').find('option').remove()

        $.ajax({
            type : 'get', url : "{!! route('master.type.data')  !!}"
        }).done(function(res){
            let list_c = 0;
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
</script>
