<head>
    <title>Overview of Completed Scans</title>
    <style>
        .fraudulent {
            background-color: #ffcccc;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<h1>Completed Scans</h1>

@foreach ($scans as $scan)
    <h2>Scan on {{ $scan->scanned_at->format('d-m-Y H:i:s') }}</h2>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>IBAN</th>
            <th>IP Address</th>
            <th>Phone Number</th>
            <th>Date of Birth</th>
            <th>Fraudulent</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($scan->customers as $customer)
            <tr class="{{ $customer->is_fraudulent ? 'fraudulent' : '' }}">
                <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                <td>{{ $customer->iban }}</td>
                <td>{{ $customer->ip_address }}</td>
                <td>{{ $customer->phone_number }}</td>
                <td>{{ $customer->date_of_birth->format('d-m-Y') }}</td>
                <td>{{ $customer->is_fraudulent ? 'Yes' : 'No' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('scan.index') }}">⬅ Back to start scan</a>
@endforeach
