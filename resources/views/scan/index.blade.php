<head>
    <title>Fraude Scan Starten</title>
    <style>
        .fraudulent {
            background-color: #ffcccc;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<h1>Fraud Scan</h1>
<form method="POST" action="{{ route('scan.run') }}">
    @csrf
    <button type="submit">Start New Scan</button>
</form>

<p><a href="{{ route('scan.list') }}">View all scans</a></p>

@if ($errors->any())
    <div style="color: red; margin-top: 20px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (isset($customers) && count($customers) > 0)
    <h2>Scan Results</h2>

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
        @foreach ($customers as $customer)
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
@endif
