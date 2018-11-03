<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Bigcommerce\Api\Client;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Http\Models\Customers;

class CustomersController extends BaseController
{
    public function index()
    {
        //Get total number of customers using customers count API
        //This variable is used to render customers pagination
        $numOfCustomers = Client::getCustomersCount();

        //Get current page form url
        $currentPageNum = Paginator::resolveCurrentPage();

        $customerRecords = $customerDetails = array();

        //Get specified number of customers from List Customers API by passing filter parameters
        $filter = array('page' => $currentPageNum, 'limit' => config('settings.pagination.items_per_page'));
        $customersList = Client::getCustomers($filter);

        if(!empty($customersList)) {
            foreach ($customersList as $eachCustomer) {
                $customerDetails['id'] = $eachCustomer->id;
                $customerDetails['first_name'] = $eachCustomer->first_name;
                $customerDetails['last_name'] = $eachCustomer->last_name;

                //Gets all customer orders
                $customerOrders = Customers::getCustomerOrders($eachCustomer->id, config('settings.pagination.items_per_page'));

                if (!empty($customerOrders)) {
                    $customerDetails['num_of_orders'] = count($customerOrders);
                } else {
                    $customerDetails['num_of_orders'] = 0;
                }
                array_push($customerRecords, $customerDetails);
            }
        }

        //create LengthAwarePaginator by passing all the parameters
        $customersData = new Paginator($customerRecords, $numOfCustomers, config('settings.pagination.items_per_page'), $currentPageNum,
            ['path' => Paginator::resolveCurrentPath()]);

        //return data to customers view
        return view('customers',compact('customersData'));
    }
}
