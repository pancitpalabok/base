
@php
    $user_id = Crypt::encryptString("user_id");
    $user_lastname = Crypt::encryptString("user_lastname");
    $user_firstname = Crypt::encryptString("user_firstname");
    $user_middlename = Crypt::encryptString("user_middlename");
    $user_contact = Crypt::encryptString("user_contact");
    $user_address = Crypt::encryptString("user_address");
    $user_type = Crypt::encryptString("user_type");
    $user_access_ip = Crypt::encryptString("user_access_ip");
@endphp
<div class="modal fade users-list-edit" id="mod-user-list-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-lightblue">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-edit"></i> Edit User | <span class="user_email"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="users-list-edit" onsubmit="return false">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="{{$user_id}}">
                        <label for="">User Type  </label> <small class='float-right text-danger  mt-2' >* required</small>
                        <select name="{{$user_type}}" class="form-control user-type"></select>
                        <label for="">IP Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                            </div>
                            <input type="text" class="form-control" name="{{$user_access_ip}}" placeholder="192.168.0.1" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Last Name  </label> <small class='float-right text-danger  mt-2' >* required</small>
                        <input type="text" name="{{ $user_lastname }}" class=" form-control" aria-describedby="emailHelp" placeholder="Enter last name here">
                        <label for="">First Name  </label> <small class='float-right text-danger  mt-2' >* required</small>
                        <input type="text" name="{{ $user_firstname }}" class=" form-control" aria-describedby="emailHelp" placeholder="Enter first name here">
                        <label for="">Middle Name </label>
                        <input type="text" name="{{ $user_middlename }}" class=" form-control" aria-describedby="emailHelp" placeholder="Enter middle name here">
                        <label for="">Contact Number </label> <small class='float-right text-danger  mt-2' >* required</small>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="email" name="{{ $user_contact }}" class=" form-control" placeholder="Enter contact number here">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="">Address</label>
                        <textarea placeholder="Enter address here" name="{{ $user_address }}" rows="3" class="form-control"></textarea>
                    </div>
                </div>
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



    function users_list_edit(tr)
    {
        let data = tr.parents('tr')
        var modal = $('#mod-user-list-edit')
        modal.modal('show')
        modal.find('select[name="{!!$user_type!!}"]').val(data.data('user_type'))
        modal.find('input[name="{!!$user_id!!}"]').val(data.data('user_id'))
        modal.find('input[name="{!!$user_access_ip!!}"]').val(data.data('user_access_ip'))
        modal.find('input[name="{!!$user_lastname!!}"]').val(data.data('user_lastname'))
        modal.find('input[name="{!!$user_firstname!!}"]').val(data.data('user_firstname'))
        modal.find('input[name="{!!$user_middlename!!}"]').val(data.data('user_middlename'))
        modal.find('input[name="{!!$user_contact!!}"]').val(data.data('user_contact'))
        modal.find('textarea[name="{!!$user_address!!}"]').html(data.data('user_address'))

        modal.find('.user_email').html(data.data('user_email'))
    }

    $('.btn-users-list-edit').click(function (e) {
        e.preventDefault();

        var frm = $('#users-list-edit')

        let fail = false
        $.each(frm.serializeArray(), function (a, b) {
            if(b.name != '{!! $user_access_ip !!}' && b.name != '{!! $user_address !!}' && b.name != "{!! $user_middlename !!}") {
                if(b.value == '') {
                    swal("Edit User Failed","Please fill all fields to continue","error")
                    fail = true
                    return
                }
            }
        });

        if(fail) return

        let btn = $(this)
        btn.html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        `)
        btn.addClass('disabled')

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
                btn.html("Confirm")
                btn.removeClass('disabled')
            }
        }).fail(function(){
            swal("Error has occurred!","Please contact your system administrator for assistance regarding this error","error")
            btn.html("Confirm")
            btn.removeClass('disabled')
        });

    });
</script>
