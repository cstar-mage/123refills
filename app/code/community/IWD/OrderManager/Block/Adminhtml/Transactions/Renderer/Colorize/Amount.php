<?php

class IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Amount extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Currency
{
    protected $for_compare_coll = null;
    protected $export = false;

    public function __construct(array $args = array())
    {
        if (!empty($args['for_compare_coll'])) {
            $this->for_compare_coll = $args['for_compare_coll'];
        }
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

        $current_amount = $row->getData($this->getColumn()->getIndex());
        $compare_amount = $row->getData($this->for_compare_coll);

        $amount = (string)parent::render($row);
        return ($current_amount == $compare_amount) ? $amount : "<b style='color:#C54E35;'>{$amount}</b>";
    }
}
