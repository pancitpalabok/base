
<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#mod-master-type-add">
    <i class="fas fa-folder-plus"></i> Add Master Type
</button>

<div class="modal fade master-type-add" id="mod-master-type-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-folder-plus"></i> Add Master Type</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="master-type-add" onsubmit="return false">
                @csrf
                <label for="">Master Type</label>
                <input type="text" name="master_type_name" class="form-control master_type_name" placeholder="Enter master type here..">
            </form>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</a>
            <a type="button" class="btn btn-sm btn-primary btn-master-type-add">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>
    $('.btn-master-type-add').click(function (e) {
        e.preventDefault();

        var frm = $('#master-type-add')

        let btn = $(this)
        btn.html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        `)
        btn.addClass('disabled')

        let fail = false

        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("Add Master Type Failed","Please enter master type name","error")
                fail = true
                btn.html("Confirm")
                btn.removeClass('disabled')
                return;
            }
        })

        if(fail) return


        $.post("{!! route('master.type.add') !!}", frm.serialize(),
            function (data, textStatus, jqXHR) {
                swal(data.h,data.m,data.s)
                if(data.s == 'success') {
                    $('.master-type-add').modal('hide')
                    frm.trigger("reset");
                    master_type_data()
                }
                btn.html("Confirm")
                btn.removeClass('disabled')
            }
        )

    });
</script>
