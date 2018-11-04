<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Customers;
use App\Models\Orders;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class CustomersController extends BaseController
{
    public $customersObj;
    public $ordersObj;

    function __construct(Customers $customersObj, Orders $ordersObj) {
        $this->customersObj = $customersObj;
        $this->ordersObj = $ordersObj;
    }

    /**
     * Renders customers list view
     *
     * @return view
     */
    public function index()
    {
        $customersData = $this->getCustomersGrid();

        //return customers list to customers view
        return view('customers',compact('customersData'));
    }

    /**
     * Get customers list and total orders
     *
     * @return object array of customers and total orders
     */
    public function getCustomersGrid(){

        //This variable is used to render pagination in the customers listing screen
        $numOfCustomers = $this->customersObj->getCustomersCount();

        //Get current page from url
        $currentPageNum = Paginator::resolveCurrentPage();

        //Read items per page setting from the config/settings file
        $itemsPerPage = config('settings.pagination.items_per_page');

        $customerRecords = $customerDetails = array();

        //Get customers pre page
        $customersPerPage = $this->customersObj->getCustomers($currentPageNum,$itemsPerPage);

        //Iterate through each customer to get all the customer orders
        if(!empty($customersPerPage)) {
            foreach ($customersPerPage as $eachCustomer) {
                //Prepare data for view
                $customerDetails['id'] = $eachCustomer->id;
                $customerDetails['first_name'] = $eachCustomer->first_name;
                $customerDetails['last_name'] = $eachCustomer->last_name;

                //Get count of customer orders
                $customerOrdersCount = $this->ordersObj->getOrdersCount($eachCustomer->id);

                $customerDetails['num_of_orders'] = $customerOrdersCount;
                array_push($customerRecords, $customerDetails);
            }
        }

        //create LengthAwarePaginator by passing pagination parameters
        $customersData = new Paginator($customerRecords, $numOfCustomers, $itemsPerPage, $currentPageNum,
            ['path' => Paginator::resolveCurrentPath()]);

        return $customersData;
    }
}
