<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <x-template />
</head>
<body>
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
            <a href=""><b>{{ env('APP_COMPANY') }}</b> {{ env('APP_TYPE') }}</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Welcome to {{ env('APP_NAME') }}!</p>
                    <form id='login-form'>
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control user_email" name="user_email" placeholder="Enter your Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control user_password"  name="user_password" placeholder="Enter your Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                            </div>
                            <div class="col-4">
                            <button class="btn btn-sm btn-primary btn-block login-btn text-white">Sign In</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $('.login-btn').click(function (e) {
        e.preventDefault();
        let frm = $('#login-form')

        let btn = $(this)
        btn.html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        `)
        btn.addClass('disabled')

        $.ajax({
            type: "post",
            url: "{!! route('login.login') !!}",
            data: frm.serialize(),
            success: function (response) {
                if(response.s == 'success')
                    return window.location.replace("{!! route('startup.index') !!}")

                swal(response.h,response.m,response.s)
                btn.html("Sign In")
                btn.removeClass('disabled')
            }
        });

    });
</script>
</html>




