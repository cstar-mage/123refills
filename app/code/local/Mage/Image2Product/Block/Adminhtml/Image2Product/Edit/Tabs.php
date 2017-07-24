<?php
class Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
  public function __construct()
  {
      parent::__construct();

      $this->setId('Image2Product_tabs');

      $this->setDestElementId('edit_form');

      $this->setTitle(Mage::helper('Image2Product')->__('Image To Product'));
  }

 protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(

          'label'     => Mage::helper('Image2Product')->__('File Uploader'),

          'title'     => Mage::helper('Image2Product')->__('File Uploader'),

          'content'   => $this->getLayout()->createBlock('Image2Product/adminhtml_Image2Product_edit_tab_form')->toHtml(),
      ));
     /* $this->addTab('form_section_2', array(

          'label'     => Mage::helper('Image2Product')->__('Configuration Columns'),

          'title'     => Mage::helper('Image2Product')->__('Configuration Columns'),

          'content'   => $this->getLayout()->createBlock('Image2Product/adminhtml_Image2Product_edit_tab_form2')->toHtml(),
      ));*/
      return parent::_beforeToHtml();
  }
}
?>