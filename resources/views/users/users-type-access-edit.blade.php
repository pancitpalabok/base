<style>
    label.sub {
        font-weight:normal !important;
    }
</style>
<div class="modal fade users-type-access-edit" id="mod-user-type-access-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                <input type="hidden" name="user_type" class="user_type">
                <table class="table">
                    @foreach($access_setup as $access_row=>$access_col)

                        @php $access_col = (object) $access_col; @endphp

                            <tr class="bg-light">
                                <td>
                                    <div class="col-md-6">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input {{ $access_col->access }} "   name="{{ $access_col->access }}" id="{{ $access_col->access }}">
                                            <label class="custom-control-label" for="{{ $access_col->access }}">{{ $access_col->title }}</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @if(count($access_col->sub_access) > 0)
                                <tr>
                                    <td>
                                        <div class="row">
                                            @foreach($access_col->sub_access as $sub_access)

                                                @php $sub_access = (object) $sub_access @endphp

                                                <div class="col-md-6 pl-5">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input {{ $sub_access->access }} "   name="{{ $sub_access->access }}" id="{{ $sub_access->access }}">
                                                        <label class="sub custom-control-label" for="{{ $sub_access->access }}">{{ $sub_access->title }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                    @endforeach
                </table>
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

        let btn = $(this)
        btn.html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        `)
        btn.addClass('disabled')

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
                btn.html("Confirm")
                btn.removeClass('disabled')
            }
        });

    });
</script>
