<?php

abstract class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock_Edit_Tab_Abstract extends Mage_Adminhtml_Block_Widget_Form
{
    protected $form;

    protected function _prepareForm()
    {
        try {
            $this->form = new Varien_Data_Form();
            $this->setForm($this->form);

            $this->addFieldsetToForm();

            $this->setValuesToForm();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }

        return parent::_prepareForm();
    }

    abstract protected function addFieldsetToForm();

    protected function setValuesToForm()
    {
        $data = $this->getStockData();
        if (isset($data) && !empty($data)) {
            $this->form->setValues($data);
        }
    }

    protected function getStockData()
    {
        return Mage::registry('iwd_om_stock_data');
    }

    protected function isEdit()
    {
        $data = $this->getStockData();

        if (!empty($data)) {
            $id = $data->getStockId();
            if (!empty($id)) {
                return true;
            }
        }
        return false;
    }
}