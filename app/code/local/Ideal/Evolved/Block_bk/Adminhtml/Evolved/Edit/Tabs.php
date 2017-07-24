<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('evolved_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('evolved')->__('Theme Options'));
  }

  protected function _beforeToHtml()
  {
	//  echo $this->getRequest()->getParam('id');
	 // exit;
	 $tab_block = $this->getRequest()->getParam('block');
	 switch ($tab_block) {
	 	case "evolved_comingsoon":
	 		$this->addTab('evolved_comingsoon', array(
		 		'label'     => Mage::helper('evolved')->__('Comming soon'),
		 		'title'     => Mage::helper('evolved')->__('Comming soon'),
		 		'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_comingsoon')->toHtml(),
	 		));
	 		break;
		case "evolved_general":
			      $this->addTab('evolved_general', array(
					  'label'     => Mage::helper('evolved')->__('General'),
					  'title'     => Mage::helper('evolved')->__('General'),
					  'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_general')->toHtml(),
				  ));
			break;
		case "evolved_fonts":
			      $this->addTab('evolved_fonts', array(
					'label'     => Mage::helper('evolved')->__('Fonts'),
					'title'     => Mage::helper('evolved')->__('Fonts'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_fonts')->toHtml(),
				));
			break;
		case "evolved_buttons":
			      $this->addTab('evolved_buttons', array(
					'label'     => Mage::helper('evolved')->__('Buttons'),
					'title'     => Mage::helper('evolved')->__('Buttons'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_buttons')->toHtml(),
			    ));
			break;
		case "evolved_header":
				$this->addTab('evolved_header', array(
					'label'     => Mage::helper('evolved')->__('Header'),
					'title'     => Mage::helper('evolved')->__('Header'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_header')->toHtml(),
				));
		break;
		case "evolved_footer":
				$this->addTab('evolved_footer', array(
					'label'     => Mage::helper('evolved')->__('Footer'),
					'title'     => Mage::helper('evolved')->__('Footer'),
				'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_footer')->toHtml(),
				));
		break;
		case "evolved_homepage":
				$this->addTab('evolved_homepage', array(
						'label'     => Mage::helper('evolved')->__('Home Page'),
						'title'     => Mage::helper('evolved')->__('Home Page'),
						'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_homepage')->toHtml(),
				));
		break;
		case "evolved_newsletter":
				$this->addTab('evolved_newsletter', array(
					'label'     => Mage::helper('evolved')->__('Newsletter'),
					'title'     => Mage::helper('evolved')->__('Newsletter'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_newsletter')->toHtml(),
				));
		break;
		case "evolved_contacts":
			    $this->addTab('evolved_contacts', array(
					'label'     => Mage::helper('evolved')->__('Contact Us'),
					'title'     => Mage::helper('evolved')->__('Contact Us'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_contacts')->toHtml(),
			    ));
		break;
		case "evolved_diamondeducation":
			  $this->addTab('evolved_diamondeducation', array(
					'label'     => Mage::helper('evolved')->__('Diamond Education'),
					'title'     => Mage::helper('evolved')->__('Diamond Education'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_diamondeducation')->toHtml(),
			  ));
		break;
		case "evolved_pages":
			  $this->addTab('evolved_pages', array(
					'label'     => Mage::helper('evolved')->__('Pages'),
					'title'     => Mage::helper('evolved')->__('Pages'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_pages')->toHtml(),
			  ));
		break;
		case "evolved_productlist":
			  $this->addTab('evolved_productlist', array(
					'label'     => Mage::helper('evolved')->__('Product List'),
					'title'     => Mage::helper('evolved')->__('Product List'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_productlist')->toHtml(),
			  ));
		break;
		case "evolved_productdetails":
			 $this->addTab('evolved_productdetails', array(
					'label'     => Mage::helper('evolved')->__('Product Details'),
					'title'     => Mage::helper('evolved')->__('Product Details'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_productdetails')->toHtml(),
			 ));
		break;
		case "evolved_myaccountlogin":
			  $this->addTab('evolved_myaccountlogin', array(
					'label'     => Mage::helper('evolved')->__('My Account / Login'),
					'title'     => Mage::helper('evolved')->__('My Account / Login'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_myaccountlogin')->toHtml(),
			  ));
		break;
		case "evolved_social":
			  $this->addTab('evolved_social', array(
					'label'     => Mage::helper('evolved')->__('Social'),
					'title'     => Mage::helper('evolved')->__('Social'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_social')->toHtml(),
			  ));
		break;
		case "evolved_livechat":
			  $this->addTab('evolved_livechat', array(
					'label'     => Mage::helper('evolved')->__('Live Chat'),
					'title'     => Mage::helper('evolved')->__('Live Chat'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_livechat')->toHtml(),
			  ));
		break;
		case "evolved_checkout":
			  $this->addTab('evolved_checkout', array(
					'label'     => Mage::helper('evolved')->__('Checkout'),
					'title'     => Mage::helper('evolved')->__('Checkout'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_checkout')->toHtml(),
			  ));
		break;
		case "evolved_shipping":
			  $this->addTab('evolved_shipping', array(
					'label'     => Mage::helper('evolved')->__('Shopping Cart'),
					'title'     => Mage::helper('evolved')->__('Shopping Cart'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_shipping')->toHtml(),
			  ));
		break;
		case "evolved_aboutus":
			$this->addTab('evolved_aboutus', array(
			'label'     => Mage::helper('evolved')->__('About Us'),
			'title'     => Mage::helper('evolved')->__('About Us'),
			'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_aboutus')->toHtml(),
			));
		break;
		case "evolved_testimonials":
			$this->addTab('evolved_testimonials', array(
			'label'     => Mage::helper('evolved')->__('Testimonials'),
			'title'     => Mage::helper('evolved')->__('Testimonials'),
			'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_testimonials')->toHtml(),
			));
		break;
		case "evolved_termsandconditions":
			 $this->addTab('evolved_termsandconditions', array(
					'label'     => Mage::helper('evolved')->__('Terms and Conditions'),
					'title'     => Mage::helper('evolved')->__('Terms and Conditions'),
					'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_termsandcondition')->toHtml(),
			  ));
		break;
		case "evolved_designer":
			$this->addTab('evolved_designer', array(
			'label'     => Mage::helper('evolved')->__('Designer'),
			'title'     => Mage::helper('evolved')->__('Designer'),
			'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_designer')->toHtml(),
			));
		break;
		case "evolved_events":
			$this->addTab('evolved_events', array(
			'label'     => Mage::helper('evolved')->__('Events'),
			'title'     => Mage::helper('evolved')->__('Events'),
			'content'   => $this->getLayout()->createBlock('evolved/adminhtml_evolved_edit_tab_events')->toHtml(),
			));
		break;
	}

      return parent::_beforeToHtml();
  }
}