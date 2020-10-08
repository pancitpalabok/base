@php
    $user_id = Crypt::encryptString("user_id");
@endphp
<style>
    label.sub {
        font-weight:normal !important;
    }
</style>
<div class="modal fade users-list-access" id="mod-users-list-access" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-cog"></i> Edit User Access | <span class="user_email"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="">

            <form id="users-list-access" onsubmit="return false">
                @csrf
                <input type="hidden" name="{{$user_id}}">
                <table class="table">
                    @foreach($user_access as $access_row=>$access_col)

                        <tr class="bg-light">
                            <td>
                                <div class="col-md-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"
                                            class="custom-control-input {{ $access_col->access_name }}"
                                            data-id="{{ $access_col->access_id }}"
                                            name="{{ Crypt::encryptString('list-'.$access_col->access_name) }}"
                                            id="list-{{ $access_col->access_name }}" >
                                        <label class="custom-control-label" for="list-{{ $access_col->access_name }}">{{ $access_col->access_title }}</label>
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
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ $sub_access->access_name }}"
                                                        data-id="{{ $sub_access->access_id }}"
                                                        name="{{ Crypt::encryptString('list-'.$sub_access->access_name) }}"
                                                        id="list-{{ $sub_access->access_name }}" >
                                                    <label class="sub custom-control-label" for="list-{{ $sub_access->access_name }}">{{ $sub_access->access_title }}</label>
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
            <a type="button" class="btn btn-sm btn-primary btn-users-list-access">Confirm</a>
        </div>
        </div>
    </div>
</div>
<script>


    function user_list_access(tr)
        {
            let data = tr.parents('tr')
            var modal = $('#mod-users-list-access')
            modal.modal('show')
            modal.find('input:checkbox').prop('checked',false)
            modal.find('.user_email').html(data.data('user_email'))
            modal.find('input[name={!!$user_id!!}]').val(data.data('user_id'))

            var access = []

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


    $('.btn-users-list-access').click(function (e) {
        e.preventDefault();

        var frm = $('#users-list-access')

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
            url: "{!! route('users.list.access') !!}",
            data: frm.serialize(),
            success: function (response) {

                swal(response.h,response.m,response.s)

                if(response.s == 'success') {
                    $('#mod-user-list-access').modal('hide')
                    users_list_data()
                }
                btn.html("Confirm")
                btn.removeClass('disabled')
            }
        }).fail(function(){
            swal("Error has occurred!","Please contact your system administrator for assistance regarding this error","error")
            btn.html("Confirm")
            btn.removeClass('disabled')
        })

    });
</script>
