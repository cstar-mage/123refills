<?php



class Ideal_Stud_Block_Adminhtml_Stud_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs

{



  public function __construct()

  {

      parent::__construct();

      $this->setId('stud_tabs');

      $this->setDestElementId('edit_form');

      $this->setTitle(Mage::helper('stud')->__('Stud Information'));

  }



  protected function _beforeToHtml()

  {

      /* $this->addTab('form_section', array(

          'label'     => Mage::helper('stud')->__('Stone Information'),

          'title'     => Mage::helper('stud')->__('Stone Information'),

          'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form21')->toHtml(),

      ));

      $this->addTab('form_section_2', array(

          'label'     => Mage::helper('stud')->__('Manage Metal Type'),

          'title'     => Mage::helper('stud')->__('Manage Metal Type'),

          'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form22')->toHtml(),

      )); */
  	
	  	$this->addTab('form_section_3', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Round'),
	  	
	  			'title'     => Mage::helper('stud')->__('Round'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form3')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_5', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Princess'),
	  	
	  			'title'     => Mage::helper('stud')->__('Princess'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form5')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_6', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Emerald'),
	  	
	  			'title'     => Mage::helper('stud')->__('Emerald'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form6')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_7', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Asscher'),
	  	
	  			'title'     => Mage::helper('stud')->__('Asscher'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form7')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_8', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Cushion'),
	  	
	  			'title'     => Mage::helper('stud')->__('Cushion'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form8')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_9', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Radiant Long'),
	  	
	  			'title'     => Mage::helper('stud')->__('Radiant Long'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form9')->toHtml(),
	  	
	  	));
	  	
	  	
	  	$this->addTab('form_section_13', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Marquise'),
	  	
	  			'title'     => Mage::helper('stud')->__('Marquise'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form13')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_14', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Pear'),
	  	
	  			'title'     => Mage::helper('stud')->__('Pear'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form14')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_15', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Heart'),
	  	
	  			'title'     => Mage::helper('stud')->__('Heart'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form15')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_16', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Oval'),
	  	
	  			'title'     => Mage::helper('stud')->__('Oval'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form16')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_17', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Trillion'),
	  	
	  			'title'     => Mage::helper('stud')->__('Trillion'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form17')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_18', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Square Radiant'),
	  	
	  			'title'     => Mage::helper('stud')->__('Square Radiant'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form18')->toHtml(),
	  	
	  	));
	  	
	  	$this->addTab('form_section_19', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Fancy'),
	  	
	  			'title'     => Mage::helper('stud')->__('Fancy'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form19')->toHtml(),
	  	
	  	));
	  	
	   $this->addTab('form_section_4', array(
	  	
	  			'label'     => Mage::helper('stud')->__('Manage Metal Price'),
	  	
	  			'title'     => Mage::helper('stud')->__('Manage Metal Price'),
	  	
	  			'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_form4')->toHtml(),
	  	
	  	));
	   
	   $this->addTab('design_settings', array(
	   		'label'     => Mage::helper('stud')->__('Design Settings'),
	   		'title'     => Mage::helper('stud')->__('Design Settings'),
	   		'content'   => $this->getLayout()->createBlock('stud/adminhtml_stud_edit_tab_design')->toHtml(),
	   ));

      return parent::_beforeToHtml();

  }

}