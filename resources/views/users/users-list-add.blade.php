
@php
    $user_lastname = Crypt::encryptString("user_lastname");
    $user_firstname = Crypt::encryptString("user_firstname");
    $user_middlename = Crypt::encryptString("user_middlename");
    $user_contact = Crypt::encryptString("user_contact");
    $user_address = Crypt::encryptString("user_address");
    $user_type = Crypt::encryptString("user_type");
    $user_email = Crypt::encryptString("user_email");
    $user_password = Crypt::encryptString("user_password");
    $user_cpassword = Crypt::encryptString("user_cpassword");
    $user_access_ip = Crypt::encryptString("user_access_ip");

@endphp

<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#mod-user-list-add">
    <i class="fas fa-user-plus"></i> Add User
</button>

  <!-- Modal -->
<div class="modal fade users-list-add" id="mod-user-list-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                <div class="row">
                    <div class="col-md-6">
                        <label for="">User Type  </label><small class='float-right text-danger mt-2' >* required</small>
                        <select name="{{$user_type}}" class=" form-control user-type"></select>
                        <label for="">Email </label> <small class='float-right text-danger  mt-2' >* required</small>
                        <input type="email" name="{{ $user_email }}" class=" form-control" aria-describedby="emailHelp" placeholder="Enter email">
                        <label for="">Password </label> <small class='float-right text-danger mt-2' >* required</small>
                        <input type="password" name="{{ $user_password }}" class=" form-control " placeholder="Enter Password">
                        <label for="">Confirm Password  </label> <small class='float-right  text-danger mt-2' >* required</small>
                        <input type="password" name="{{ $user_cpassword }}" class=" form-control" placeholder="Re-enter Password">
                        <label for="">IP Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                            </div>
                            <input type="text" class="form-control" name="{{$user_access_ip}}" placeholder="192.168.0.1" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Last Name </label>  <small class='float-right  text-danger mt-2' >* required</small>
                        <input type="text" name="{{ $user_lastname }}" class=" form-control" aria-describedby="emailHelp" placeholder="Enter last name here">
                        <label for="">First Name </label> <small class='float-right  text-danger mt-2' >* required</small>
                        <input type="text" name="{{ $user_firstname }}" class=" form-control" aria-describedby="emailHelp" placeholder="Enter first name here">
                        <label for="">Middle Name </label>
                        <input type="text" name="{{ $user_middlename }}" class=" form-control" aria-describedby="emailHelp" placeholder="Enter middle name here">
                        <label for="">Contact Number  </label> <small class='float-right  text-danger mt-2' >* required</small>
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
            <a type="button" class="btn btn-sm btn-primary btn-users-list-add">Confirm</a>
        </div>
        </div>
    </div>
</div>

<script>
    $('.btn-users-list-add').click(function (e) {
        e.preventDefault();

        var frm = $('#users-list-add')

        let btn = $(this)
        btn.html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        `)
        btn.addClass('disabled')

        let fail = false


        $.each(frm.serializeArray(), function (a, b) {

            if(b.name != '{!! $user_access_ip !!}' && b.name != "{!! $user_address !!}"  && b.name != "{!! $user_middlename !!}") {
                if(b.value == '') {
                    swal("Add User Failed","Please fill all fields to continue","error")
                    fail = true
                    btn.html("Confirm")
                    btn.removeClass('disabled')
                    return
                }
            }
        });

        if(fail) return


        $.ajax({
            type : 'post',
            url : "{!! route('users.list.add') !!}",
            data : frm.serialize()
        }).done(function(data){
            swal(data.h,data.m,data.s)
            if(data.s == 'success') {
                $('.users-list-add').modal('hide')
                frm.trigger("reset");
                users_type_data()
                users_list_data()
            }
            btn.html("Confirm")
            btn.removeClass('disabled')

        }).fail(function(){
            swal("Error has occurred!","Please contact your system administrator for assistance regarding this error","error")
            btn.html("Confirm")
            btn.removeClass('disabled')
        })
    });
</script>
