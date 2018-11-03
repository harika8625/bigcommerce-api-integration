@extends('layouts.app')
@section('title', 'Customers')

@section('content')
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th># of Orders</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if(count($customersData))
            @foreach($customersData as $eachCustomer)
                <tr>
                    <td>{{$eachCustomer['first_name']}} {{$eachCustomer['last_name']}}</td>
                    <td>{{$eachCustomer['num_of_orders']}}</td>
                    <td>
                        @if($eachCustomer['num_of_orders'])
                            <a href='{!! url("/customers/{$eachCustomer['id']}") !!}'>View</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>
                    No Customers found.
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    {{ $customersData->render() }}
@endsection
