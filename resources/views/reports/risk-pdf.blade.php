<!DOCTYPE html>
<html>
<head>
    <title>Risk Report</title>

    <style>

        body{
            font-family: sans-serif;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        th,td{
            border:1px solid #000;
            padding:8px;
        }

        th{
            background:#eee;
        }

    </style>
</head>
<body>

<h2>SupplyGuard Risk Report</h2>

<p>
Generated:
{{ now() }}
</p>

<table>

    <thead>

        <tr>

            <th>No</th>
            <th>Country</th>
            <th>Population</th>
            <th>Region</th>

        </tr>

    </thead>

    <tbody>

        @foreach($countries as $index => $country)

        <tr>

            <td>{{ $index + 1 }}</td>

            <td>{{ $country->country_name }}</td>

            <td>{{ number_format($country->population) }}</td>

            <td>{{ $country->region }}</td>

        </tr>

        @endforeach

    </tbody>

</table>

</body>
</html>