

<link rel="icon" href="{{ env('APP_ICON_LOGO') }}">

<!-- Plugins -->

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ url("/adminlte/plugins/fontawesome-free/css/all.min.css") }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- icheck bootstrap -->
<link rel="stylesheet" href="{{ url("/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ url("/adminlte/dist/css/adminlte.min.css") }}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{ url("/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}">

<!-- pace-progress -->
<link rel="stylesheet" href="{{ url("/adminlte/plugins/pace-progress/themes/black/pace-theme-flat-top.css") }}">

<!-- JQVMap -->
<link rel="stylesheet" href="{{ url("/adminlte/plugins/jqvmap/jqvmap.min.css") }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ url("/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ url("/adminlte/plugins/daterangepicker/daterangepicker.css") }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ url("/adminlte/plugins/summernote/summernote-bs4.css") }}">





<!-- jQuery -->
<script src="{{ url("/adminlte/plugins/jquery/jquery.min.js") }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url("/adminlte/plugins/jquery-ui/jquery-ui.min.js") }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url("/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<!-- ChartJS -->
<script src="{{ url("/adminlte/plugins/chart.js/Chart.min.js") }}"></script>
<!-- Sparkline -->
<script src="{{ url("/adminlte/plugins/sparklines/sparkline.js") }}"></script>
<!-- JQVMap -->
<script src="{{ url("/adminlte/plugins/jqvmap/jquery.vmap.min.js") }}"></script>
<script src="{{ url("/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js") }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url("/adminlte/plugins/jquery-knob/jquery.knob.min.js") }}"></script>
<!-- daterangepicker -->
<script src="{{ url("/adminlte/plugins/moment/moment.min.js") }}"></script>
<script src="{{ url("/adminlte/plugins/daterangepicker/daterangepicker.js") }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ url("/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
<!-- Summernote -->
<script src="{{ url("/adminlte/plugins/summernote/summernote-bs4.min.js") }}"></script>
<!-- overlayScrollbars -->
<script src="{{ url("/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ url("/adminlte/dist/js/adminlte.min.js") }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url("/adminlte/dist/js/demo.js") }}"></script>
<!-- pace-progress -->
<script src="{{ url("/adminlte/plugins/pace-progress/pace.min.js") }}"></script>
<!-- Sweet Alert -->
<script src="{{ url("/swal.js") }}"></script>

<style>

.img {
      opacity: 1;
      display: block;
      width: 200px;
      height: 200px;
      transition: .5s ease;
      backface-visibility: hidden;
      border-radius: 50%;
    }

    .middle {
      transition: .5s ease;
      opacity: 0;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      text-align: center;
    }

    .container:hover .img {
      opacity: 0.3;
    }

    .container:hover .middle {
      opacity: 1;
    }

    .text {
      color: black;
      font-size: 20px;
      position: absolute;
      top: 85%;
      left: 65%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      text-align: center;
    }

    .pointer {
      cursor: pointer;
    }

    .btn-upload {
      width: 200px;
      height: 200px;
    }

    .dot {
      padding-top: 9px;
      height: 50px;
      width: 50px;
      background-color: white;
      border-radius: 50%;

    }

    .position {

      position: absolute;
      top: 40%;
      left: 56%;
    }


    .hovereffect {
        width: 230px;
        height: 200px;

        overflow: hidden;
        position: relative;


    }
    .hovereffect .overlay {
        width: 100%;
        position: absolute;
        overflow: hidden;
        left: 0;
        top: auto;
        bottom: 0;
        padding: 1em;
        height: 4.75em;
        background: #79FAC4;
        color: #3c4a50;
        -webkit-transition: -webkit-transform 0.35s;
        transition: transform 0.35s;
        -webkit-transform: translate3d(0,100%,0);
        transform: translate3d(0,100%,0);
        visibility: hidden;

    }

    .hovereffect img {
       display: block;
      position: relative;
      -webkit-transition: all 0.4s ease-in;
      transition: all 0.4s ease-in;
    }

    .hovereffect:hover img {
      filter: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg"><filter id="filter"><feColorMatrix type="matrix" color-interpolation-filters="sRGB" values="0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0 0 0 1 0" /><feGaussianBlur stdDeviation="3" /></filter></svg>#filter');
      filter: grayscale(1) blur(2px);
      -webkit-filter: grayscale(1) blur(2px);
      -webkit-transform: scale(1);
      -ms-transform: scale(1);
      transform: scale(1);
    }

    .hovereffect p.icon-links a {
        float: right;
        color: #3c4a50;
        font-size: 1.4em;

    }

    .hovereffect:hover p.icon-links a:hover,
    .hovereffect:hover p.icon-links a:focus {
        color: #252d31;
    }

    .hovereffect h2,
    .hovereffect p.icon-links a {
        -webkit-transition: -webkit-transform 0.35s;
        transition: transform 0.35s;
        -webkit-transform: translate3d(0,200%,0);
        transform: translate3d(0,100%,0);
        visibility: visible;
    }

    .hovereffect p.icon-links a span:before {
        display: inline-block;
        padding: 8px 10px;
        speak: none;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }


    .hovereffect:hover .overlay,
    .hovereffect:hover h2,
    .hovereffect:hover p.icon-links a {
        -webkit-transform: translate3d(0,0,0);
        transform: translate3d(0,0,0);
    }

    .hovereffect:hover h2 {
        -webkit-transition-delay: 0.05s;
        transition-delay: 0.05s;
    }


    /**
        this changes focus animation
    */
    .form-control:focus {
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(11, 26, 241, 0.6);
    }
</style>


