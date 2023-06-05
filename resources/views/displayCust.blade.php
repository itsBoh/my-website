<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>username</th>
            <th>password</th>
            <th>email</th>
            <th>phone</th>
            <th>gender</th>
            <th>address</th>
            <th>status del</th>
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $record)
            <tr>
                <td>{{ $record->CUST_ID }}</td>
                <td>{{ $record->CUST_NAME }}</td>
                <td>{{ $record->cust_username }}</td>
                <td>{{ $record->cust_password }}</td>
                <td>{{ $record->cust_email }}</td>
                <td>{{ $record->cust_phone }}</td>
                <td>{{ $record->cust_address }}</td>
                <td>{{ $record->status_del }}</td>
                <!-- Display more columns as needed -->
            </tr>
        @endforeach
    </tbody>
</table>
