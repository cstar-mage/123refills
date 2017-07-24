<?php

class IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Order extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected $export = false;

    public function __construct(array $args = array())
    {
        if (isset($args['export'])) {
            $this->export = $args['export'];
        }
        parent::__construct($args);
    }

    public function render(Varien_Object $row)
    {
        if ($this->export) {
            return $row['order_increment_id'];
        }

        $url = Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/view', array('order_id' => $row['order_id']));
        return "<a href='{$url}' title='{$row['order_id']}' target='_blank'>{$row['order_increment_id']}</a>";
    }
}
