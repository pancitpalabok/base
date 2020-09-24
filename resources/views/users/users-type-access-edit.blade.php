<!-- Button trigger modal -->

  <!-- Modal -->
<div class="modal fade users-type-access-edit" id="mod-user-type-access-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-plus"></i> Edit User Type Access</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="users-type-access-edit" onsubmit="return false">
                @csrf
            </form>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</a>
            <a type="button" class="btn btn-sm btn-primary btn-users-type-access-edit">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>
    $('.btn-users-type-access-edit').click(function (e) {
        e.preventDefault();

        var frm = $('#users-type-access-edit')

        $.each(frm.serializeArray(), function (a, b) {
            if(b.value == '') {
                swal("User Access Failed","Please fill all fields to continue","error")
                return
            }
        });

        $.ajax({
            type: "put",
            url: "{!! route('users.type.access.edit') !!}",
            data: frm.serialize(),
            success: function (response) {

                swal(response.h,response.m,response.s)

                if(response.s == 'success') {
                    $('#mod-user-type-access-edit').modal('hide')
                    users_type_data()
                }
            }
        });

    });
</script>
