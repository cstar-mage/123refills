<?php

class IWD_OrderManager_Model_Order_Pdf_Items_Order_Grouped extends IWD_OrderManager_Model_Order_Pdf_Items_Order_Default
{
    public function draw()
    {
        $type = $this->getItem()->getRealProductType();
        $renderer = $this->getRenderedModel()->getRenderer($type);
        $renderer->setOrder($this->getOrder());
        $renderer->setItem($this->getItem());
        $renderer->setPdf($this->getPdf());
        $renderer->setPage($this->getPage());

        $renderer->draw();
    }
}
