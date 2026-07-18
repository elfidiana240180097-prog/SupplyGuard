@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-4">
    Global Weather Monitoring
</h2>

<div class="card shadow-sm mb-4">
    <div class="card-body">

        <select id="countryFilter" class="form-select">

            <option value="">
                🌍 Show All Countries
            </option>

            @foreach($weatherCountries as $item)

                <option value="{{ strtolower($item['country']) }}">
                    {{ $item['country'] }}
                </option>

            @endforeach

        </select>

    </div>
</div>

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">
        Global Weather Risk Map
    </div>

    <div class="card-body">

    <div class="row mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Total Countries</h6>
                <h3>{{ count($weatherCountries) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>High Risk</h6>
                <h3 class="text-danger">
                    {{ collect($weatherCountries)->where('risk','High')->count() }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Medium Risk</h6>
                <h3 class="text-warning">
                    {{ collect($weatherCountries)->where('risk','Medium')->count() }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Low Risk</h6>
                <h3 class="text-success">
                    {{ collect($weatherCountries)->where('risk','Low')->count() }}
                </h3>
            </div>
        </div>
    </div>

</div>

        <div id="weatherMap" style="height:600px;"></div>

    </div>

</div>

<div class="row mt-4">

    @foreach($weatherCountries as $item)

    <div
        class="col-md-3 mb-3 country-card"
        data-country="{{ strtolower($item['country']) }}">

        <div class="card shadow-sm h-100">

            <div class="card-header">

                <strong>
                    {{ $item['country'] }}
                </strong>

            </div>

            <div class="card-body">

                <p>
                    🌡 Temperature:
                    <b>{{ $item['temperature'] }} °C</b>
                </p>

                <p>
                    💨 Wind Speed:
                    <b>{{ $item['wind'] }} km/h</b>
                </p>

                <p>

                    Risk:

                    @if($item['risk'] == 'Normal')

                        <span class="badge bg-success">
                            Normal
                        </span>

                    @elseif($item['risk'] == 'High Wind')

                        <span class="badge bg-warning text-dark">
                            High Wind
                        </span>

                    @else

                        <span class="badge bg-danger">
                            Storm Risk
                        </span>

                    @endif

                </p>

            </div>

        </div>

    </div>

    @endforeach

</div>

@endsection

@push('styles')

<link
href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css"
rel="stylesheet">

<style>

.ts-wrapper{
    width:100%;
}

.ts-control{
    min-height:60px !important;
    font-size:20px !important;
    padding:12px 15px !important;
    border-radius:12px !important;
}

.ts-control input{
    font-size:20px !important;
}

.ts-dropdown{
    font-size:18px !important;
    max-height:400px !important;
}

.ts-dropdown .option{
    padding:15px !important;
}

.ts-dropdown-content{
    max-height:400px !important;
}

</style>

@endpush

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>

const map = L.map('weatherMap').setView([20,0],2);

L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution:'© OpenStreetMap'
    }
).addTo(map);

const countries = @json($weatherCountries);

countries.forEach(country => {

    L.marker([
        country.lat,
        country.lng
    ])
    .addTo(map)
    .bindPopup(`
    <b>${country.country}</b><br>
    🌡 Temperature: ${country.temperature} °C<br>
    💨 Wind: ${country.wind} km/h<br>
    🌧 Rain: ${country.rain} mm<br>
    ⚠ Risk: ${country.risk}
`);

});

new TomSelect("#countryFilter",{

    create:false,

    placeholder:"Select Country",

    maxOptions:null,

    dropdownParent:'body',

    sortField:{
        field:'text',
        direction:'asc'
    }

});

document
.getElementById('countryFilter')
.addEventListener('change', function(){

    let selected = this.value;

    document
    .querySelectorAll('.country-card')
    .forEach(card => {

        if(
            selected === '' ||
            card.dataset.country === selected
        ){
            card.style.display = 'block';
        }else{
            card.style.display = 'none';
        }

    });

});

</script>

@endpush