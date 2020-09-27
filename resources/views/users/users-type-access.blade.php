<style>
    label.sub {
        font-weight:normal !important;
    }
</style>
<div class="modal fade users-type-access" id="mod-user-type-access" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-users-cog"></i> Edit User Type Access | <span class="user_type_name"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="users-type-access" onsubmit="return false">
                @csrf
                <input type="hidden" name="user_type" class="user_type">
                <table class="table">
                    @foreach($user_access as $access_row=>$access_col)

                        <tr class="bg-light">
                            <td>
                                <div class="col-md-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input {{ $access_col->access_name }}"  data-id="{{ $access_col->access_id }}"   name="type-{{ $access_col->access_name }}" id="type-{{ $access_col->access_name }}" >
                                        <label class="custom-control-label" for="type-{{ $access_col->access_name }}">{{ $access_col->access_title }}</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @if(isset($access_col->sub_access))
                            <tr>
                                <td>
                                    <div class="row">
                                        @foreach($access_col->sub_access as $sub_access)
                                            <div class="col-md-6 pl-5">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input {{ $sub_access->access_name }}"  data-id="{{ $sub_access->access_id }}"  name="type-{{ $sub_access->access_name }}" id="type-{{ $sub_access->access_name }}">
                                                    <label class="sub custom-control-label" for="type-{{ $sub_access->access_name }}">{{ $sub_access->access_title }}</label>
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
            <a type="button" class="btn btn-sm btn-primary btn-users-type-access">Confirm</a>
        </div>
        </div>
    </div>
</div>
<script>


    function user_type_access(tr)
    {
        var data = tr.parents('tr')
        var modal = $('#mod-user-type-access')
        modal.modal('show')
        modal.find('input:checkbox').prop('checked',false)
        modal.find('.user_type').val(data.data('user_type'))
        modal.find('.user_type_name').html(data.data('user_type_name'))
        var access = []


        modal.find('.btn-primary').addClass('disabled')
        if(data.data('user_type') != 1)
            modal.find('.btn-primary').removeClass('disabled')


        let user_access = data.data('user_access')

        if(user_access) {
            if(!Number.isInteger(user_access)) {
                access = user_access.split(',');
                $.each(access, function (indexInArray, val) {
                    modal.find('input:checkbox[data-id='+val+']').prop('checked',true)
                });
                return
            }
            modal.find('input:checkbox[data-id="'+user_access+'"]').prop('checked',true)
        }

    }


    $('.btn-users-type-access').click(function (e) {
        e.preventDefault();

        var frm = $('#users-type-access')

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
            url: "{!! route('users.type.access') !!}",
            data: frm.serialize(),
            success: function (response) {

                swal(response.h,response.m,response.s)

                if(response.s == 'success') {
                    $('#mod-user-type-access').modal('hide')
                    users_type_data()
                }
                btn.html("Confirm")
                btn.removeClass('disabled')
            }
        });

    });
</script>
