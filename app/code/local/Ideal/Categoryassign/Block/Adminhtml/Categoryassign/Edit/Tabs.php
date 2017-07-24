<?php
class Ideal_Categoryassign_Block_Adminhtml_Categoryassign_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
  public function __construct()
  {
      parent::__construct();

      $this->setId('categoryassign_tabs');

      $this->setDestElementId('edit_form');

      $this->setTitle(Mage::helper('categoryassign')->__('Category Assignment'));
  }

 protected function _beforeToHtml()
  {
      $this->addTab('export_orders', array(

          'label'     => Mage::helper('categoryassign')->__('Category Assignment'),

          'title'     => Mage::helper('categoryassign')->__('Category Assignment'),

          'content'   => $this->getLayout()->createBlock('categoryassign/adminhtml_categoryassign_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
?>