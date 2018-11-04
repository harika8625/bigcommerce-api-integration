<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Customers;
use App\Models\Orders;

class CustomerDetailsController extends BaseController
{
    public $customersObj;
    public $ordersObj;

    function __construct(Customers $customersObj, Orders $ordersObj)
    {
        $this->customersObj = $customersObj;
        $this->ordersObj = $ordersObj;
    }

    /**
     * Renders customer details view
     *
     * @return view
     */
    public function show($customerId)
    {
        $customerData = $this->getCustomerDetailsGrid($customerId);

        return view('details', [
            'customer' => compact('customerData')
        ]);
    }

    /**
     * Get customer order history and lifetime value
     *
     * @param int $customerId
     * @return array Array of customer orders
     */
    public function getCustomerDetailsGrid($customerId)
    {
        $customerData = array();

        //Get customer details by id
        $customerDetails = $this->customersObj->getCustomer($customerId);

        if (!empty($customerDetails)) {
            //Prepare data for view
            $customerData['first_name'] = $customerDetails->first_name;

            //Gets all customer orders
            $customerOrders = $this->ordersObj->getOrders($customerId, config('settings.pagination.items_per_page'));

            if (!empty($customerOrders)) {
                $customerData['lifeTimeValue'] = array_sum(array_column($customerOrders, 'total_inc_tax'));
                $customerData['orders'] = $customerOrders;
            }
        }
        return $customerData;
    }
}
