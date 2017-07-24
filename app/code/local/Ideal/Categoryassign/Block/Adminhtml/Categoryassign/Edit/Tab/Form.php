<?php
class Ideal_Categoryassign_Block_Adminhtml_Categoryassign_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('categoryassign_form', array('legend'=>Mage::helper('categoryassign')->__('Category Assignment')));
         
    
       /* $fieldset->addField('date_from', 'date', array(
              'label'     => Mage::helper('categoryassign')->__('Date From'),
              //'class'     => 'required-entry',
              //'required'  => true,
              'name'      => 'date_from',
				'image' => $this->getSkinUrl('images/grid-cal.gif'),
          		'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) 
          ));
        
        $fieldset->addField('date_to', 'date', array(
            'label'     => Mage::helper('categoryassign')->__('Date To'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'date_to',
			'image' => $this->getSkinUrl('images/grid-cal.gif'),
          	'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) 
        ));*/
        
        $fieldset->addField('catassign_searchword', 'text', array(
        		'label'     => Mage::helper('categoryassign')->__('Search Word'),
        		//'class'     => 'required-entry',
        		//'required'  => true,
        		'name'      => 'catassign_searchword',
        ));
        
        $fieldset->addField('catassign_categoryid', 'text', array(
            'label'     => Mage::helper('categoryassign')->__('Category IDs'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'catassign_categoryid',
        ));
        
        $fieldset->addField('catassign_attrname', 'text', array(
            'label'     => Mage::helper('categoryassign')->__('Attribute Name'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'catassign_attrname',
        ));
        $fieldset->addField('catassign_rules', 'select', array(
        		'label'     => Mage::helper('categoryassign')->__('Rules'),
        		'class'     => 'required-entry',
        		'required'  => true,
        		'name'      => 'catassign_rules',
        		'values' => array(
        				'-1'=>'Please Select..',
        				'contains' => 'contains',
        				'is_equal' => 'is equal',
        				),
        ));
    
        if ( Mage::getSingleton('adminhtml/session')->getCategoryassignData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCategoryassignData());
            Mage::getSingleton('adminhtml/session')->setCategoryassignData(null);
        } elseif ( Mage::registry('categoryassign_data') ) {
            $form->setValues(Mage::registry('categoryassign_data')->getData());
        }
        return parent::_prepareForm();
    }

}
?>