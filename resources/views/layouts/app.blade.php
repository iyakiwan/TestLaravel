<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <style>
        .bg-app {
            background-color: #7BD194;
        }
    </style>

    <title>Accounting</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-app">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="font-size: 13px">
        <ul class="navbar-nav mr-auto  form-inline my-2 my-lg-0">
            <li class="nav-item  active">
                <a class="nav-link" href="{{url('')}}"><img
                        src="{{asset('images/logo.png')}}"
                        alt="" style="width: 70px"></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('bulanan')}}">Laporan Bulanan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('arus')}}">Laporan Arus Keluar Masuk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('pemasukan')}}">Data Pemasukan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('pengeluaran')}}">Data Pengeluaran</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('kas')}}">Data Arus Kas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('validasi')}}">Validasi Arus Kas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('status')}}">Status Transaksi</a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <div class="text-right mr-3" style="text-font-size:10x">
                <b>{{Session::get('nama')}} ({{Session::get('email')}})</b>
                <br>
                {{Session::get('role')}}
            </div>
        </div>
        <img
            src="https://media.istockphoto.com/vectors/default-profile-picture-avatar-photo-placeholder-vector-illustration-vector-id1223671392?k=6&m=1223671392&s=612x612&w=0&h=NGxdexflb9EyQchqjQP0m6wYucJBYLfu46KCLNMHZYM="
            class="rounded-circle mr-3" alt="" style="width: 36px">
        <a href="{{url('logout')}}" class="text-dark">
            <i class="fas fa-sign-out-alt" style="font-size: 20px"></i>
        </a>

    </div>
    </div>
</nav>
<div class="pt-4 container">
    @yield('content')
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker" ).datepicker();
    } );
    $( function() {
        $( "#datepicker2" ).datepicker();
    } );
</script>
@stack('script')

<!-- Option 2: jQuery, Popper.js, and Bootstrap JS
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
-->
</body>
</html>
