<?php

class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'diamondsearch';
        $this->_controller = 'adminhtml_diamondsearch';
        
        $this->_updateButton('save', 'label', Mage::helper('diamondsearch')->__('Save'));
        
		$this->_removeButton('delete');
        $this->_removeButton('back');
        $this->_removeButton('reset');
        
        $this->_addButton('filterDiamonds', array(
        		'label'     => Mage::helper('diamondsearch')->__('Filter Diamonds'),
        		'onclick' => "setLocation('{$this->getUrl('adminhtml/Diamondsearch/filterDiamonds')}')",
        		 
        ), -100);
        
         $this->_addButton('filterDiamondsImages', array(
        		'label'     => Mage::helper('diamondsearch')->__('Filter Diamond Images'),
        		'onclick' => "setLocation('{$this->getUrl('adminhtml/Diamondsearch/filterDiamondsImages')}')",
        		 
        ), -100); 
		
       /* $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('diamondsearch_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'diamondsearch_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'diamondsearch_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";*/
    }

    public function getHeaderText()
    {
            return Mage::helper('diamondsearch')->__('Design Settings');
    }
}
