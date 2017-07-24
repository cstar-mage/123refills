<?php

class IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Transaction extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Number
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
            return $row['transaction_id'];
        }

        $url = Mage::helper('adminhtml')->getUrl('adminhtml/sales_transactions/view', array('txn_id' => $row['payment_transaction_id']));
        return "<a href='{$url}' title='{$row['payment_transaction_id']}' target='_blank'>{$row['transaction_id']}</a>";
    }
}
