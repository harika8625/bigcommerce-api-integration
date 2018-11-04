@extends('layouts.app')

@if(isset($customer['customerData']) && !empty($customer['customerData']))

    @section('title', $customer['customerData']['first_name'] . "'s Order History")

    @section('content')
        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th># of Products</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($customer['customerData']['orders']) && count($customer['customerData']['orders']))
                @foreach($customer['customerData']['orders'] as $eachOrder)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($eachOrder->date_created)) }}</td>
                        <td>{{$eachOrder->items_total}}</td>
                        <td>${{number_format($eachOrder->total_inc_tax,2)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2">Lifetime Value</td>
                    <td>${{number_format($customer['customerData']['lifeTimeValue'],2)}}</td>
                </tr>
            @else
                <tr>
                    <td>
                        No orders found.
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    @endsection
@else
    @section('title', "Order History")
    @section('content')
        Invalid request
    @endsection
@endif