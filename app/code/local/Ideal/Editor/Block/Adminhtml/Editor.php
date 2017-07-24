<?php
class Ideal_Editor_Block_Adminhtml_Editor extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_editor';
    $this->_blockGroup = 'editor';
    $this->_headerText = Mage::helper('editor')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('editor')->__('Add Item');
    $this->_addButton('import_css', array(
            'label'     => Mage::helper('Sales')->__('Import Css'),
            'onclick'   => 'setLocation(\''.$this->getUrl('editor/adminhtml_editor/importcss', array('_current'=>true)).'\')',
            'class'     => 'go'
        ), 0, 100, 'header', 'header');
    parent::__construct();
    $this->_removeButton('add');
  }
}