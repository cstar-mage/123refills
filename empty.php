<?php
require_once 'app/Mage.php';
umask(0);
Mage::app();
Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);

$code = $_GET['code'];

        $attribute  = Mage::getModel('catalog/resource_eav_attribute')
          ->loadByCode(Mage_Catalog_Model_Product::ENTITY, $code);

        $optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setAttributeFilter($attribute->getAttributeId())
            ->setPositionOrder('desc', true)
            ->load();
        foreach($optionCollection as $option){
            //remove if options value is empty
            if ($option->getValue()=='') {
            	echo $option->getId();
                $option->delete();
            }
        }
    
