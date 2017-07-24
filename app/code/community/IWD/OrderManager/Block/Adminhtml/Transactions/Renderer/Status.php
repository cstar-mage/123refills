<?php

class IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
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
            return $row['status'];
        }

        if ((int)$row['status'] == 1) {
            $alt = Mage::helper('iwd_ordermanager')->__('Good');
            $img = $this->getSkinUrl('images/success_msg_icon.gif');
        } else {
            $alt = Mage::helper('iwd_ordermanager')->__('Bad');
            $img = $this->getSkinUrl('images/error_msg_icon.gif');
        }

        $trx_id = $row['payment_transaction_id'];
        return "<img src='{$img}' alt='{$alt}' title='{$alt}' data-trx-id='{$trx_id}'/>";
    }
}
