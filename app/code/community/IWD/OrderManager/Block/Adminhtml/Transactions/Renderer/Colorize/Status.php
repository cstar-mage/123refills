<?php

class IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Options
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
            return parent::render($row);
        }

        $current_status = $row->getData('mage_transaction_status');
        $compare_status = $row->getData('auth_transaction_status');

        $equal = false;
        switch ($current_status) {
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_PAYMENT:
                $equal = false; /* I don't know when this status uses */
                break;
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_ORDER:
                $equal = ($compare_status == "authorizedPendingCapture"); /* Pending approval on gateway */
                break;
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_AUTH:
                $equal = ($compare_status == "authorizedPendingCapture");
                break;
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_CAPTURE:
                $equal = ($compare_status == "capturedPendingSettlement" || $compare_status == "settledSuccessfully");
                break;
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_VOID:
                $equal = ($compare_status == "voided");
                break;
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_REFUND:
                $equal = ($compare_status == "refundSettledSuccessfully" || $compare_status == "refundPendingSettlement");
                break;
        }

        $status = (string)parent::render($row);

        return $equal ? $status : "<b style='color:#C54E35;'>{$status}</b>";
    }
}
