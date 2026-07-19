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

<div class="row mt-4" id="countriesContainer">

    @foreach($weatherCountries as $item)

    <div
        class="col-md-3 mb-3 country-card"
        data-country="{{ strtolower($item['country']) }}">

        <div class="card shadow-sm h-100">

            <div class="card-header">
                <strong>{{ $item['country'] }}</strong>
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
                    🌧 Rain:
                    <b>{{ $item['rain'] }} mm</b>
                </p>

                <p>

                    @if($item['risk'] == 'Low')

                        <span class="badge bg-success">
                            Low Risk
                        </span>

                    @elseif($item['risk'] == 'Medium')

                        <span class="badge bg-warning text-dark">
                            Medium Risk
                        </span>

                    @else

                        <span class="badge bg-danger">
                            High Risk
                        </span>

                    @endif

                </p>

            </div>

        </div>

    </div>

    @endforeach

</div>

<div class="d-flex justify-content-center mt-4">

    <button class="btn btn-outline-primary me-2" id="prevPage">
        Previous
    </button>

    <span class="align-self-center" id="pageInfo"></span>

    <button class="btn btn-outline-primary ms-2" id="nextPage">
        Next
    </button>

</div>

@endsection

@push('styles')

<link
href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css"
rel="stylesheet">

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
    maxOptions:null
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

const cards = document.querySelectorAll('.country-card');

let currentPage = 1;
const cardsPerPage = 12;

function showPage(page){

    const start = (page - 1) * cardsPerPage;
    const end = start + cardsPerPage;

    cards.forEach((card,index)=>{

        card.style.display =
            index >= start && index < end
            ? 'block'
            : 'none';

    });

    document.getElementById('pageInfo').innerText =
        `Page ${page} of ${Math.ceil(cards.length/cardsPerPage)}`;
}

document.getElementById('nextPage')
.addEventListener('click',()=>{

    if(
        currentPage <
        Math.ceil(cards.length/cardsPerPage)
    ){
        currentPage++;
        showPage(currentPage);
    }

});

document.getElementById('prevPage')
.addEventListener('click',()=>{

    if(currentPage > 1){
        currentPage--;
        showPage(currentPage);
    }

});

showPage(1);

</script>

@endpush