<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Backup_Comments_Renderer_Comment extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $result = "";

        if (isset($row['deletion_row'])) {
            $commentObj = unserialize($row['deletion_row']);

            if (isset($commentObj['status'])) {
                $result .= '<b>' . $commentObj['status'] . ':</b> ';
            }
            if (isset($commentObj['comment'])) {
                $result .= $commentObj['comment'];
            }
        }
        
        return $result;
    }
}
