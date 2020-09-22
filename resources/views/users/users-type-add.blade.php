<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#mod-user-type-add">
    <i class="fas fa-user-shield"></i> Add User Type
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
            <form id="users-type-add">
                @csrf
                <label for="">User Type</label>
                <input type="email" name="user_type_name" class="form-control user_type_name" placeholder="Enter user type here..">
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

        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("Add User Failed","Please fill all fields to continue","error")
                return
            }
        });

        $.post("{!! route('users.type.add') !!}", frm.serialize(),
            function (data, textStatus, jqXHR) {
                swal(data.h,data.m,data.s)
                if(data.s == 'success') {
                    $('.users-type-add').modal('hide')
                    frm.trigger("reset");
                    data_user_type()
                }
            }
        );
    });
</script>
