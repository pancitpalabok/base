@php
    $master_id = Crypt::encryptString("master_id");
    $master_type = Crypt::encryptString("master_type");
    $master_name = Crypt::encryptString("master_name");
@endphp

<div class="modal fade master-list-edit" id="mod-master-list-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-master-edit"></i> Edit Master | <span class="master_name"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="master-list-edit" onsubmit="return false">
                @csrf
                <input type="hidden" name="{{$master_id}}">
                <label for="">Master Type </label> <small class='float-right text-danger  mt-2' >* required</small>
                <select name="{{$master_type}}" class="master_type form-control"></select>
                <label for="">Master </label> <small class='float-right text-danger  mt-2' >* required</small>
                <input type="text" name="{{$master_name}}" class="form-control" placeholder="Enter master name">
            </form>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</a>
            <a type="button" class="btn btn-sm btn-primary btn-master-list-edit">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>



    function master_list_edit(tr)
    {
        let data = tr.parents('tr')
        var modal = $('#mod-master-list-edit')
        modal.modal('show')
        $('.master_name').html(data.data('master_name'))
        modal.find('input[name="{!!$master_id!!}"]').val(data.data('master_id'))
        modal.find('input[name="{!!$master_name!!}"]').val(data.data('master_name'))
        modal.find('select[name="{!!$master_type!!}"]').val(data.data('master_type'))
    }

    $('.btn-master-list-edit').click(function (e) {
        e.preventDefault();

        var frm = $('#master-list-edit')

        let fail = false
        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("Edit Master Failed","Please fill all fields to continue","error")
                fail = true
                return
            }
        });

        if(fail) return

        let btn = $(this)
        btn.html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        `)
        btn.addClass('disabled')

        $.ajax({
            type: "put",
            url: "{!! route('master.list.edit') !!}",
            data: frm.serialize(),
            success: function (response) {

                swal(response.h,response.m,response.s)

                if(response.s == 'success') {
                    $('#mod-master-list-edit').modal('hide')
                    master_list_data()
                    master_type_data()
                }
                btn.html("Confirm")
                btn.removeClass('disabled')
            }
        }).fail(function(){
            swal("Error has occurred!","Please contact your system administrator for assistance regarding this error","error")
            btn.html("Confirm")
            btn.removeClass('disabled')
        })

    });
</script>
