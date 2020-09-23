<!-- Button trigger modal -->

  <!-- Modal -->
<div class="modal fade users-list-edit" id="mod-user-list-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-edit"></i> Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="users-list-edit" onsubmit="return false">
                @csrf
                <input type="hidden" name="user_id" class="user_id">
                <select name="user_type" class="form-control user_type"></select>
            </form>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</a>
            <a type="button" class="btn btn-sm btn-primary btn-users-list-edit">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>
    $('.btn-users-list-edit').click(function (e) {
        e.preventDefault();

        var frm = $('#users-list-edit')

        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("Edit User Failed","Please fill all fields to continue","error")
                return
            }
        });

        $.ajax({
            type: "put",
            url: "{!! route('users.list.edit') !!}",
            data: frm.serialize(),
            success: function (response) {

                swal(response.h,response.m,response.s)

                if(response.s == 'success') {
                    $('#mod-user-list-edit').modal('hide')
                    users_type_data()
                    users_list_data()
                }
            }
        });

    });
</script>