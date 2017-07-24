<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Backup_Sales_Renderer_Items extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    private $result;

    public function render(Varien_Object $row)
    {
        $deletedObjectItems = unserialize($row['object_items']);
        $this->result = "<table>";
        $this->addRow(array(
                '<b>Name</b>',
                '<b>O</b>',
                '<b>I</b>',
                '<b>C</b>',
                '<b>R</b>',
                '<b>Sh</b>',
                '<b>Row&nbsp;Total</b>'
            )
        );

        foreach ($deletedObjectItems as $item) {
            $name = isset($item['name']) ? $item['name'] : "";
            $name .= isset($item['sku']) ? ' [' . $item['sku'] . ']' : "";
            $qtyOrdered = isset($item['qty_ordered']) ? $item['qty_ordered'] : 0;
            $qtyInvoiced = isset($item['qty_invoiced']) ? $item['qty_invoiced'] : 0;
            $qtyCanceled = isset($item['qty_canceled']) ? $item['qty_canceled'] : 0;
            $qtyRefunded = isset($item['qty_refunded']) ? $item['qty_refunded'] : 0;
            $qtyShipped = isset($item['qty_shipped']) ? $item['qty_shipped'] : 0;
            $rowTotal = isset($item['row_total']) ? $item['row_total'] : 0;


            $row = array($name,
                $qtyOrdered * 1,
                $qtyInvoiced * 1,
                $qtyCanceled * 1,
                $qtyRefunded * 1,
                $qtyShipped * 1,
                Mage::helper('core')->currency($rowTotal, true, false),
            );

            $this->addRow($row);
        }

        return $this->result .= "</table>";
    }

    protected function addRow($items)
    {
        $this->result .= "<tr>";
        foreach ($items as $item) {
            $this->result .= "<td>" . $item . "</td>";
        }
        $this->result .= "</tr>";
    }
}
