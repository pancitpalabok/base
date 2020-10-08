@php

    $user_type_name = Crypt::encryptString("user_type_name");
@endphp

<!-- Button trigger modal -->
<button type="button" class="btn btn-tool text-primary" data-toggle="modal" data-target="#mod-user-type-add">
    <i class="fas fa-user-shield"></i> Add
</button>

  <!-- Modal -->
<div class="modal fade users-type-add" id="mod-user-type-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-plus"></i> Add User Type</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="users-type-add" onsubmit="return false">
                @csrf
                <label for="">User Type</label>
                <input type="text" name="{{$user_type_name}}" class="form-control" placeholder="Enter user type here..">
            </form>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</a>
            <a type="button" class="btn btn-sm btn-primary btn-users-type-add">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>
    $('.btn-users-type-add').click(function (e) {
        e.preventDefault();

        var frm = $('#users-type-add')

        let btn = $(this)
        btn.html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        `)
        btn.addClass('disabled')

        let fail = false

        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("Add User Failed","Please enter user type name","error")
                fail = true
                btn.html("Confirm")
                btn.removeClass('disabled')
                return;
            }
        })

        if(fail) return

        $.post("{!! route('users.type.add') !!}", frm.serialize(),
            function (data, textStatus, jqXHR) {
                swal(data.h,data.m,data.s)
                if(data.s == 'success') {
                    $('.users-type-add').modal('hide')
                    frm.trigger("reset");
                    users_type_data()
                }
                btn.html("Confirm")
                btn.removeClass('disabled')
            }
        )

    });
</script>
