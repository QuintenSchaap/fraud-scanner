<h1>Customer List</h1>
<ul>
    @foreach ($customers as $customer)
        <li>{{ $customer['firstName'] }} - {{ $customer['email'] }}</li>
    @endforeach
</ul>
