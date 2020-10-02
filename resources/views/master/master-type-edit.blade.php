
<div class="modal fade master-type-edit" id="mod-master-type-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-master-edit"></i> Edit Master Type </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="master-type-edit" onsubmit="return false">
                @csrf
                <input type="hidden" name="master_type" class="master_type">
                <label for="">Master Type</label>
                <input type="text" name="master_type_name" id="" class="form-control master_type_name" placeholder="Enter master type">
            </form>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</a>
            <a type="button" class="btn btn-sm btn-primary btn-master-type-edit">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>



    function master_type_edit(tr)
    {
        let data = tr.parents('tr')
        var modal = $('#mod-master-type-edit')
        modal.modal('show')
        $('.master_type').val(data.data('master_type'))
        $('.master_type_name').val(data.data('master_type_name'))
    }

    $('.btn-master-type-edit').click(function (e) {
        e.preventDefault();

        var frm = $('#master-type-edit')

        let fail = false
        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("Edit Master Type Failed","Please enter master type to continue","error")
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
            url: "{!! route('master.type.edit') !!}",
            data: frm.serialize(),
            success: function (response) {

                swal(response.h,response.m,response.s)

                if(response.s == 'success') {
                    $('#mod-master-type-edit').modal('hide')
                    master_type_data()
                }
                btn.html("Confirm")
                btn.removeClass('disabled')
            }
        });

    });
</script>
