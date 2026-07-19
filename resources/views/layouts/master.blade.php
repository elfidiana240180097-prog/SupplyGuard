<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SupplyGuard</title>

```
<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

<style>

:root{
    --primary:#198754;
    --primary-light:#20c997;
    --dark:#0f172a;
    --card-bg:rgba(255,255,255,.85);
}

body{
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    background:
    radial-gradient(circle at top left,#dff7eb 0%,transparent 30%),
    radial-gradient(circle at top right,#e7f3ff 0%,transparent 30%),
    linear-gradient(
        135deg,
        #f5f9ff 0%,
        #eef8f2 50%,
        #f8fbff 100%
    );
}

/* =======================
   NAVBAR
======================= */

.navbar{
    background:
    linear-gradient(
        135deg,
        #157347,
        #20c997
    ) !important;

    box-shadow:
    0 10px 30px rgba(25,135,84,.25);

    border-bottom:
    1px solid rgba(255,255,255,.2);
}

.navbar::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:50%;

    background:
    linear-gradient(
        rgba(255,255,255,.22),
        transparent
    );

    pointer-events:none;
}

/* =======================
   SIDEBAR
======================= */

.sidebar-panel{
    background:
    rgba(255,255,255,.88);

    backdrop-filter:blur(16px);

    border-right:
    1px solid rgba(255,255,255,.4);

    box-shadow:
    8px 0 30px rgba(0,0,0,.05);
}

/* =======================
   CARD
======================= */

.card{
    position:relative;

    border:none !important;

    border-radius:22px !important;

    overflow:hidden;

    background:
    rgba(255,255,255,.82);

    backdrop-filter:blur(16px);

    box-shadow:
    0 10px 30px rgba(0,0,0,.08);

    transition:.35s ease;
}

.card::before{
    content:'';

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:70px;

    background:
    linear-gradient(
        rgba(255,255,255,.55),
        transparent
    );

    pointer-events:none;
}

.card:hover{
    transform:
    translateY(-5px);

    box-shadow:
    0 20px 40px rgba(0,0,0,.12);
}

/* =======================
   BUTTON
======================= */

.btn-success{
    background:
    linear-gradient(
        135deg,
        #198754,
        #20c997
    ) !important;

    border:none !important;

    box-shadow:
    0 8px 20px rgba(25,135,84,.25);
}

.btn-success:hover{
    transform:translateY(-2px);
}

/* =======================
   MENU
======================= */

.list-group-item{
    border:none !important;

    border-radius:14px !important;

    margin-bottom:7px;

    font-weight:600;

    transition:.25s;
}

.list-group-item:hover{
    background:#e9fff3;

    transform:translateX(5px);
}

.list-group-item.active{
    background:
    linear-gradient(
        135deg,
        #198754,
        #20c997
    ) !important;

    color:white !important;
}

/* =======================
   TITLE
======================= */

h1,h2,h3,h4,h5{
    color:#1e293b;
    font-weight:700;
}

/* =======================
   BADGE
======================= */

.badge{
    border-radius:30px;
    padding:8px 12px;
}

/* =======================
   TABLE
======================= */

.table{
    background:white;
    border-radius:16px;
    overflow:hidden;
}

/* =======================
   FOOTER
======================= */

footer{
    background:
    rgba(255,255,255,.75);

    backdrop-filter:blur(12px);

    border-top:
    1px solid rgba(255,255,255,.4);
}

/* =======================
   SCROLLBAR
======================= */

::-webkit-scrollbar{
    width:10px;
}

::-webkit-scrollbar-thumb{
    background:
    linear-gradient(
        #198754,
        #20c997
    );

    border-radius:20px;
}

</style>

@stack('styles')
```

</head>

<body>

```
@include('partials.navbar')

<div class="container-fluid">

    <div class="row">

        @include('partials.sidebar')

        <main class="col-md-10 ms-sm-auto px-4 py-4">

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
```

</body>
</html>
