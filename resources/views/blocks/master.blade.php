<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ env('APP_NAME') }}</title>
        <x-template  />
    </head>
    <body class="sidebar-mini layout-fixed accent-navy" style="height: auto;">
        <div class="wrapper">
            <x-navigation type="top" />
            <x-navigation
                type="side"
                :navigation="$side"
            />

            <div class="content-wrapper">
                <div class="pace"></div>
            </div>

            <x-footer />
        </div>
    </body>
    <script>

        $(function(){
            load_page()
        })

        function load_page(url = "{!! route('dashboard.index') !!}")
        {
            var content = $('.content-wrapper')
            content.html("")
            $.ajax({
                type : 'get', url : url,
                beforeSend : function(){
                    Pace.restart();
                }
            }).done(function(res){
                if(res.status == -1)
                    return window.location.replace("{!! route('login.index') !!}")
                content.html(res)
            })
        }

        $('.nav-link').click(function(){
            $('.nav-link').removeClass('active')
            $(this).addClass('active')
        })
    </script>
</html>
