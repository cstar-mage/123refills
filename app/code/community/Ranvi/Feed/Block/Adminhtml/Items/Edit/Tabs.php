<?php

class Ranvi_Feed_Block_Adminhtml_Items_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs

{

    public function __construct(){

    	

        parent::__construct();

        $this->setId('ranvi_feed_tabs');

        $this->setDestElementId('edit_form');

        $this->setTitle($this->__('Feed Information'));

        

    }

    

    protected function _prepareLayout(){

        if(($type = $this->getRequest()->getParam('type', null)) || (Mage::registry('ranvi_feed') && ($type = Mage::registry('ranvi_feed')->getType()))){


        $this->addTab('main_section', array(

	            'label'     =>  $this->__('Item information'),

	            'title'     =>  $this->__('Item information'),

	            'content'   =>  $this->getLayout()->createBlock('ranvi_feed/adminhtml_items_edit_tab_main')->toHtml(),

	        ));

          	$this->addTab('content_section', array(

	            'label'     =>  $this->__('Content Settings'),

	            'title'     =>  $this->__('Content Settings'),

	            'content'   =>  $this->getLayout()->createBlock('ranvi_feed/adminhtml_items_edit_tab_content_csv')

	            				->setTemplate('ranvi/feed/item/edit/content.phtml')->toHtml(),

	        ));
	        

	        $this->addTab('advanced', array(

	            'label'     =>  $this->__('Advanced Settings'),

	            'title'     =>  $this->__('Advanced Settings'),

	            'content'   =>  $this->getLayout()->createBlock('ranvi_feed/adminhtml_items_edit_tab_advanced')->toHtml(),

	        ));
	        
 		}else{

        	

        	$this->addTab('main_section', array(

                'label'     => $this->__('Content Settings'),

                'title'     => $this->__('Content Settings'),

                'content'   => $this->getLayout()->createBlock('ranvi_feed/adminhtml_items_edit_tab_type')->toHtml(),

            ));

        	

        }
	        
        if($tabId = addslashes(htmlspecialchars($this->getRequest()->getParam('tab')))){

        	

        	$this->setActiveTab($tabId);

        }

        

        

        return parent::_beforeToHtml();

        

    }

       

}