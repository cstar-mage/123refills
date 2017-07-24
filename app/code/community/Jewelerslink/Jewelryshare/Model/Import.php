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
 * TheJewelerslink jewelryshare import model
 *
 * @category    Jewelerslink
 * @package     Jewelerslink_Jewelryshare
 */
class Jewelerslink_Jewelryshare_Model_Import extends Mage_Core_Model_Abstract
{
    //const SEPARATOR = "\t";
    const LINE_END  = "\r\n";
    const ENCLOSURE = '"';
    const SEPARATOR = ',';
    const COLLECTION_PAGE_SIZE = 5000;

    const XML_PATH_SETTINGS_FTP_SERVER           = 'jewelryshare/settings/ftp_server';
    const XML_PATH_SETTINGS_FTP_USER             = 'jewelryshare/settings/ftp_user';
    const XML_PATH_SETTINGS_FTP_PASSWORD         = 'jewelryshare/settings/ftp_password';
    //const XML_PATH_SETTINGS_FTP_PATH             = 'jewelryshare/settings/ftp_path';
    //const XML_PATH_SETTINGS_FINDFEED_FILENAME    = 'jewelryshare/settings/jewelerslinkjewelryshare_filename';
    const XML_NODE_FIND_FEED_ATTRIBUTES = 'jewelerslink_jewelryshare_attributes';
    
    const MULTI_DELIMITER = ' , ';
    const OPS = ":";
    const OPVS = "|";
    const OPVPS = ":";

    /**
     * Attribute sources
     *
     * @var array
     */
    protected $_attributeSources = array();

    /**
     * Cron action
     */
    public function dispatch()
    {
        $this->processImport();
    }

    /**
     * TheJewelerslink jewelryshare process import
     */
    public function processImport()
    {
        $file = $this->_createFile();
        if ($file) {
            //$this->_deleteFtpFiles();
            $this->_sendFile($file);
            if (!$this->_deleteFile($file)) {
                Mage::throwException(Mage::helper('jewelryshare')->__("FTP: Can't delete files"));
            }
        }
    }

