<?php
/**
 * Created by PhpStorm.
 * User: Harika PC
 * Date: 11/3/2018
 * Time: 1:54 AM
 */

namespace App\Models;

use Bigcommerce\Api\Client as BigcommerceAPI;

class Orders
{
    public $apiObj;

    function __construct(BigcommerceAPI $apiObj) {
        $this->apiObj = $apiObj;
    }

    /**
     * Get all customer orders
     *
     * @param int $customerId
     * @param int $itemsPerPage
     * @return array Array of customer orders
     */
    public function getOrders($customerId, $itemsPerPage)
    {
        $allOrders = array();
        //Calling this API recursively until all the order records are returned
        $pageCounter = 1;
        do {
            $filter = array('customer_id' => $customerId, 'is_deleted' => 'false', 'limit' => $itemsPerPage, 'page' => $pageCounter, 'sort' => 'date_created:desc');
            $customerOrders = $this->apiObj->getOrders($filter);

            if (!empty($customerOrders)) {
                $recordsCount = count($customerOrders);
            } else {
                $recordsCount = 0;
            }

            if (!empty($customerOrders)) {
                $allOrders = array_merge($allOrders, $customerOrders);
            }
            ++$pageCounter;
        } while (!empty($customerOrders) && $recordsCount == $itemsPerPage);
        return $allOrders;
    }

    /**
     * Get count of customer orders
     *
     * @param int $customerId
     * @return int Count of customer orders
     */
    public function getOrdersCount($customerId)
    {
        $ordersCount = 0;

        //Gets all customer orders
        $customerOrders = $this->getOrders($customerId, config('settings.pagination.items_per_page'));
        if (!empty($customerOrders)) {
            $ordersCount = count($customerOrders);
        }
        return $ordersCount;
    }
}