<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Types_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    protected $form;

    protected function _prepareForm()
    {
        try {
            $this->form = new Varien_Data_Form();
            $this->setForm($this->form);
            $this->addFieldsetToFormGeneral();
            $this->setValuesToForm();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e . __CLASS__);
        }

        return parent::_prepareForm();
    }

    protected function addFieldsetToFormGeneral()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $fieldset = $this->form->addFieldset('iwd_om_flags_types_general_info', array(
            'legend' => $helper->__('General Information')
        ));

        $fieldset->addField('name', 'text', array(
            'label' => $helper->__('Name'),
            'title' => $helper->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('comment', 'text', array(
            'label' => $helper->__('Comment'),
            'title' => $helper->__('Comment'),
            'required' => false,
            'name' => 'comment',
        ));

        if ($this->isEdit()) {
            $fieldset->addField('position', 'label', array(
                'label' => $helper->__('Position'),
                'title' => $helper->__('Position'),
                'after_element_html' => '<p style="max-width:280px">Manage column position under \'Order Grid Columns\' in <a href="' . $this->getUrl('adminhtml/system_config/edit', array('section' => 'iwd_ordermanager')) . '" target="_blank">extension settings</a>.</p>'
            ));
        }
    }

    protected function setValuesToForm()
    {
        $types = $this->getFlagTypesData();
        $data = ($types && !is_array($types)) ? $types->getData() : array();
        $this->form->setValues($data);
    }

    protected function getFlagTypesData()
    {
        return Mage::registry('iwd_om_flags_types');
    }

    protected function isEdit()
    {
        $data = $this->getFlagTypesData();
        return (!empty($data) && $data->getId());
    }
}