    /**
     * Create temp csv file and write export
     *
     * @return mixed
     */
    protected function _createFile()
    {
    	
    	
        $dir      = $this->_getTmpDir();
        $customerId = $this->getJwCustomerId();
        
        $fileName = $customerId.".csv";
        
        if (!$dir || !$customerId) {
            return false;
        } 
        //echo count($this->_getImportAttributes());exit;
        
        if (!($attributes = $this->_getImportAttributes()) || count($attributes) <= 0) {
            return false;
        }
        //echo "<pre>"; print_r($attributes); exit;
        
        $headers = array_keys($attributes);

        $file = new Varien_Io_File;
        $file->checkAndCreateFolder($dir);
        $file->cd($dir);
        $file->streamOpen($fileName, 'w+');
        $file->streamLock();
        
        $fixedHeaders = array ('status','is_in_stock','qty');
        $headers = array_merge($fixedHeaders,$headers);
        $headers[] = 'custom_options';
        //echo "<pre>"; print_r($headers); exit;
        
        $file->streamWriteCsv($headers, self::SEPARATOR, self::ENCLOSURE);

        $productCollectionPrototype = Mage::getResourceModel('catalog/product_collection');
        $productCollectionPrototype->setPageSize(self::COLLECTION_PAGE_SIZE);
        $pageNumbers = $productCollectionPrototype->getLastPageNumber();
        unset($productCollectionPrototype);

        for ($i = 1; $i <= $pageNumbers; $i++) {
            $productCollection = Mage::getResourceModel('catalog/product_collection');
            $productCollection->addAttributeToSelect($attributes);
            $productCollection->addAttributeToFilter('jewelry_imported', 1);
            $productCollection->setPageSize(self::COLLECTION_PAGE_SIZE);
            $productCollection->setCurPage($i)->load();
            //echo "<pre>"; print_r($productCollection->getData()); exit;
            
            foreach ($productCollection as $product) {
                $attributesRow = array();
                
                $_product = Mage::getModel('catalog/product')->load($product->getId());
                //$fixedAttributes = array('status'=>'status','is_in_stock'=>'is_in_stock','qty'=>'qty');
                $attributesRow['status'] = $_product->getAttributeText('status');
                
                $isInStock = $_product->getStockItem()->getIsInStock();
                $attributesRow['is_in_stock'] = $isInStock;
                
                $qty = $_product->getStockItem()->getQty();
                $attributesRow['qty'] = $qty;
                
                foreach ($attributes as $key => $value) {

                    if ($this->_checkAttributeSource($product, $value)) {
                        if (is_array($product->getAttributeText($value))) {
                            $attributesRow[$key] = implode(', ', $product->getAttributeText($value));
                        } else {
                            $attributesRow[$key] = $product->getAttributeText($value);
                        }
                    } else {

                   	 	if($key == 'image' || $key == 'small_image' || $key == 'thumbnail') {
                    		$siteUrl = str_replace("/index.php/","",Mage::getBaseUrl());                    		
                    		$imageUrl = $siteUrl."/media/catalog/product/";
                    		
                    		if((!$product->getData($value)) && $product->getData($value) == "") {
                    			$attributesRow[$key] = "";
                    		} else {
                    			$attributesRow[$key] = $imageUrl.$product->getData($value);
                    		}
                    	} else if($key == 'gallery') {
                    		$_product = Mage::getModel('catalog/product')->load($product->getId());
                    		$galleryArray = array();
                    		$galleryString = "";
                    		if($gallery = $_product->getMediaGalleryImages()) {
                    			//echo "<pre>"; print_r($gallery);exit;
                    			foreach ($gallery as $image) {
                    				$exlode = explode("media/catalog/product",$image->getUrl());
                    				$galleryPart = $exlode[1];
                    				//echo $galleryPart."==".$_product->getImage(); exit;
                    				if($galleryPart == $_product->getImage() || $galleryPart == $_product->getSmallImage() || $galleryPart == $_product->getThumbnail()) {
                    					continue;
                    				}
                    				if($image->getUrl() && $image->getUrl() != "") {
                    					$galleryArray[] = $image->getUrl();
                    				}
                    			}
                    			$galleryString = implode(";",$galleryArray);
                    		}
                    		$attributesRow[$key] = $galleryString;
                    	} else {
                        	$attributesRow[$key] = $product->getData($value);
                    	}
                    }
                }
                
                //echo "<pre>"; print_r($attributesRow); //exit;
                $customOptions = array();
	            $opt = Mage::getModel('catalog/product_option');
	            $optCollection = $opt->getProductOptionCollection($_product);
	            
	            foreach($optCollection as $poption){
	            	$collection = Mage::getModel('catalog/product_option_value');
	            	$collection = $collection->getValuesCollection($poption);
	            	
	            	$valueString = "";
	            	
	            	foreach($collection->getItems() as $item){
	            		$valueString .= $item->getStoreTitle().self::OPVPS.$item->getStorePriceType().self::OPVPS.$item->getStorePrice();
	            		if($item->getSku() != ""){
	            			$valueString .= self::OPVPS.$item->getSku();
	            		}
	            		$valueString .= self::OPVS;
	            	}
	            	$customOptions['custom_options'][$poption->getTitle().self::OPS.$poption->getType().self::OPS.$poption->getIsRequire()] = $valueString;
	            }
	            //echo "<pre>"; print_r($customOptions); exit;
	            $customOptionsJson = "";
	            if(count($customOptions['custom_options']) > 0) {
	            	$customOptionsJson = json_encode($customOptions);
	            }
                //echo $customOptionsJson; exit;
	            $attributesRow['custom_options'] = $customOptionsJson;
	            
                $file->streamWriteCsv($attributesRow, self::SEPARATOR, self::ENCLOSURE);
            }
            unset($productCollection);
        }
		//exit;
        $file->streamUnlock();
        $file->streamClose();

        if ($file->fileExists($fileName)) {
            return $fileName;
        }
        return false;
    }

    /**
     * Check attribute source
     *
     * @param Mage_Catalog_Model_Product $product
     * @param string $value
     * @return bool
     */
    protected function _checkAttributeSource($product, $value)
    {
        if (!array_key_exists($value, $this->_attributeSources)) {
            $this->_attributeSources[$value] = $product->getResource()->getAttribute($value)->usesSource();
        }
        return $this->_attributeSources[$value];
    }

    /**
     * List import codes (attribute map) model
     *
     * @return mixed
     */
    protected function _getImportAttributes()
    {
        $attributes = Mage::getResourceModel('jewelerslink_jewelryshare/codes_collection')
          ->getImportAttributes();

        if (!Mage::helper('jewelryshare')->checkRequired($attributes)) {
            return false;
        }
        return $attributes;
    }

