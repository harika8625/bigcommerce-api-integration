<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Bigcommerce\Api\Client;
use App\Http\Models\Customers;

class CustomerDetailsController extends BaseController
{
    public function show($id)
    {
        $customerData = array();
        //Get customer details by id
        $customerDetails = Client::getCustomer($id);

        if (!empty($customerDetails)) {
            $customerData['first_name'] = $customerDetails->first_name;

            //Gets all customer orders
            $customerOrders = Customers::getCustomerOrders($id, config('settings.pagination.items_per_page'));

            if (!empty($customerOrders)) {
                $customerData['lifeTimeValue'] = array_sum(array_column($customerOrders, 'total_inc_tax'));
                $customerData['orders'] = $customerOrders;
            }
        }

        return view('details', [
            'customer' => compact('customerData')
        ]);
    }
}
