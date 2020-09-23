<!-- Button trigger modal -->

  <!-- Modal -->
<div class="modal fade users-type-edit" id="mod-user-type-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-plus"></i> Edit User Type</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="users-type-edit" onsubmit="return false">
                @csrf
                <input type="hidden" class="user_type" name="user_type" value=0>
                <label for="">User Type</label>
                <input type="text" name="user_type_name" class="form-control user_type_name" placeholder="Enter user type here..">
            </form>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</a>
            <a type="button" class="btn btn-sm btn-primary btn-users-type-edit">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>
    $('.btn-users-type-edit').click(function (e) {
        e.preventDefault();

        var frm = $('#users-type-edit')

        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("Edit User Failed","Please fill all fields to continue","error")
                return
            }
        });

        $.ajax({
            type: "put",
            url: "{!! route('users.type.edit') !!}",
            data: frm.serialize(),
            success: function (response) {

                swal(response.h,response.m,response.s)

                if(response.s == 'success') {
                    $('#mod-user-type-edit').modal('hide')
                    users_type_data()
                }
            }
        });

    });
</script>