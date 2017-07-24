<?php

class Ranvi_Feed_Block_Adminhtml_Items_Edit extends Mage_Adminhtml_Block_Widget_Form_Container

{

    public function __construct(){

    	

        parent::__construct();

                 

        $this->_objectId = 'id';

        $this->_blockGroup = 'ranvi_feed';

        $this->_controller = 'adminhtml_items';

        

        $this->_updateButton('save', 'label', $this->__('Save'));

        $this->_updateButton('delete', 'label', $this->__('Delete'));

		

		$feed = Mage::registry('ranvi_feed');

		

		if($feed && $feed->getId() > 0){

			

			$this->_addButton('generate', array(

	            'label'     => $this->__('Generate File'),

	            'onclick'   => 'if($(\'loading-mask\')){$(\'loading-mask\').show();}setLocation(\''.$this->getUrl('*/*/generate', array('id'=>$feed->getId())).'\')',

	        ), -100);

	        

	        if($feed->getFtpActive()){

	        

		        $this->_addButton('upload', array(

		            'label'     => $this->__('Upload File'),

		            'onclick'   => 'setLocation(\''.$this->getUrl('*/*/upload', array('id'=>$feed->getId())).'\')',

		        ), -100);

		        

	        }

        

        }

		

        $this->_addButton('saveandcontinue', array(

            'label'     => $this->__('Save And Continue Edit'),

            'onclick'   => 'saveAndContinueEdit()',

            'class'     => 'save',

        ), -100);

        

        $_data = array();

        $_data['data'] = Ranvi_Feed_Block_Adminhtml_Items_Edit_Tab_Content_Csv::getSystemSections(); 

        $_data['url'] = $this->getUrl('*/*/mappingimportsection', array('id'=>($feed && $feed->getId() ? $feed->getId() : 0)));

        

        $this->_formScripts[] = "

            function saveAndContinueEdit(){

                editForm.submit($('edit_form').action+'back/edit/');

            }

            

            var RanviFeedAdmin = new RanviFeedAdminSettings(" . Zend_Json::encode($_data) . ");



        ";

        

        if ($this->getRequest()->getActionName() == 'new' &&

        	!$this->getRequest()->getParam('type')){

        	$this->removeButton('save');

        	$this->removeButton('saveandcontinue');

        }

        

    }

    

    public function getHeaderText(){

    	

        if( Mage::registry('ranvi_feed') && Mage::registry('ranvi_feed')->getId() ) {

            return $this->__("Edit %s", $this->htmlEscape(Mage::registry('ranvi_feed')->getName()));

        } else {

            return $this->__('Add Item');

        }

    }

}