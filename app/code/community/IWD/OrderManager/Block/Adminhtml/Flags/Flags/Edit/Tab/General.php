<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Flags_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    protected $form;

    protected function _prepareForm()
    {
        try {
            $this->form = new Varien_Data_Form();
            $this->setForm($this->form);
            $this->addFieldsetToFormGeneral();
            $this->addFieldsetToFormTypes();
            $this->setValuesToForm();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e . __CLASS__);
        }

        return parent::_prepareForm();
    }

    protected function addFieldsetToFormGeneral()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $fieldset = $this->form->addFieldset('iwd_om_flags_general_info', array(
            'legend' => $helper->__('General Information')
        ));

        $fieldset->addField('name', 'text', array(
            'label' => $helper->__('Name'),
            'title' => $helper->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('icon-font', 'radio', array(
            'label' => $helper->__('Icon'),
            'title' => $helper->__('Icon'),
            'name' => 'radio_icon_type',
            'value' => 'icon',
            'after_element_html' => '<label for="icon-font">' . $helper->__("Font Awesome") . '</label>',
        ));

        $fieldset->addField('icon_fa', 'text', array(
            'label' => '',
            'title' => '',
            'class' => 'required-entry margin-left',
            'required' => true,
            'name' => 'icon_fa',
            'comment' => 'Enter icon code (ie. fa-flag)  Cheatsheet',
            'after_element_html' => '<p class="note margin-left">' . $helper->__("Enter icon code (ie. fa-flag)") . '&nbsp;&nbsp;<a href="http://fontawesome.io/cheatsheet/" target="_blank" >Cheatsheet</a></p>',
        ));

        $fieldset->addField('icon_fa_color', 'text', array(
            'label' => '',
            'title' => '',
            'class' => 'required-entry margin-left',
            'required' => true,
            'name' => 'icon_fa_color',
        ));

        $fieldset->addField('icon-image', 'radio', array(
            'label' => '',
            'title' => '',
            'name' => 'radio_icon_type',
            'value'  => 'image',
            'after_element_html' => '<label for="icon-image">' . $helper->__("Upload Image") . '</label>',
        ));

        $fieldset->addType('thumbnail', 'IWD_OrderManager_Varien_Data_Form_Element_Thumbnail');
        $fieldset->addField('icon_img', 'thumbnail', array(
            'label' => '',
            'title' => '',
            'name' => 'icon_img',
            'value' => 'Upload',
            'disabled' => false,
            'readonly' => true,
            'class' => 'required-entry margin-left',
            'required' => true,
            'after_element_html' => '<p class="note margin-left">JPG, PNG or GIF. Max file size: ' . $this->getMaxUploadFileSize()  . '<br />Recommended image size 34x90 pixels.</p>',
        ));

        $fieldset->addField('comment', 'text', array(
            'label' => $helper->__('Comment'),
            'title' => $helper->__('Comment'),
            'required' => false,
            'name' => 'comment',
        ));

        $fieldset->addField('icon_type', 'hidden', array(
            'name' => 'icon_type'
        ));
    }

    protected function addFieldsetToFormTypes()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $fieldset = $this->form->addFieldset('iwd_om_flags_types_info', array(
            'legend' => $helper->__('Columns for Label')
        ));

        $fieldset->addField('types', 'multiselect', array(
            'label' => $helper->__('Assign Columns To Label'),
            'title' => $helper->__('Assign Columns To Label'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'types',
            'values' => Mage::getModel('iwd_ordermanager/flags_types')->toOptionArray(),
            'after_element_html' => '<p class="note">Select the column(s) for label to appear, or <a href="' . $this->getUrl('*/flags_types/new') . '" target="_blank">add new column.</a></p>',
        ));
    }

    public function getMaxUploadFileSize()
    {
        return ini_get('upload_max_filesize') < ini_get('post_max_size') ? ini_get('upload_max_filesize') : ini_get('post_max_size');
    }

    protected function setValuesToForm()
    {
        $flag = Mage::registry('iwd_om_flags');
        $data = ($flag && !is_array($flag)) ? $flag->getData() : array();

        $data['icon-font'] = 'font';
        $data['icon-image'] = 'image';
        $data['icon_img'] = $flag->getIconImage();

        $this->form->setValues($data);
    }
}
