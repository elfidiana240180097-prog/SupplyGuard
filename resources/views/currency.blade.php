@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-4">
    💱 Currency
</h2>

<p class="text-muted">
    Currency exchange rates between countries.
</p>

<div class="card shadow-sm">

    <div class="card-header bg-success text-white">

        Exchange Rates

    </div>

    <div class="card-body">

        <table class="table table-striped">

            <thead>

                <tr>

                    <th>Currency</th>

                    <th>Code</th>

                    <th>Rate</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td colspan="3" class="text-center">

                        Exchange rate data will appear here.

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection