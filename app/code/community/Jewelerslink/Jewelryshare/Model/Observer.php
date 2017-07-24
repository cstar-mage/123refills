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
 * TheJewelerslink jwshare main observer 
 *
 * @category    Jewelerslink
 * @package     Jewelerslink_Jewelryshare
 */
class Jewelerslink_Jewelryshare_Model_Observer
{
	
	const XML_PATH_JEWELRYSHARE_EXPORT_ENABLED = 'cronjobs/jewelryshare/enabled_export';
	const XML_PATH_JEWELRYSHARE_IMPORT_ENABLED = 'cronjobs/jewelryshare/enabled_import';
	const XML_PATH_JEWELRYSHARE_UPDATE_ENABLED = 'cronjobs/jewelryshare/enabled_update';
	
	public function jewelerslinkExport() {
	
		if (!Mage::getStoreConfigFlag(self::XML_PATH_JEWELRYSHARE_EXPORT_ENABLED)) {
			return;
		}
	
		ini_set('memory_limit','3G');
		ini_set('max_execution_time','18000');
		
		Mage::getModel('jewelerslink_jewelryshare/importcron')->processImport();
		return $this;
	}
	
	public function jewelerslinkJewelryImport() {
	
		if (!Mage::getStoreConfigFlag(self::XML_PATH_JEWELRYSHARE_IMPORT_ENABLED)) {
			return;
		}
		
		ini_set('memory_limit','3G');
		ini_set('max_execution_time','18000');
		
		$getImportCSV = Mage::helper('jewelryshare')->getImportCSV();
		$getImages = Mage::helper('jewelryshare')->getImages();
		$importProducts = Mage::helper('jewelryshare')->importProducts();
		
		echo $getImportCSV['message'];
		echo $getImages['message'];
		echo $importProducts['message'];
		
		return $this;
	}
	
	public function jewelerslinkJewelryUpdate() {
	
		if (!Mage::getStoreConfigFlag(self::XML_PATH_JEWELRYSHARE_UPDATE_ENABLED)) {
			return;
		}
		
		ini_set('memory_limit','3G');
		ini_set('max_execution_time','18000');
		
		$getUpdateCSV = Mage::helper('jewelryshare')->getUpdateCSV();
		$updateProducts = Mage::helper('jewelryshare')->updateProducts();
	
		echo $getUpdateCSV['message'];
		echo $updateProducts['message'];
	
		return $this;
	}
	
    /**
     * Save system config event 
     *
     * @param Varien_Object $observer
     */
    public function saveSystemConfig($observer)
    {
        $store = $observer->getStore();
        $website = $observer->getWebsite();
        $groups['settings']['fields']['cron_schedule']['value'] = $this->_getSchedule();

        Mage::getModel('adminhtml/config_data')
                ->setSection('jwshare')
                ->setWebsite($website)
                ->setStore($store)
                ->setGroups($groups)
                ->save();
    }

    /**
     * Transform system settings option to cron schedule string
     * 
     * @return string
     */
    protected function _getSchedule()
    {
        $data = Mage::app()->getRequest()->getPost('groups');

        $frequency = !empty($data['settings']['fields']['cron_frequency']['value'])?
                         $data['settings']['fields']['cron_frequency']['value']:
                         0;
        $hours     = !empty($data['settings']['fields']['cron_hours']['value'])?
                         $data['settings']['fields']['cron_hours']['value']:
                         0;
        
        $schedule = "0 $hours ";

        switch ($frequency) {
            case Jewelerslink_Jewelryshare_Model_Adminhtml_System_Source_Cron_Frequency::DAILY:
                $schedule .= "* * *"; 
                break;
            case Jewelerslink_Jewelryshare_Model_Adminhtml_System_Source_Cron_Frequency::WEEKLY:
                $schedule .= "* * 1"; 
                break;
            case Jewelerslink_Jewelryshare_Model_Adminhtml_System_Source_Cron_Frequency::MONTHLY:
                $schedule .= "1 * *"; 
                break;
            case Jewelerslink_Jewelryshare_Model_Adminhtml_System_Source_Cron_Frequency::EVERY_MINUTE:
                $schedule = "0-59 * * * *"; 
                break;
            default:
                $schedule .= "* */1 *"; 
                break;
        }

        return $schedule;
    }
}
