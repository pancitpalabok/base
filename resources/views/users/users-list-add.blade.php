<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#mod-user-list-add">
    <i class="fas fa-user-plus"></i> Add User
</button>

  <!-- Modal -->
<div class="modal fade users-list-add" id="mod-user-list-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-plus"></i> Add User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="users-list-add">
                @csrf
                <label for="">User Type</label>
                <select name="user_type" class="form-control user_type"></select>
                <label for="">Email</label>
                <input type="email" name="user_email" class="form-control user_email" aria-describedby="emailHelp" placeholder="Enter email">
                <label for="">Password</label>
                <input type="password" name="user_password" class="form-control user_password" placeholder="Enter Password">
                <label for="">Confirm Password</label>
                <input type="password" name="user_cpassword" class="form-control user_cpassword" placeholder="Re-enter Password">
            </form>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</a>
            <a type="button" class="btn btn-sm btn-primary btn-users-list-add">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>
    $('.btn-users-list-add').click(function (e) {
        e.preventDefault();

        var frm = $('#users-list-add')

        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("Add User Failed","Please fill all fields to continue","error")
                return
            }
        });

        $.post("{!! route('users.list.add') !!}", frm.serialize(),
            function (data, textStatus, jqXHR) {
                swal(data.h,data.m,data.s)
                if(data.s == 'success') {
                    $('.users-list-add').modal('hide')
                    frm.trigger("reset");
                    data_user_type()
                    data_user_list()
                }
            }
        );
    });
</script>
