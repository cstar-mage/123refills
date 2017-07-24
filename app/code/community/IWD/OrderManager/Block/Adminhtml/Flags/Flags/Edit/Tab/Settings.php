<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Flags_Edit_Tab_Settings extends Mage_Adminhtml_Block_Widget_Form
{
    protected $form;

    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        try {
            $this->form = new Varien_Data_Form();
            $this->setForm($this->form);
            $this->addFieldsetToForm();
            $this->setValuesToForm();
        } catch (Exception $e) {
            Mage::helper('iwd_ordermanager')->addExceptionToLog($e, __CLASS__);
        }

        return parent::_prepareForm();
    }

    protected function addFieldsetToForm()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $fieldset = $this->form->addFieldset('iwd_om_flags_settings', array(
            'legend' => $helper->__('Assign Automatically')
        ));

        $fieldset->addField('order_status', 'multiselect', array(
            'label' => $helper->__('Statuses'),
            'title' => $helper->__('Statuses'),
            'required' => false,
            'name' => 'order_status',
            'values' => Mage::getModel('iwd_ordermanager/system_config_status_order')->toOptionArray(),
            'note' => 'Apply label to orders with selected status(es)'
        ));

        $fieldset->addField('payment_method', 'multiselect', array(
            'label' => $helper->__('Payment Methods'),
            'title' => $helper->__('Payment Methods'),
            'required' => false,
            'name' => 'payment_method',
            'values' => Mage::getModel('iwd_ordermanager/payment_payment')->getActivePaymentMethodsArray(),
            'note' => 'Apply label to orders with selected payment method(s)'
        ));

        $fieldset->addField('shipping_method', 'multiselect', array(
            'label' => $helper->__('Shipping Methods'),
            'title' => $helper->__('Shipping Methods'),
            'required' => false,
            'name' => 'shipping_method',
            'values' => Mage::getModel('adminhtml/system_config_source_shipping_allowedmethods')->toOptionArray(true),
            'note' => 'Apply label to orders with selected shipping method(s)'
        ));

        $fieldset->addField('disallowed_autoapply_options', 'hidden', array(
            'name' => 'disallowed_autoapply_options'
        ));
    }

    protected function setValuesToForm()
    {
        $flag = Mage::registry('iwd_om_flags');
        $data = ($flag && !is_array($flag)) ? $flag->getData() : array();
        $data['disallowed_autoapply_options'] = json_encode($data['disallowed_autoapply_options']);
        $this->form->setValues($data);
    }
}
