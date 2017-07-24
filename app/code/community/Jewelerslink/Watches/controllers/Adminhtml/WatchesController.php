<?php

class Jewelerslink_Watches_Adminhtml_WatchesController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('watches/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('watches/watches')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('watches_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('watches/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('watches/adminhtml_watches_edit'))
				->_addLeft($this->getLayout()->createBlock('watches/adminhtml_watches_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('watches')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	
	public function importFormAction() {
		
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register('watches_data', $model);

		$this->loadLayout();
		$this->_setActiveMenu('watches/items');

		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

		$this->_addContent($this->getLayout()->createBlock('watches/adminhtml_watches_edit'))
		->_addLeft($this->getLayout()->createBlock('watches/adminhtml_watches_edit_tabs'));

		$this->renderLayout();
		
	}
	
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		try
		{
			$resource = Mage::getConfig()->getNode('global/resources')->asArray();
			$magento_db = $resource['default_setup']['connection']['host'];
			$mdb_user = $resource['default_setup']['connection']['username'];
			$mdb_passwd = $resource['default_setup']['connection']['password'];
			$mdb_name = $resource['default_setup']['connection']['dbname'];
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
		
			if (!$magento_connection)
			{
				die('Unable to connect to the database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
		
			$priceTable = Mage::getSingleton('core/resource')->getTableName('watches_priceincrease');
			mysql_query("TRUNCATE TABLE $priceTable");
		
			for($i = 1; $i<1000; $i++)
			{
				if(isset($_REQUEST['multiline_0-'.$i]) && ($_REQUEST['multiline_0-'.$i] != '')) {
					$price_from_0 = $_REQUEST['multiline_0-'.$i];
					$price_to_1 = $_REQUEST['multiline_1-'.$i];
					$price_increase_percent = $_REQUEST['multiline_2-'.$i];
					$price_increase_2 = $_REQUEST['multiline_2-'.$i]/100;
					$price_to_increase_3 = 	1 + $price_increase_2;
						
					$query_insert_1 = "INSERT INTO $priceTable SET price_from = ".$price_from_0.", price_to = ".$price_to_1.", price_increase = ".$price_increase_percent;
					mysql_query($query_insert_1) or die(mysql_error());
				}
			}
				
			$vendorTable = Mage::getSingleton('core/resource')->getTableName('watches_vendor');
			mysql_query("TRUNCATE TABLE $vendorTable");
				
			for($j = 0; $j<1000; $j++)
			{
				if(isset($_REQUEST['vendor_1-'.$j]) && ($_REQUEST['vendor_1-'.$j] != '')) {
					$vendor_name = $_REQUEST['vendor_1-'.$j];
					$vendor_id = $_REQUEST['vendor_2-'.$j];
					$query_insert = "INSERT INTO $vendorTable SET vendor_name = '".$vendor_name."', vendor_id = '".$vendor_id."'";
					mysql_query($query_insert) or die(mysql_error());
				}
			}
		
			Mage::getSingleton("adminhtml/session")->addSuccess("Rules Saved.");
			$this->_redirect("*/*/importForm");
			return;
		}
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/importForm");
			return;
		}
			
	}
	
	public function deleteDir($dirPath) {
	
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}
	
	public function getJwCustomerId() {
		try
		{
			$username = Mage::getStoreConfig('watches/user_detail/ideal_username');
			$password = Mage::getStoreConfig('watches/user_detail/ideal_password');
	
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_URL,"http://www.jewelerslink.com/watch/index/getjwId");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array("username"=>$username,"password"=>$password));
			$data = curl_exec($ch);
			curl_close($ch);
			//echo $data;
	
			if($data == "Invalid Login") {
				Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Unauthenticate Login, Go to ( System > Configuration > Watches Config ) and enter Jewelerslink Login Detail"));
				$this->_redirect("*/*/importForm");
				return;
	
			} else {
				//echo $data; exit;
				return $data;
			}
	
		}
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/importForm");
			return;
		}
	}
	
	/**
	 * List import codes (attribute map) model
	 *
	 * @return mixed
	 */
	protected function _getImportAttributes()
	{
		$attributes = Mage::getResourceModel('jewelerslink_watches/codes_collection')->getImportAttributes();
		return $attributes;
	}
	
	protected function _getUpdateAttributes()
	{
		$attributes = Mage::getResourceModel('jewelerslink_watches/codes_collection')->getUpdateAttributes();
		return $attributes;
	}
	
	public function getImportCSVAction() {
		
		$importCSV = Mage::helper('watches')->getImportCSV();
		if($importCSV['success'] == 0) {
			Mage::getSingleton("adminhtml/session")->addError($importCSV['message']);
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($importCSV['message']);
		}
		$this->_redirect("*/*/importForm");
		return;
		
	}
	
	public function getUpdateCSVAction() {
		
		$updateCSV = Mage::helper('watches')->getUpdateCSV();
		if($updateCSV['success'] == 0) {
			Mage::getSingleton("adminhtml/session")->addError($updateCSV['message']);
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($updateCSV['message']);
		}
		$this->_redirect("*/*/importForm");
		return;
		
	}
	
	public function getImagesAction() {
	
		$getImages = Mage::helper('watches')->getImages();
		if($getImages['success'] == 0) {
			Mage::getSingleton("adminhtml/session")->addError($getImages['message']);
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($getImages['message']);
		}
		$this->_redirect("*/*/importForm");
		return;
		
	}
	
	public function importWatchesAction() {
	
		$url = $this->getUrl("*idealAdmin/system_convert_gui/run/", array("id" => 3, "files" => "watches_import.csv"));
		$url = str_replace("*idealAdmin","idealAdmin", $url);
		?>
		<script type="text/javascript">
			window.location = "<?php echo $url ?>";
		</script> 
		<?php
	}
		
	public function updateWatchesAction() {
		
		$url = $this->getUrl("*idealAdmin/system_convert_gui/run/", array("id" => 3, "files" => "watches_update.csv"));
		$url = str_replace("*idealAdmin","idealAdmin", $url);
		?>
		<script type="text/javascript">
			window.location = "<?php echo $url ?>";
		</script> 
		<?php
	}
		
	public function disableOlderAction() {
		try
		{
			$resource = Mage::getConfig()->getNode('global/resources')->asArray();
	        $magento_db = $resource['default_setup']['connection']['host'];
	        $mdb_user = $resource['default_setup']['connection']['username'];
	        $mdb_passwd = $resource['default_setup']['connection']['password'];
	        $mdb_name = $resource['default_setup']['connection']['dbname'];
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
	
			if (!$magento_connection)
			{
				die('Unable to connect to the database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
	
			$vendorTable = Mage::getSingleton('core/resource')->getTableName('watches_vendor');
			$select_vendor = 'select * from `'.$vendorTable.'`';
			$result = mysql_query($select_vendor);
			while($row = mysql_fetch_array($result))
			{
				$vendorArray[] = $row['vendor_name'];
			}
			$username = Mage::getStoreConfig('watches/user_detail/ideal_username');
			$password = Mage::getStoreConfig('watches/user_detail/ideal_password');
	
			$data_string = json_encode($vendorArray);
	
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_URL,"http://www.jewelerslink.com/watch/index/getUpdateJson");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array("username"=>$username,"password"=>$password,"vendors"=>$data_string));
			$data = curl_exec($ch);
			curl_close($ch);
			//echo $data; exit;
	
			if($data == "Invalid Login") {
	
				Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Unauthenticate Login, Go to ( System > Configuration > Watches Config ) and enter Jewelerslink Login Detail"));
				$this->_redirect("*/*/importForm");
				return;
	
			} else {
				//echo $data;
				$jsonData = json_decode($data, true);
				$jwlProducts = array();
				foreach($jsonData as $data) {
					if($data[2] != 'sku')
						$jwlProducts[] = $data[2];
				}
				//echo "<pre>"; print_r($jwlProducts);exit;
				
				$existingProducts = Mage::getModel('catalog/product')->getCollection();
				//$existingProducts->addAttributeToSelect('sku');

				$disable = 0; 
				foreach($existingProducts as $exists) {
					
					$sku = $exists->getSku();
					if(!in_array($sku, $jwlProducts)) {

						$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$sku);
						if($product) {
							$status = $product->getStatus();
							if($status != 2) {
								$product->setStatus(2);
								$product->save();
							}
						}
						$disable++;
					}
				}
				//echo $disable; exit;

				Mage::getSingleton("adminhtml/session")->addSuccess($disable." Products not in jewelrslink has been disabled.");
				$this->_redirect("*/*/importForm");
			}
	
		}
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/importForm");
			return;
		}
	}
	
	public function restorePriceIncreaseAction() {
	
		try
		{
			$resource = Mage::getConfig()->getNode('global/resources')->asArray();
	        $magento_db = $resource['default_setup']['connection']['host'];
	        $mdb_user = $resource['default_setup']['connection']['username'];
	        $mdb_passwd = $resource['default_setup']['connection']['password'];
	        $mdb_name = $resource['default_setup']['connection']['dbname'];
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
	
			if (!$magento_connection)
			{
				die('Unable to connect to the database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");

			$priceTable = Mage::getSingleton('core/resource')->getTableName('watches_priceincrease');
			mysql_query("TRUNCATE TABLE $priceTable");
				
			mysql_query("INSERT INTO $priceTable SET price_from = 100000.01, price_to = 10000000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 50000.01, price_to = 100000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 30000.01, price_to = 50000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 25000.01, price_to = 30000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 20000.01, price_to = 25000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 15000.01, price_to = 20000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 10000.01, price_to = 15000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 5000.01, price_to = 10000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 3500.01, price_to = 5000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 2000.01, price_to = 3500, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 1000.01, price_to = 2000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 500.01, price_to = 1000, price_increase = 0")or die(mysql_error());
			mysql_query("INSERT INTO $priceTable SET price_from = 1, price_to = 500, price_increase = 0")or die(mysql_error());
				
			Mage::getSingleton("adminhtml/session")->addSuccess("Price Increase Restored to default values.");
			$this->_redirect("*/*/importForm");
	
		}
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/importForm");
			return;
		}
	}
	
	public function getImagesActionOld() {  // Not Using this
		
		$vendors = $this->getvendorIdsAction();
		
		if(count($vendors)>0) {
			
			foreach($vendors as $vendorId) {
				
				//echo $vendorId; exit;
				
				$ftp_host = "images.jewelerslink.com";
				$ftp_username = "images@jewelerslink.com";
				$ftp_password = "jewelerslink123";
			
				// path to remote file
				$server_file = "/watch/".$vendorId."/".$vendorId.".zip";
				
				$localDir = getcwd()."/media/import/jewelerslink/".$vendorId."/";
				$local_file = $localDir.$vendorId.".zip";
				
				if (is_dir($localDir)) $this->deleteDir($localDir);
				if (!is_dir($localDir)) mkdir($localDir);
				
				// set up basic connection
				$conn_id = ftp_connect($ftp_host);
				// login with username and password
				$login_result = ftp_login($conn_id, $ftp_username, $ftp_password);
		
				// try to download $server_file and save to $local_file
				if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
					
					$zip = new ZipArchive();
					$x = $zip->open($local_file);
					if ($x === true) {
						$zip->extractTo($localDir); // change this to the correct site path
						$zip->close();
						unlink($local_file);
					}
				    Mage::getSingleton("adminhtml/session")->addSuccess("Images written successfully.");
				} else {
				    Mage::getSingleton("adminhtml/session")->addError("There was a problem getting images.");
				}
				// close the connection
				ftp_close($conn_id);
			}
			
		} else {
			Mage::getSingleton("adminhtml/session")->addError("No Vendors found.");
		}

	}
	
	public function getvendorIdsAction() { // Not Using this
	
		try
		{
			$resource = Mage::getConfig()->getNode('global/resources')->asArray();
	        $magento_db = $resource['default_setup']['connection']['host'];
	        $mdb_user = $resource['default_setup']['connection']['username'];
	        $mdb_passwd = $resource['default_setup']['connection']['password'];
	        $mdb_name = $resource['default_setup']['connection']['dbname'];
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
				
			if (!$magento_connection)
			{
				die('Unable to connect to the database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
				
			$vendorTable = Mage::getSingleton('core/resource')->getTableName('watches_vendor');
			$select_vendor = 'select * from `'.$vendorTable.'`';
			$result = mysql_query($select_vendor);
			while($row = mysql_fetch_array($result))
			{
				$vendorArray[] = $row['vendor_name'];
			}
			$username = Mage::getStoreConfig('watches/user_detail/ideal_username');
			$password = Mage::getStoreConfig('watches/user_detail/ideal_password');
				
			$data_string = json_encode($vendorArray);
			
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_URL,"http://www.jewelerslink.com/watch/index/getvendorIdsjson");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array("username"=>$username,"password"=>$password,"vendors"=>$data_string));
			$data = curl_exec($ch);
			curl_close($ch);
			//echo $data;
				
			if($data == "Invalid Login") {
	
				Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Unauthenticate Login, Go to ( System > Configuration > Watches Config ) and enter Jewelerslink Login Detail"));
				$this->_redirect("*/*/importForm");
				return;
	
			} else {
				
				$vendorData = json_decode($data, true);
				//echo "<pre>"; print_r($vendorData);exit;
				return $vendorData;
			}
				
		}
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/importForm");
			return;
		}
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('watches/watches');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $watchesIds = $this->getRequest()->getParam('watches');
        if(!is_array($watchesIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($watchesIds as $watchesId) {
                    $watches = Mage::getModel('watches/watches')->load($watchesId);
                    $watches->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($watchesIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $watchesIds = $this->getRequest()->getParam('watches');
        if(!is_array($watchesIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($watchesIds as $watchesId) {
                    $watches = Mage::getSingleton('watches/watches')
                        ->load($watchesId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($watchesIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'watches.csv';
        $content    = $this->getLayout()->createBlock('watches/adminhtml_watches_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'watches.xml';
        $content    = $this->getLayout()->createBlock('watches/adminhtml_watches_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
    protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('jewelryshare/watches/watches_import');
    }
}