    /**
     * Send file to remote ftp server
     *
     * @param string $fileName
     */
    protected function _sendFile($fileName)
    {
        $dir         = $this->_getTmpDir();
        $ftpServer   = Mage::getStoreConfig(self::XML_PATH_SETTINGS_FTP_SERVER);
        $ftpUserName = Mage::getStoreConfig(self::XML_PATH_SETTINGS_FTP_USER);
        $ftpPass     = Mage::getStoreConfig(self::XML_PATH_SETTINGS_FTP_PASSWORD);

        $ftpPath = '/';
        // set up basic connection
        $conn_id = ftp_connect($ftpServer);
        
        // login with username and password
        $login_result = ftp_login($conn_id, $ftpUserName, $ftpPass);        
        //echo $login_result."==".$conn_id."==".$ftpPath.$fileName."==".$dir.$fileName; exit;
        ftp_pasv($conn_id, true);
        
        if(ftp_put($conn_id, $ftpPath.$fileName, $dir.$fileName, FTP_BINARY)) {
        	Mage::getSingleton("adminhtml/session")->addSuccess("csv exported to jewelerslink successfully.");
        	//echo "csv exported to jewelerslink successfully.";
        } else {
        	Mage::getSingleton("adminhtml/session")->addError("There was a problem exporting csv to jewelerslink.");
        	//echo "There was a problem exporting csv to jewelerslink.";
        }
        // close the connection
        ftp_close($conn_id);
    }

    /**
     * Delete all files in current jewelryshare ftp directory
     *
     * @return bool
     */
    protected function _deleteFtpFiles()
    {
        if (is_callable('ftp_connect')) {
        	
            $ftpServer   = Mage::getStoreConfig(self::XML_PATH_SETTINGS_FTP_SERVER);
            $ftpUserName = Mage::getStoreConfig(self::XML_PATH_SETTINGS_FTP_USER);
            $ftpPass     = Mage::getStoreConfig(self::XML_PATH_SETTINGS_FTP_PASSWORD);

            $ftpPath = '/';

            try {
                $connId = ftp_connect($ftpServer);

                $loginResult = ftp_login($connId, $ftpUserName, $ftpPass);
                //echo $loginResult; exit;
                
                if (!$loginResult) {
                    return false;
                }
                ftp_pasv($connId, true);

                $ftpDir = $ftpPath?$ftpPath:'.';
                $nlist = ftp_nlist($connId, $ftpDir);
                if ($nlist === false) {
                    return false;
                }
                //echo "<pre>"; print_r($nlist); exit;
                
                foreach ($nlist as $file) {
                    if (!preg_match('/\.[xX][mM][lL]$/', $file)) {
                    	
                    	if($file != '/..' && $file != '/.') {
                        	ftp_delete($connId, $file);
                    	}
                    	
                    }
                }

                ftp_close($connId);
            } catch (Exception $e) {
                Mage::log($e->getMessage());
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Current tmp directory
     *
     * @return string
     */
    protected function _getTmpDir()
    {
        return Mage::getBaseDir('var') . DS . 'export' . DS . 'jewelryshare' . DS;
    }

    /**
     * Delete tmp file
     *
     * @param string $fileName
     * @return true
     */
    protected function _deleteFile($fileName)
    {
        $dir  = $this->_getTmpDir();
        $file = new Varien_Io_File;
        if ($file->fileExists($dir . $fileName, true)) {
            $file->cd($dir);
            $file->rm($fileName);
        }
        return true;
    }
    
    public function getJwCustomerId()
    {
    	try
    	{
    		$username = Mage::getStoreConfig('jewelryshare/user_detail/ideal_username');
    		$password = Mage::getStoreConfig('jewelryshare/user_detail/ideal_password');
    
    		$ch = curl_init();
    		$timeout = 5;
    		curl_setopt($ch,CURLOPT_URL,"http://www.jewelerslink.com/jewelry/index/getjwId");
    		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, array("username"=>$username,"password"=>$password));
    		$data = curl_exec($ch);
    		curl_close($ch);
    		//echo $data;
    		if($data == "Invalid Login") {
    			//echo "Unauthenticate Login, Go to ( System > Configuration > Jewelry Config ) and enter Jewelerslink Login Detail";
    			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Unauthenticate Login, Go to ( System > Configuration > Jewelry Config ) and enter Jewelerslink Login Detail"));
    			return;
    		} else {
    			//echo $data; exit;
    			return $data;
    		}
    	}
    	catch (Exception $e) {
    		Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
    		return;
    	}
    }
}