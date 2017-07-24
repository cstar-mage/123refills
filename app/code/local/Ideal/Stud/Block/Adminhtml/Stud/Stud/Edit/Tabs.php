<?php

class Ideal_Stud_Block_Adminhtml_Stud_Stud_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs

{

  public function __construct()

  {

      parent::__construct();

      $this->setId('stud_tabs');

      $this->setDestElementId('edit_form');

      $this->setTitle(Mage::helper('stud')->__('Setting'));

  }



  protected function _beforeToHtml()

  {


    
	  	$this->addTab('clarity_setting', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Clarity Setting'),
	  	
	  			'title'     => Mage::helper('stud')->__('Clarity Setting'), 
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_stud_edit_tab_clarity')->toHtml(),
	  			//'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_stud_edit_tab_clarity')->toHtml(),
	  	
	  	));

        $this->addTab('carat_weight', array(
      
          'label'     => Mage::helper('stud')->__('Carat Weight'),
      
          'title'     => Mage::helper('stud')->__('Carat Weight'), 
      
          'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_stud_edit_tab_carat')->toHtml(),
          //'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_stud_edit_tab_clarity')->toHtml(),
      
      ));
  
      return parent::_beforeToHtml();

  }

}