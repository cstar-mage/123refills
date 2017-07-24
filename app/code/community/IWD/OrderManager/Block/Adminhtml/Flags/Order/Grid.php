<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Order_Grid extends Mage_Adminhtml_Block_Template
{
    public function getFlagsForTypes()
    {
        $collection = Mage::getModel('iwd_ordermanager/flags_flag_type')->getCollection()
            ->addFieldToSelect(array(
                'type_id' => 'type_id',
                'flags' => new Zend_Db_Expr("group_concat(DISTINCT main_table.flag_id SEPARATOR \", \")")
            ));
        $collection->getSelect()->group('main_table.type_id');

        $flags = array();
        foreach ($collection as $item) {
            $flags[$item->getTypeId()] = explode(',', $item->getFlags());
        }

        return json_encode($flags);
    }

    public function isEnabled()
    {
        return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/assign_flags');
    }
}
