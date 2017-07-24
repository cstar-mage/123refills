<?php
class Ideal_Categoryassign_Block_Adminhtml_Categoryassign_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'categoryassign';
        $this->_controller = 'adminhtml_categoryassign';
		$this->_removeButton('reset');
		$this->_removeButton('back');
		$this->_removeButton('save');
		
		$this->_addButton('export_cli', array(
		    'label'     => Mage::helper('adminhtml')->__('Export CSV'),
		    'onclick'   => 'exportCatassigncsv()',
		    'class'     => 'save',
		), -100);

		
		$this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('signupemail_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'signupemail_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'signupemail_content');
                }
            }
		
            function exportCatassigncsv(){
                editForm.submit('http://www.jewelrydemo.com/index.php/categoryassign/adminhtml_categoryassign/exportCSV/');
            }
        ";
		
    }
	protected function _prepareLayout()
    {
		  return parent::_prepareLayout();
	}
    public function getHeaderText()
    {
		return Mage::helper('categoryassign')->__('Category Assignment');
    }
}
?>