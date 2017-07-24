<?php
/**
 * @copyright   Copyright (c) 2009-2012 Amasty (http://www.amasty.com)
 */ 
class Amasty_Finder_Block_Adminhtml_Finder_Edit_Tab_Import extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        //create form structure
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $hlp = Mage::helper('amfinder');
        
        $fldSet = $form->addFieldset('amfinder_import', array('legend'=> $hlp->__('Import Options')));
        $fldSet->addField('import_clear', 'select', array(
          'label'     => $hlp->__('Delete Existing Data'),
          'name'      => 'import_clear',
          'values'    => array(
            array(
                'value' => 0,
                'label' => Mage::helper('catalog')->__('No')
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('catalog')->__('Yes')
            ))
        ));

        $fldSet->addField('import_file', 'file', array(
          'label'     => $hlp->__('CSV File'),
          'name'      => 'import_file',
          'note'      => $hlp->__('dropdown1, dropdown2, ..., SKU')
        ));               

        return parent::_prepareForm();
    }
}