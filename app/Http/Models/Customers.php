<?php
/**
 * Created by PhpStorm.
 * User: Harika PC
 * Date: 11/3/2018
 * Time: 5:51 PM
 */

namespace App\Http\Models;
use Bigcommerce\Api\Client;


class Customers
{
    public static function getCustomerOrders($id, $limit ){
        $allOrders = array();
        //Get customer orders by passing in filter parameters
        //Calling this API recursively until all the order records are returned
        $pageCounter = 1;
        do{
            $filter = array('customer_id' => $id, 'is_deleted' => 'false','limit' => $limit, 'page' => $pageCounter, 'sort' => 'date_created:desc');
            $customerOrders = Client::getOrders($filter);

            if (!empty($customerOrders)) {
                $recordsCount = count($customerOrders);
            } else {
                $recordsCount = 0;
            }

            if(!empty($customerOrders)) {
                $allOrders = array_merge($allOrders, $customerOrders);
            }
            ++$pageCounter;
        }while(!empty($customer_orders) && $recordsCount == $limit);
        return $allOrders;
    }
}