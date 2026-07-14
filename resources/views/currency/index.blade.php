@extends('layouts.master')

@section('content')

<h2 class="mb-4">
    Currency Dashboard
</h2>

<table class="table table-bordered">

    <tr>
        <th>Currency</th>
        <th>Rate</th>
    </tr>

    @foreach($rates as $code => $rate)

    <tr>

        <td>{{ $code }}</td>

        <td>{{ $rate }}</td>

    </tr>

    @endforeach

</table>

@endsection