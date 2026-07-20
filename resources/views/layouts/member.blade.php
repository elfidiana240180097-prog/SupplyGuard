<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>SupplyGuard Member</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>

    body{
        background:
        linear-gradient(
            135deg,
            #eef4fb 0%,
            #f8fafc 100%
        );
        min-height:100vh;
        font-family:'Segoe UI',sans-serif;
    }

    .card{
        border:none !important;
        border-radius:20px !important;
        background:rgba(255,255,255,.92);
        backdrop-filter:blur(12px);
        box-shadow:
        0 10px 30px rgba(0,0,0,.06);
    }

    .card:hover{
        transform:translateY(-2px);
        transition:.3s;
    }

    main{
        padding:30px !important;
    }

    .page-title{
        font-weight:700;
        color:#1e293b;
    }

    </style>

    @stack('styles')

</head>

<body>

@include('partials.navbar')

<div class="container-fluid">

    <div class="row g-0">

        @include('partials.member-sidebar')

        <main class="col-md-10 py-4 px-4">

            @yield('content')

        </main>

    </div>

</div>

@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@stack('scripts')

<script>

function updateClock(){

    const now = new Date();

    const clock =
    document.getElementById('clock');

    const date =
    document.getElementById('date');

    if(clock){
        clock.innerHTML =
        now.toLocaleTimeString();
    }

    if(date){
        date.innerHTML =
        now.toDateString();
    }

}

setInterval(updateClock,1000);

updateClock();

</script>

</body>
</html>