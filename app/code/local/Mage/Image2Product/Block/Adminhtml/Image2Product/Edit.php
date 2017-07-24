<?php

class Mage_Image2Product_Block_Adminhtml_Image2Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'Image2Product';
        $this->_controller = 'adminhtml_Image2Product';
		$this->_removeButton('reset');
		$this->_removeButton('save');
		$this->_removeButton('back');

		/*$fieldset = $this->_addButton('remove', array(
           'label'     => Mage::helper('adminhtml')->__('Remove Images'),
            'onclick'   => "confirmSetLocation('Are you sure?','".$this->getUrl('Image2Product/adminhtml_Image2Product/remove', array('_current'=>true))."')",
            'class'     => 'delete', 
        ), -100);

		$this->_addButton('generatecsv', array(
           'label'     => Mage::helper('adminhtml')->__('Generate CSV'),
            'onclick'   => 'setLocation(\''.$this->getUrl('Image2Product/adminhtml_Image2Product/generatecsv', array('_current'=>true)).'\')',
            'class'     => 'save', 
        ), -100);   */    
		
		$this->_addButton('downloadcsv', array(
           'label'     => Mage::helper('adminhtml')->__('Download CSV'),
            'onclick'   => 'setLocation(\''.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media/import/Image2Products.csv'.'\')',
            'class'     => 'save', 
        ), -100);
       
		/*$this->_addButton('insertinpopup', array(
           'label'     => Mage::helper('adminhtml')->__('Update Products'),
            'onclick'   => 'window.open(\''.$this->getUrl('Image2Product/adminhtml_Image2Product/insertinpopup', array('_current'=>true)).'\')',
            'class'     => 'save',
        ), -100); */

/*	    $this->_updateButton('save', 'label', Mage::helper('Image2Product')->__('Save Rules'));
       
		$this->_addButton('run_in_popup', array(
           'label'     => Mage::helper('adminhtml')->__('Get New List'),
            'onclick'   => 'setLocation(\''.$this->getUrl('Image2Product/adminhtml_Image2Product/insertinpopup', array('_current'=>true)).'\')',
            'class'     => 'save', 
        ), -100);
		
		$this->_addButton('reindex', array(
           'label'     => Mage::helper('adminhtml')->__('Update Diamonds'),
            'onclick'   => 'setLocation(\''.$this->getUrl('Image2Product/adminhtml_Image2Product/reindex', array('_current'=>true)).'\')',
            'class'     => 'save', 
        ), -100);
		
		$this->_addButton('download', array(
           'label'     => Mage::helper('adminhtml')->__('Download CSV'),
            'onclick'   => 'setLocation(\''.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'var/import/imageproducts.csv'.'\')',
            'class'     => 'save', 
        ), -100); */
		
    }
	  protected function _prepareLayout()
    {
		  return parent::_prepareLayout();
	}
    public function getHeaderText()
    {
		return Mage::helper('Image2Product')->__('Image to Product');
    }
}

?>