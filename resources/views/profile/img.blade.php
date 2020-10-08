
<section class="content-header">
    <h1> Test
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-9">
            <div class="box box-info">
                <div class="box-body">
                    <div class=" form-group">
                        <div align="center">
                            <div class="btn-upload pointer hovereffect">
                                <div class='loaders text-center'>
                                    <img src=">"  />
                                </div>
                                <img class="img img-responsive profile-photo" src="{{ url('images/placeholder.png') }} " style = "max-width:300px" >
                                <div class="overlay">
                                    <p class="icon-links">
                                        <a>
                                            <span class="fa fa-camera fa-lg dot"></span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <form id="frm_profile_upload" enctype="multipart/form-data" method="post" action="">
                            <input class="input-file" type="file" name="filess" style="display:none;"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
-->
<script>
    $(function(){
		$('.loaders').hide();
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    })

    $(".btn-upload").click(function(){
        $(".input-file").click();
    });
    $(".input-file").change(function(){
        var e = $(this).parents("form")
        e.submit()
    });

    $('#frm_profile_upload').submit(function(dis){
        dis.preventDefault()
        var e= $(this)
         $.ajax({
            type    : e.attr("method"),
            url     : e.attr("action"),
            data    : new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function(){
                $('.profile-photo').hide()
				$('.loaders').show();
            }
        }).done(function(res){
            var d = new Date()
            $('.loaders').hide();
            $('.profile-photo').attr('src',res)
            $('.img-circle-photo').attr('src',res)
            $('.header-user-image').attr('src',res)
            $('.profile-photo').show()
        })
    })



    $("#frm_user_profile").submit(function(dis){

        dis.preventDefault()
        var e = $(this)
        var alertmsg = e.find('.alert-msg')
        e.find('.btn-submit').prop('disabled',true)
		$.ajax({
            type    : e.attr('method'),
            url     : e.attr('action'),
            data    : e.serialize()
        }).done(function(res){
           if(res.status == 1){
                alertmsg.html("<div class='alert alert-success'><i class='fa fa-check'></i> "+res.message+"</div>").hide().fadeIn(300);
                e.find('.btn-submit').prop('disabled', false);
           } else {
                alertmsg.html("<div class='alert alert-danger'><i class='fa fa-times'></i> "+res.message+"</div>").hide().fadeIn(300);
                e.find('.btn-submit').prop('disabled', false);
           }
        }).fail(function(){
            alertmsg.html("<div class='alert alert-danger'><i class='fa fa-times'></i> Could not connect to server</div>").hide().fadeIn(300);
            e.find('.btn-submit').prop('disabled', false);
        })
    })

</script>
