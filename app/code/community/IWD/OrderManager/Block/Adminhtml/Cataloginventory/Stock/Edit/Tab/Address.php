<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock_Edit_Tab_Address extends IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock_Edit_Tab_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iwd/ordermanager/cataloginventory/stock/edit/tab/address.phtml');
    }

    public function getRegionsUrl()
    {
        return $this->getUrl('adminhtml/json/countryRegion');
    }

    protected function addFieldsetToForm()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $fieldset = $this->form->addFieldset('iwd_ordermanaget_stock_address', array(
            'legend' => $helper->__('Source Address')
        ));

        $fieldset->addField('street', 'text', array(
            'label' => $helper->__('Street'),
            'title' => $helper->__('Street'),
            'name' => 'street',
        ));

        $fieldset->addField('city', 'text', array(
            'label' => $helper->__('City'),
            'title' => $helper->__('City'),
            'name' => 'city',
        ));

        $fieldset->addField('country_id', 'select', array(
            'name'  => 'country_id',
            'label' => $helper->__('Country'),
            'title' => $helper->__('Country'),
            'class' => 'countries',
            'values' => Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
        ));

        $fieldset->addField('region', 'select', array(
            'name'      => 'region',
            'label'     => $helper->__('State'),
            'title'     => $helper->__('State'),
        ));

        $fieldset->addField('region_id', 'hidden', array(
            'name'      => 'region_id',
            'label'     => $helper->__('State ID'),
            'title'     => $helper->__('State ID '),
        ));

        $regionElement = $this->form->getElement('region');
        if ($regionElement) {
            $regionElement->setRenderer(Mage::getModel('adminhtml/customer_renderer_region'));
        }

        $regionElement = $this->form->getElement('region_id');
        if ($regionElement) {
            $regionElement->setNoDisplay(true);
        }

        $fieldset->addField('postcode', 'text', array(
            'label' => $helper->__('Postcode'),
            'title' => $helper->__('Postcode'),
            'name' => 'postcode',
        ));
    }
}