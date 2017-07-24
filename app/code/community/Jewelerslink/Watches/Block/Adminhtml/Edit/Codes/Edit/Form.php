<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    
 * @package     _storage
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Attribute map edit form container block
 *
 * @category    Jewelerslink
 * @package     Jewelerslink_Watches
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Jewelerslink_Watches_Block_Adminhtml_Edit_Codes_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Import codes list
     *
     * @return array
     */
    protected function _getImportCodeList()
    {
        /* $attributes = Mage::getConfig()->getNode(Jewelerslink_Watches_Model_Import::XML_NODE_FIND_FEED_ATTRIBUTES)->children();
        $result     = array();
        foreach ($attributes as $node) {
            $label = trim((string)$node->label);
            if ($label) {
                $result[$label] = $label;
            }
        }
        return $result; */
    	
    	try
    	{
    		//$username = Mage::getStoreConfig('watches/user_detail/ideal_username');
    		//$password = Mage::getStoreConfig('watches/user_detail/ideal_password');
    	
    		$ch = curl_init();
    		$timeout = 5;
    		curl_setopt($ch,CURLOPT_URL,"http://www.jewelerslink.com/watch/index/getcolumnnames");
    		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    		//curl_setopt($ch, CURLOPT_POSTFIELDS, array("username"=>$username,"password"=>$password));
    		$data = curl_exec($ch);
    		curl_close($ch);
    		//echo $data;

    		$jsonData = json_decode($data, true);
    		
    		$result     = array();
    		foreach($jsonData as $field) {
    			$result[$field] = $field;
    		}
    		return $result;
    	}
    	catch (Exception $e) {
    		Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
    		return;
    	}
    }

    /**
     * Magento entity type list for eav attributes
     *
     * @return array
     */
    protected function _getCatalogEntityType()
    {
        return Mage::getSingleton('eav/config')->getEntityType('catalog_product')->getId();
    }


    /**
     * Magento eav attributes list
     *
     * @return array
     */
    protected function _getEavAttributeList()
    {
        $result     = array();
        $collection = Mage::getResourceModel('catalog/product_attribute_collection');
        foreach ($collection as $model) {
            $result[$model->getAttributeCode()] = $model->getAttributeCode();
        }
        return $result;
    }

    /**
     * Prepare form
     *
     * @return Varien_Object
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'import_item_form',
            'method'    => 'post'
        ));

        $fieldset = $form->addFieldset('generate_fieldset', array(
            'legend' => Mage::helper('watches')->__('Item params')
        ));
        $fieldset->addField('import_code', 'select', array(
            'label'     => Mage::helper('watches')->__('JewelersLink Code'),
            'name'      => 'import_code',
            'required'  => true,
            'options'   => $this->_getImportCodeList()
        ));
        $fieldset->addField('eav_code', 'select', array(
            'label'     => Mage::helper('watches')->__('Site attribute code'),
            'name'      => 'eav_code',
            'required'  => true,
            'options'   => $this->_getEavAttributeList()
        ));

        $source = Mage::getModel('eav/entity_attribute_source_boolean');
        $isImportedOptions = $source->getOptionArray();

        $fieldset->addField('watch_imported', 'select', array(
            'label'     => Mage::helper('watches')->__('Is imported'),
            'name'      => 'watch_imported',
            'value'     => 1,
            'options'   => $isImportedOptions
        ));
        
        $fieldset->addField('use_in_update', 'select', array(
        		'label'     => Mage::helper('watches')->__('Use In Update Product'),
        		'name'      => 'use_in_update',
        		'options'   => $isImportedOptions
        ));        
        
        $form->setUseContainer(true);


        if ( Mage::getSingleton('adminhtml/session')->getWatchesCodesData() )
        {
        	$form->setValues(Mage::getSingleton('adminhtml/session')->getWatchesCodesData());
        	Mage::getSingleton('adminhtml/session')->setWatchesCodesData(null);
        } elseif ( Mage::registry('watches_codes_data') ) {
        	$form->setValues(Mage::registry('watches_codes_data')->getData());
        }
        
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
}
