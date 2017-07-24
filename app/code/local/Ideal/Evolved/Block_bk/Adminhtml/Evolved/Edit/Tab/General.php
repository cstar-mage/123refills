<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      
      $evolveddata = Mage::getModel('evolved/evolved')->getCollection()->addFieldToFilter("field",array('like'=>'general_store_%'));
      foreach($evolveddata as $evolveddata1)
      {
			//echo "<br />".$evolveddata1['value'];
			$evolvedgeneldatarr[$evolveddata1['field']] = $evolveddata1['value'];
      }
//      echo $evolveddata1['value'];
   
      
      $fieldsetInfo = $form->addFieldset('evolved_form_general_info', array('legend'=>Mage::helper('evolved')->__('Theme Information'),'class' => 'fieldset-wide', 'expanded'  => true));
      $fieldsetInfo->addField('evolved_form_general_info_version', 'note', array(
      		'label'     => Mage::helper('evolved')->__('Evolved Version:'),
      		'text'      => '1.1.1.1',
      ));
      
      
      $fieldsetStore = $form->addFieldset('evolved_form_general_store', array('legend'=>Mage::helper('evolved')->__('Store Information')));
      
      $fieldsetStore->addField('general_store_information_name', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Store Name:'),
      		'name'      => 'config[general_store_information_name]',
      		'value'      => Mage::getStoreConfig('general/store_information/name'),
      ));
      
      $fieldsetStore->addField('general_store_information_website_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Website Url:'),
      		'name'      => 'general_store_information_website_url',
      ));
      
      $fieldsetStore->addField('general_store_information_phone', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Store Contact Telephone:'),
      		'name'      => 'config[general_store_information_phone]',
      		'value'      => Mage::getStoreConfig('general/store_information/phone'),
      ));
	  
	  $fieldsetStore->addField('general_store_information_address1', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Street Address:'),
      		'name'      => 'general_store_information_address1',
      ));
      
	  $fieldsetStore->addField('general_store_information_address2', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Street Address Line 2:'),
      		'name'      => 'general_store_information_address2',
      ));
	  
	   $fieldsetStore->addField('general_store_information_city', 'text', array(
      		'label'     => Mage::helper('evolved')->__('City:'),
      		'name'      => 'general_store_information_city',
      ));
	  
	  $fieldsetStore->addField('general_store_information_zip', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Zip/Postal Code:'),
      		'name'      => 'general_store_information_zip',
      )); 
      /* $fieldsetStore->addField('general_store_information_address', 'textarea', array(
      		'label'     => Mage::helper('evolved')->__('Store Contact Address:'),
      		'name'      => 'config[general_store_information_address]',
      		'value'      => Mage::getStoreConfig('general/store_information/address'),
      )); */
	  
	   $stateCollection = Mage::getModel('directory/region')->getResourceCollection()->addCountryFilter('US')->load();
      $state = "";
      foreach ($stateCollection as $_state) {
      	$state[]= array('value'=>$_state->getId(),'label'=>$_state->getDefaultName());
      }
     
      $countrycode = $evolvedgeneldatarr['general_store_country'];
      $statearray = Mage::getModel('directory/region')->getResourceCollection() ->addCountryFilter($countrycode)->load();
      foreach ($statearray as $statearray1) {
      	$statearraydata[]= array('value'=>$statearray1->getId(),'label'=>$statearray1->getDefaultName());
      }

      if(count($statearray) != 0)
      {
      	$fieldsetStore->addField('general_store_state', 'select', array(
      			'name'  => 'general_store_state',
      			'label'     => 'Region/State',
      			'values' => $statearraydata,
      			'container_id'  => 'general_state_row'
      			//'values'    => Mage::getModel('evolved/evolved')->getstate('AU'),
      	));
      }
      else {
      	$fieldsetStore->addField('general_store_state', 'text', array(
      			'name'  => 'general_store_state',
      			'label'     => 'Region/State',
      			'values' => $evolvedgeneldatarr['general_store_state'],
      			'container_id'  => 'general_state_row'
      			//'values'    => Mage::getModel('evolved/evolved')->getstate('AU'),
      	));
      }
      
      $country = $fieldsetStore->addField('general_store_country', 'select', array(
      		'name'  => 'general_store_country',
      		'label'     => 'Country',
      		'values'    => Mage::getModel('adminhtml/system_config_source_country') ->toOptionArray(),
      		//'onchange' => 'getstate(this)',
      ));
	  
	  /*$country->setAfterElementHtml("<script type=\"text/javascript\">
      		function getstate(selectElement){
      		var reloadurl = '". $this->getUrl('evolved/adminhtml_evolved/state') . "country/' + selectElement.value;
	      		new Ajax.Request(reloadurl, {
	      		method: 'get',
	      		onLoading: function (stateform) {
	      		$('general_store_state').update('Searching...');
	      },
	      		onComplete: function(stateform) {
	      		$('general_store_state').update(stateform.responseText);
	      }
	      });
	      }
      </script>");
      */
      $country->setAfterElementHtml("<script type=\"text/javascript\">
      		var jq = jQuery.noConflict();
      		jq(window).load(function(){
      			jq('#general_store_country').change(function(){
		      		jq.ajax({
					  url: '". $this->getUrl('evolved/adminhtml_evolved/state') . "country/' + jq(this).val(),
					  beforeSend: function( xhr ) {
					    jq('#loading-mask').css('display','block');
					  }
					})
					  .done(function( data ) {
      						jq('#general_state_row .value').html(data);
      						jq('#loading-mask').css('display','none');
					  });
  				});
  			});
      </script>");
      
          
      
      
      /*
       * Add Ajax to the Country select box html output
      */
      
      
      /*$fieldsetStore->addField('trans_email_ident_general_name', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Email Sender Name:'),
      		'name'      => 'config[trans_email_ident_general_name]',
      		'value'      => Mage::getStoreConfig('trans_email/ident_general/name'),
      ));*/
      
      $fieldsetStore->addField('trans_email_ident_general_email', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Email Address:'),
      		'name'      => 'config[trans_email_ident_general_email]',
      		'value'      => Mage::getStoreConfig('trans_email/ident_general/email'),
      ));
      
      
      /*
      $cms_address_fieldset = $form->addFieldset('evolved_form_cmspages', array('legend'=>Mage::helper('evolved')->__('CMS Address')));
      $cms_address_fieldset->addField('cms_address_website_name', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Company Name:'),
      		'name'      => 'cms_address_website_name',
      ));
      
      $cms_address_fieldset->addField('cms_address_website_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Website Url:'),
      		'name'      => 'cms_address_website_url',
      ));
      
      $cms_address_fieldset->addField('cms_address_address_line_one', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Address Line 1:'),
      		'name'      => 'cms_address_address_line_one',
      ));
      
      $cms_address_fieldset->addField('cms_address_address_line_two', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Address Line 2:'),
      		'name'      => 'cms_address_address_line_two',
      ));
	  
	  $cms_address_fieldset->addField('cms_address_city', 'text', array(
      		'label'     => Mage::helper('evolved')->__('City:'),
      		'name'      => 'cms_address_city',
      ));
	  
	 $cms_address_fieldset->addField('cms_address_state', 'select', array(
      		'name'  => 'cms_address_state',
      		'label'     => 'Region/State',
      		'values' => $state,
      		//'values'    => Mage::getModel('evolved/evolved')->getstate('AU'),
      ));
	  
	  $cms_address_fieldset->addField('cms_address_zipcode', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Zip Code:'),
      		'name'      => 'cms_address_zipcode',
      ));
      
      $cms_address_fieldset->addField('cms_address_phone_no', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Phone number:'),
      		'name'      => 'cms_address_phone_no',
      ));
      
      $cms_address_fieldset->addField('cms_address_email', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Email Address:'),
      		'name'      => 'cms_address_email',
      ));*/
      
      $fieldsetCSS = $form->addFieldset('evolved_form_general_css', array('legend'=>Mage::helper('evolved')->__('General CSS')));
      $fieldsetCSS->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
     
      $fieldsetCSS->addField('general_main_color', 'colorpicker', array(
          'label'     => Mage::helper('evolved')->__('Main Background Color:'),
          //'class'     => 'color {hash:true}', // for default magento color picker
          'required'  => false,
          'name'      => 'general_main_color',
      	  'note' => Mage::helper('evolved')->__('This is main theme color'),
      ));
      
      
      /*$fieldsetCSS->addField('general_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Title Color:'),
      		'required'  => false,
      		'name'      => 'general_title_color',
      ));
      
      $fieldsetCSS->addField('general_price_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Price Color:'),
      		'required'  => false,
      		'name'      => 'general_price_color',
      ));
      
      $fieldsetCSS->addField('general_oldprice_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Old Price Color:'),
      		'required'  => false,
      		'name'      => 'general_oldprice_color',
      ));
      
      $fieldsetCSS->addField('general_pricetext_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Price Text Color:'),
      		'required'  => false,
      		'name'      => 'general_pricetext_color',
      		'note' => Mage::helper('evolved')->__('Text in price block (As low, From, To)'),
      ));
      
      $fieldsetCSS->addField('general_newproductprice_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('New products price color:'),
      		'required'  => false,
      		'name'      => 'general_newproductprice_color',
      		'note' => Mage::helper('evolved')->__('Also used as product label background'),
      ));
      
      $fieldsetCSS->addField('general_onsaleprice_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('On Sale products price color:'),
      		'required'  => false,
      		'name'      => 'general_onsaleprice_color',
      		'note' => Mage::helper('evolved')->__('Also used as product label background'),
      )); */
      
      $fieldsetgoogleapp = $form->addFieldset('evolved_form_general_googleapps', array('legend'=>Mage::helper('evolved')->__('Google Apps Setting')));
      $fieldsetgoogleapp->addField('general_googleapps_username', 'text', array(
      		'label'     => Mage::helper('evolved')->__('User Name:'),
      		//'class'     => 'color {hash:true}', // for default magento color picker
      		'name'      => 'general_googleapps_username',
      ));
      
      $fieldsetgoogleapp->addField('general_googleapps_password', 'password', array(
      		'label'     => Mage::helper('evolved')->__('Password:'),
      		//'class'     => 'color {hash:true}', // for default magento color picker
      		'name'      => 'general_googleapps_password',
      ));
      
      Mage::getSingleton('core/session')->setBlockName('evolved_general');
      if ( Mage::getSingleton('adminhtml/session')->getEvolvedData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEvolvedData());
          Mage::getSingleton('adminhtml/session')->setEvolvedData(null);
      } elseif ( Mage::registry('evolved_data') ) {
          $form->setValues(Mage::registry('evolved_data'));
      }
      return parent::_prepareForm();
  }
}