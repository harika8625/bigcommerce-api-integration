<?php
if (!function_exists('get_pages_count')) {
    /**
     * Returns total number of pages in the API collection
     *
     * @param integer $num_of_records
     * Total number of records
     *
     *@param integer $records_per_page
     * Number of records per page
     *
     * @return integer with total number of pages
     *
     * */
    function get_pages_count($num_of_records, $records_per_page = 20)
    {
        if ($num_of_records <= $records_per_page) {
            $total_pages = 1;
        } else {
            $total_pages = ceil($num_of_records / $records_per_page);
        }
        return $total_pages;
    }
}
