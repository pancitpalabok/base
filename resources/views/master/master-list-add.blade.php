@php
    $master_type = Crypt::encryptString("master_type");
    $master_name = Crypt::encryptString("master_name");
@endphp

<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#mod-master-list-add">
    <i class="fas fa-file-medical"></i> Add Master
</button>

  <!-- Modal -->
<div class="modal fade master-list-add" id="mod-master-list-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-file-medical"></i> Add Master</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="master-list-add">
                @csrf
                <label for="">Master Type  </label> <small class='float-right text-danger  mt-2' >* required</small>
                <select name="{{$master_type}}" class="form-control master_type"></select>
                <label for="">Name </label> <small class='float-right text-danger  mt-2' >* required</small>
                <input type="text" name="{{$master_name}}" class="form-control" aria-describedby="emailHelp" placeholder="Enter master name">
            </form>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</a>
            <a type="button" class="btn btn-sm btn-primary btn-master-list-add">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>
    $('.btn-master-list-add').click(function (e) {
        e.preventDefault();

        var frm = $('#master-list-add')

        let btn = $(this)
        btn.html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        `)
        btn.addClass('disabled')

        let fail = false


        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("Add Master Failed","Please fill all fields to continue","error")
                fail = true
                btn.html("Confirm")
                btn.removeClass('disabled')
                return
            }
        });

        if(fail) return

        $.post("{!! route('master.list.add') !!}", frm.serialize(),
            function (data, textStatus, jqXHR) {
                swal(data.h,data.m,data.s)
                if(data.s == 'success') {
                    $('.master-list-add').modal('hide')
                    frm.trigger("reset");
                    master_list_data()
                    master_type_data()
                }
                btn.html("Confirm")
                btn.removeClass('disabled')
            }
        ).fail(function(){
            swal("Error has occurred!","Please contact your system administrator for assistance regarding this error","error")
            btn.html("Confirm")
            btn.removeClass('disabled')
        })
    });
</script>
