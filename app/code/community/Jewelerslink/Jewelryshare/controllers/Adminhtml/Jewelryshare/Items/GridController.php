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
 * TheJewelerslink jewelryshare product grid controller
 *
 * @category    Jewelerslink
 * @package     Jewelerslink_Jewelryshare
 */
class Jewelerslink_Jewelryshare_Adminhtml_Jewelryshare_Items_GridController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Main index action
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Grid action
     */
    public function gridAction()
    {
        $this->loadLayout();    
        $this->getResponse()->setBody($this->getLayout()->createBlock('jewelryshare/adminhtml_list_items_grid')->toHtml());
    }
    
    /**
     * Product list for mass action
     *
     * @return array
     */
    protected function _getMassActionProducts()
    {
        $idList = $this->getRequest()->getParam('item_id');
        if (!empty($idList)) {   
            $products = array();
            foreach ($idList as $id) {
                $model = Mage::getModel('catalog/product');
                if ($model->load($id)) {
                    array_push($products, $model);
                }
            }
            return $products;
        } else {
            return array();
        }
    }

    /**
     * Add product to jewelryshare mass action
     */
    public function massEnableAction()
    {
        $idList = $this->getRequest()->getParam('item_id');
        $updateAction = Mage::getModel('catalog/product_action');
        $attrData = array(
            'jewelry_imported' => 1
        );
        $updatedProducts = count($idList);
        if ($updatedProducts) {
            try {
                $updateAction->updateAttributes($idList, $attrData, Mage::app()->getStore()->getId());
                //Mage::getModel('jewelerslink_jewelryshare/import')->processImport();
                $this->_getSession()->addSuccess(Mage::helper('jewelryshare')->__("%s product will be exported in jewelerslink.", $updatedProducts));
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('jewelryshare')->__("Unable to process an export. ") . $e->getMessage());
            } 
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Not add product to jewelryshare mass action
     */
    public function massDisableAction()
    {
        /*$updatedProducts = 0;
        foreach ($this->_getMassActionProducts() as $product) {
            $product->setIsImported(0);
            $product->save();
            $updatedProducts++;
        }*/
    	$idList = $this->getRequest()->getParam('item_id');
    	$updateAction = Mage::getModel('catalog/product_action');
    	$attrData = array(
    			'jewelry_imported' => 0
    	);
    	$updatedProducts = count($idList);
    	
        if ($updatedProducts) {
        	
        	try {
                $updateAction->updateAttributes($idList, $attrData, Mage::app()->getStore()->getId());
                //Mage::getModel('jewelerslink_jewelryshare/import')->processImport();
                $this->_getSession()->addSuccess(Mage::helper('jewelryshare')->__("%s product(s) will not be exported in jewelerslink.", $updatedProducts));
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('jewelryshare')->__("Unable to process an export. ") . $e->getMessage());
            }
             
        } 
        $this->_redirect('*/*/index');
    }
    
    /**
     * Export products to jewelerslink mass action
     */
    public function massJwExportAction()
    {
    	$idList = $this->getRequest()->getParam('item_id');
    	$updateAction = Mage::getModel('catalog/product_action');
    	$attrData = array(
    			'jewelry_imported' => 1
    	);
    	$updatedProducts = count($idList);

    	if ($updatedProducts) {
    		try {
    			$updateAction->updateAttributes($idList, $attrData, Mage::app()->getStore()->getId());
    			Mage::getModel('jewelerslink_jewelryshare/import')->processImport();
    			$this->_getSession()->addSuccess(Mage::helper('jewelryshare')->__("%s product in jewelerslink.", $updatedProducts));
    		} catch (Exception $e) {
    			$this->_getSession()->addError(Mage::helper('jewelryshare')->__("Unable to process an import. ") . $e->getMessage());
    		}
    	}
    	$this->_redirect('*/*/index');
    }
   
    protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('jewelryshare/jewelery/jewelryshare_export');
    }
    
}
