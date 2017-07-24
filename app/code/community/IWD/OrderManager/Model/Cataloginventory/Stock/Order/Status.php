<?php

class IWD_OrderManager_Model_Cataloginventory_Stock_Order_Status
{
    public static function getStatuses()
    {
       return array(
           1  => 'Assigned',
           0  => 'Not Assigned',
           -1 => 'Not Applicable'
       );
    }
}