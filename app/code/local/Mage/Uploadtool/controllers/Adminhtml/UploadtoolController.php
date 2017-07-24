<?php
class Mage_Uploadtool_Adminhtml_UploadtoolController extends Mage_Adminhtml_Controller_action
{	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu("uploadtool/items")
			->_addBreadcrumb(Mage::helper("adminhtml")->__("Items Manager"), Mage::helper("adminhtml")->__("Item Manager"));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("uploadtool/uploadtool")->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register("uploadtool_data", $model);

			$this->loadLayout();
			$this->_setActiveMenu("jewelryshare/uploadtool");

			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item Manager"), Mage::helper("adminhtml")->__("Item Manager"));
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item News"), Mage::helper("adminhtml")->__("Item News"));

			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock("uploadtool/adminhtml_uploadtool_edit"))
				->_addLeft($this->getLayout()->createBlock("uploadtool/adminhtml_uploadtool_edit_tabs"));

			$this->renderLayout();
		} else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("uploadtool")->__("Item does not exist"));
			$this->_redirect("*/*/");
		}
	}
 
	public function newAction() {
		$this->_forward("edit");
	}
	
	public function searchstringAction() {
		$string=$this->getRequest()->getParam('string');
		//echo "AA";
		$resource = Mage::getConfig()->getNode('global/resources')->asArray();
		$magento_db = $resource['default_setup']['connection']['host'];
		$mdb_user = $resource['default_setup']['connection']['username'];
		$mdb_passwd = $resource['default_setup']['connection']['password'];
		$mdb_name = $resource['default_setup']['connection']['dbname'];
		
		//developm_magento
		$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
		if (!$magento_connection)
		{
			die('Unable to connect to the database');
		}
		@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
		
		$table = Mage::getSingleton('core/resource')->getTableName('uploadtool_diamonds_inventory');
		$query = "SELECT * FROM `$table` where lotno like '".$string."%'" ;
		
		
		//echo $query ;
		
		$result = @mysql_db_query($mdb_name, $query) or die("Failed Query of ".$query);
		
	 
		
		$num_rows = @mysql_num_rows($result);
		if($num_rows > 0)
		{	
			echo "<table cellspacing='3' cellpadding='3' style='width:100%'>";
			//echo
			echo "<tr><th>STOCK #</th><th>OWNER</th><th>SHAPE</th><th>CARAT</th><th>PRICE</th><th>COLOR</th><th>CLARITY</th>
			<th>CUT</th><th>FLUOR</th><th>CERTIFICATE</th></tr>";
			//echo "";
			while($row = mysql_fetch_array($result))
			{
				echo "<tr><td>".$row['lotno']."</td><td>".$row['owner']."</td><td>".$row['shape']."</td>
				<td>".$row['carat']."</td><td>".$row['totalprice']."</td><td>".$row['color']."</td><td>".$row['clarity']."</td><td>".$row['cut']."</td>
				<td>".$row['fluorescence']."</td><td>".$row['certificate']."</td></tr>";
			}
			//echo ""; 
			echo "</table>";
			//return $row;
			//print_r($owner);
		}
		else
		{
			echo "<b>No Data Found </b>"; 
		}		
		
	}
	
	public function settingsAction() {
		
		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}
		
		Mage::register("uploadtool_settings_data", $model);
		
		$this->loadLayout();
		$this->_setActiveMenu("jewelryshare/settings");
		
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Jewelerslink Settings"), Mage::helper("adminhtml")->__("Jewelerslink Settings"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Jewelerslink Settings"), Mage::helper("adminhtml")->__("Jewelerslink Settings"));
		
		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
		
		$this->_addContent($this->getLayout()->createBlock("uploadtool/adminhtml_uploadtool_settings"))
		->_addLeft($this->getLayout()->createBlock("uploadtool/adminhtml_uploadtool_settings_tabs"));
		
		$this->renderLayout();
		
	}
 
	public function saveSettings() {
		
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
		
		$uploadtool_settings = Mage::getSingleton("core/resource")->getTableName('uploadtool_settings');
		
		if(isset($_REQUEST['settings']) && $_REQUEST['settings'] != "") {
			$settings = $_REQUEST['settings'];
			//echo "<pre>"; print_r($settings); exit;
			
			foreach($settings as $field => $value){
				$select = mysql_query("select * from `$uploadtool_settings` where `field` = '".$field."'") or die(mysql_error());
				if(mysql_num_rows($select) == 0) {
					mysql_query("insert into `$uploadtool_settings` set `field` = '".$field."', `value` = '".$value."'") or die(mysql_error());
				} else {
					mysql_query("update `$uploadtool_settings` set `value` = '".$value."' where `field` = '".$field."'") or die(mysql_error());
				}
			}
			
			$config = new Mage_Core_Model_Config();
			if(isset($settings['jewelerslink_username']) && $settings['jewelerslink_username'] != "") {
				$config->saveConfig('jewelryshare/user_detail/ideal_username', $settings['jewelerslink_username'] , 'default', 0);
				$config->saveConfig('uploadtool/user_detail/ideal_username', $settings['jewelerslink_username'] , 'default', 0);
			}
			
			if(isset($settings['jewelerslink_password']) && $settings['jewelerslink_password'] != "") {
				$config->saveConfig('jewelryshare/user_detail/ideal_password', $settings['jewelerslink_password'] , 'default', 0);
				$config->saveConfig('uploadtool/user_detail/ideal_password', $settings['jewelerslink_password'] , 'default', 0);
			}
			
			if(isset($settings['rapnet_username']) && $settings['rapnet_username'] != "") {
				$config->saveConfig('jewelryshare/user_detail/rapnet_username', $settings['rapnet_username'] , 'default', 0);
				$config->saveConfig('uploadtool/user_detail/rapnet_username', $settings['rapnet_username'] , 'default', 0);
			}
				
			if(isset($settings['rapnet_password']) && $settings['rapnet_password'] != "") {
				$config->saveConfig('jewelryshare/user_detail/rapnet_password', $settings['rapnet_password'] , 'default', 0);
				$config->saveConfig('uploadtool/user_detail/rapnet_password', $settings['rapnet_password'] , 'default', 0);
			}
			
		}
		
	}
	
	public function saveAction() {

		Mage::getSingleton('core/session', array('name'=>'adminhtml'));
		
		if(!Mage::getSingleton('admin/session')->isLoggedIn()){
			$this->_redirect("*/*/new");
			return;
		}
		
		try
		{
			if(isset($_REQUEST['jewelerslink_settings'])) {
				$this->saveSettings();
				Mage::getSingleton("adminhtml/session")->addSuccess("Settings Saved.");
				$this->_redirect("*/*/settings");
				return;
			}
			
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

			$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');
			$uploadtool_price_increase = Mage::getSingleton("core/resource")->getTableName('uploadtool_price_increase');
			$uploadtool_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_vendor');
			$uploadtool_custom_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_custom_vendor');
			$uploadtool_settings = Mage::getSingleton("core/resource")->getTableName('uploadtool_settings');
			
			
			//Add price increase for all vendor tabs 
			if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_rapnet')) {
				Mage::helper('uploadtool')->add_column_if_not_exist($uploadtool_price_increase, "price_increase_rapnet", "VARCHAR( 255 ) NULL DEFAULT '0'" );
			}
			
			if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_polygon')) {
				Mage::helper('uploadtool')->add_column_if_not_exist($uploadtool_price_increase, "price_increase_polygon", "VARCHAR( 255 ) NULL DEFAULT '0'" );
			}
			
			if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_custom')) {
				
				mysql_query("TRUNCATE TABLE `$uploadtool_custom_vendor`");
				
				for($k = 0; $k<1000; $k++) {
					if(isset($_REQUEST['custom_vendor_1-'.$k]) && ($_REQUEST['custom_vendor_1-'.$k] != '')) {
						$custom_vendor_name = $_REQUEST['custom_vendor_1-'.$k];
							
						$custom_vendor_name = str_replace(" ","_",$custom_vendor_name);
						
						$query_insert = "INSERT INTO `$uploadtool_custom_vendor` SET custom_vendor_name = '".$custom_vendor_name."'";
						mysql_query($query_insert) or die(mysql_error());
						
						Mage::helper('uploadtool')->add_column_if_not_exist($uploadtool_price_increase, "price_increase_".$custom_vendor_name, "VARCHAR( 255 ) NULL DEFAULT '0'" );
					}
				}
				
				if(isset($_FILES['custom_uploads']['name']) && count($_FILES['custom_uploads']['name']) > 0) {
	
					//echo "<pre>"; print_r($_FILES['custom_uploads']['name']); exit;
					
					foreach ($_FILES['custom_uploads']['name'] as $vendorName => $fileName) {
						
						if(!$fileName) { 
							continue;
						}
						
						try {
							$uploader = new Varien_File_Uploader('custom_uploads['.$vendorName.']');
								
							$uploader->setAllowedExtensions(array("csv"));
							$uploader->setAllowRenameFiles(false);
							$uploader->setFilesDispersion(false);
								
							$path = Mage::getBaseDir("var") . DS ."import" . DS . "uploadtool" .DS;
							if(!is_dir($path)) {
								mkdir($path, 0777, true);
							}
							$uploader->save($path, $vendorName.".csv" );
							Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__($vendorName . " File uploaded"));
						}
						catch (Exception $e){
							Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__($vendorName . " File not uploaded"));
							$this->_redirect("*/*/new");
							return;
						}
					}
				}
			}
			
			if(isset($_REQUEST['settings']) && $_REQUEST['settings'] != "") {
				$settings = $_REQUEST['settings'];
				//echo $_REQUEST['settings']['jewelerslink_diamondsearch_slidercolor'] . "<pre>"; print_r($settings); exit;
				if(isset($_REQUEST['settings']['diamond_cfp_enabled']) && $_REQUEST['settings']['diamond_cfp_enabled'] == 'on') {
					$settings['diamond_cfp_enabled'] = 1; 
				} else {
					$settings['diamond_cfp_enabled'] = 0;
				}
				
				foreach($settings as $field => $value){
					$select = mysql_query("select * from `$uploadtool_settings` where `field` = '".$field."'") or die(mysql_error());
					if(mysql_num_rows($select) == 0) {
						mysql_query("insert into `$uploadtool_settings` set `field` = '".$field."', `value` = '".$value."'") or die(mysql_error());
					} else {
						mysql_query("update `$uploadtool_settings` set `value` = '".$value."' where `field` = '".$field."'") or die(mysql_error());
					}
				}
			}
			
			mysql_query("TRUNCATE TABLE $uploadtool_vendor");
			
			for($j = 0; $j<1000; $j++)
			{
				if(isset($_REQUEST['vendor_1-'.$j]) && ($_REQUEST['vendor_1-'.$j] != ''))
				{
					$vendor_name = $_REQUEST['vendor_1-'.$j];
					$vendor_id = $_REQUEST['vendor_2-'.$j];
					Mage::helper('uploadtool')->add_column_if_not_exist($uploadtool_price_increase, "price_increase_".$vendor_name, "VARCHAR( 255 ) NULL DEFAULT '0'" );	
					$query_insert = "INSERT INTO $uploadtool_vendor SET vendor_name = '".$vendor_name."', vendor_id = '".$vendor_id."'";
					mysql_query($query_insert) or die(mysql_error());	
					
				}
			}
			

			$uploadtool_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_vendor');
			$custom_query = "SELECT * FROM `$uploadtool_vendor`";
			$result_vendor = @mysql_db_query($mdb_name, $custom_query) or die("Failed Query of ".$custom_query);

			$price_increase_JL = array();
			$price_increase_JL = array();
			if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_jewelerslink')) {
				$k=1;
				$multi=array();
				while($vendor_row = mysql_fetch_array($result_vendor)) {
					$vendorNameJl = $vendor_row['vendor_name'];
					$price_increase_Jl[$vendorNameJl] = 'price_increase_'.$vendorNameJl;
					$k++;
					$multi[$vendorNameJl]=$k;
					
				} 
					
			}
			foreach($multi as $mkey => $mval)
			{
					 
				for($d = 98; $d > 0; $d--)
				{
					
					$new = $_REQUEST['multiline_'.$mval.'-'.$d];
					$count=count($multi);
					if($new)
					{
						$requestnew['multiline_'.$mkey.'-'.$d]=$new;	 	
					}
				}	
			}
		
			$custom = 5;
			$price_increase_custom = array();
			
			if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_custom')) {
				$uploadtool_custom_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_custom_vendor');
				$custom_vendor_query = "SELECT * FROM `$uploadtool_custom_vendor`";
				$result_custom_vendor = @mysql_db_query($mdb_name, $custom_vendor_query) or die("Failed Query of ".$custom_vendor_query);
				
				while($custom_vendor_row = mysql_fetch_array($result_custom_vendor)) {
					$vendorName = $custom_vendor_row['custom_vendor_name'];
					$price_increase_custom[$vendorName] = $vendorName;
				}
				 		 
			}
		 
			mysql_query("TRUNCATE TABLE $uploadtool_price_increase");
			
			for($i = 1; $i<1000; $i++)
			{
				if(isset($_REQUEST['multiline_0-'.$i]) && ($_REQUEST['multiline_0-'.$i] != '')) {
					
					$price_from_0 = $_REQUEST['multiline_0-'.$i];
					$price_to_1 = $_REQUEST['multiline_1-'.$i];
					$price_increase_percent = $_REQUEST['multiline_2-'.$i];
					
					
					$query_insert_1 = "INSERT INTO $uploadtool_price_increase SET 
															`price_from` = '".$price_from_0."', 
															`price_to` = '".$price_to_1."'";
					
					if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_rapnet')) {
						$count=$count+1;
						if($i>0 && $i<100)
						{
							$price_increase_rapnet = $_REQUEST["multiline_" . (1 + ($count)) ."-".$i];
						}
						else	
						{
							$price_increase_rapnet = $_REQUEST['multiline_3-'.$i];
						}
						$query_insert_1 .= ",`price_increase_rapnet` = '".$price_increase_rapnet."'";
					}
					
					
					
					
					if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_polygon')) {
						$count=$count+1;
						if($i>0 && $i<100)
						{
							$price_increase_polygon = $_REQUEST["multiline_". (1 + ($count)) ."-".$i];
						}
						else	
						{	
							$price_increase_polygon = $_REQUEST['multiline_4-'.$i];
							
						}
						$query_insert_1 .= ",`price_increase_polygon` = '".$price_increase_polygon."'";
					}
					  
					if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_custom')) {
						foreach ($price_increase_custom as $vendorName => $savedPercent) {
							if($i>0 && $i<100)
							{
								$custom=$count+2;
								$price_increase_column = 'price_increase_'.$vendorName;
								$newPercent = $_REQUEST['multiline_'.$custom.'-'.$i];
								$query_insert_1 .= ",`$price_increase_column` = '".$newPercent."'";
							}
							else
							{
								$price_increase_column = 'price_increase_'.$vendorName;
								//echo 'multiline_'.$custom.'-'.$i;
								//exit;
								$newPercent = $_REQUEST['multiline_'.$custom.'-'.$i];
								$query_insert_1 .= ",`$price_increase_column` = '".$newPercent."'";
								$custom++;
							}	
						}
					}
					
					if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_jewelerslink')) {
						//$query_insert_1 .= ",`price_increase` = '".$price_increase_percent."'";
						 
						foreach ($price_increase_Jl as $vendorName => $savedPercent) {
							if($i>0 && $i<100)
							{
								$newPercent = $requestnew['multiline_'.$vendorName.'-'.$i];
							}
							else
							{
								$newPercent = $_REQUEST['multiline_'.$vendorName.'-'.$i];
						    }		
							
							$price_increase_column = 'price_increase_'.$vendorName;
							
							$query_insert_1 .= ",`$price_increase_column` = '".$newPercent."'";
							//$custom++;
						}
						 
						
					} 
					
					//echo 'defaultprice_'.$i;
					//echo "VVV". $_REQUEST['defaultprice_'.$i];
					if(isset($_REQUEST['defaultprice_'.$i]) && ($_REQUEST['defaultprice_'.$i] != ''))
					{
		
						$newPercent = $_REQUEST['defaultprice_'.$i];
						//$query_insert_1 .= ",`defaultprice` = '".$newPercent."'";	
						Mage::helper('uploadtool')->add_column_if_not_exist($uploadtool_price_increase, "defaultprice", "VARCHAR( 255 ) NULL DEFAULT '0'" );
						//$query_insert_price = "INSERT INTO $uploadtool_price_increase  SET defaultprice = '".$newPercent."'";
						//mysql_query($query_insert_price) or die(mysql_error());
						
						$query_insert_1 .= ",`defaultprice` = '".$newPercent."'";
						
						//echo "AAAa  " + $query_insert_1; 
							
					} 
					
					// echo $query_insert_1."<br>";  exit;
					mysql_query($query_insert_1) or die(mysql_error());
				}
				
				
			}
			
			 
			
			 
	
			Mage::getSingleton("adminhtml/session")->addSuccess("Successfully Saved.");
			$this->_redirect("*/*/new");
			return;
		}
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/new");
			return;	
        }
	}
	
	public function getListAction()
	{
		$importCSV = Mage::helper('uploadtool')->getImportCSV();
		if($importCSV['success'] == 0) {
        	Mage::getSingleton("adminhtml/session")->addError($importCSV['message']);
        	$this->_redirect("*/*/new");
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($importCSV['message']);
			$this->_redirect("*/*/new");
		}
	} 
	
	public function getGoogleCsvAction()
	{
		$importCSV = Mage::helper('uploadtool')->getGoogleCsv();
		if($importCSV['success'] == 0) {
        	Mage::getSingleton("adminhtml/session")->addError($importCSV['message']);
        	$this->_redirect("*/*/new");
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($importCSV['message']);
			$this->_redirect("*/*/new");
		}
	} 
	
	public function updateDiamondsAction()
	{
	
		$saveCSV = Mage::helper('uploadtool')->saveCSV();
	
		if($saveCSV['success'] == 0) {
			Mage::getSingleton("adminhtml/session")->addError($saveCSV['message']);
			$this->_redirect("*/*/new");
		} else {
			Mage::helper('uploadtool')->filterDiamonds();
			Mage::getSingleton("adminhtml/session")->addSuccess($saveCSV['message']);
			$this->_redirect("*/*/new");
		}
	}
	
	public function getRapnetListAction()
	{
		$importCSV = Mage::helper('uploadtool')->getRapnetList();
		if($importCSV['success'] == 0) {
			Mage::getSingleton("adminhtml/session")->addError($importCSV['message']);
			$this->_redirect("*/*/new");
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($importCSV['message']);
			$this->_redirect("*/*/new");
		}
	}

	public function updateRapnetDiamondsAction()
	{
		$saveCSV = Mage::helper('uploadtool')->updateRapnetDiamonds();
		
		if($saveCSV['success'] == 0) {
			Mage::getSingleton("adminhtml/session")->addError($saveCSV['message']);
			$this->_redirect("*/*/new");
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($saveCSV['message']);
			$this->_redirect("*/*/new");
		}
		
	}
	
	public function importPolygonAction()
	{
		$savePolygon = Mage::helper('uploadtool')->importPolygon();
		
		if($savePolygon['success'] == 0) {
			Mage::getSingleton("adminhtml/session")->addError($savePolygon['message']);
			$this->_redirect("*/*/new");
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($savePolygon['message']);
			$this->_redirect("*/*/new");
		}
		
	}
	
	public function importGoogleAction()
	{
		$savePolygon = Mage::helper('uploadtool')->importGoogle();
		
		if($savePolygon['success'] == 0) {
			Mage::getSingleton("adminhtml/session")->addError($savePolygon['message']);
			$this->_redirect("*/*/new");
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($savePolygon['message']);
			$this->_redirect("*/*/new");
		}
		
	}
	
	public function customImportAction() {
		
		$vendor = $this->getRequest()->getParam('vendor');
		
		$customImport = Mage::helper('uploadtool')->importCustomUploads($vendor);
		
		if($customImport['success'] == 0) {
			Mage::getSingleton("adminhtml/session")->addError($customImport['message']);
			$this->_redirect("*/*/new");
		} else {
			Mage::getSingleton("adminhtml/session")->addSuccess($customImport['message']);
			$this->_redirect("*/*/new");
		}
		
	}
	
	public function deleteDiamondsAction()
	{
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
				
			$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');

			$source = $this->getRequest()->getParam('source');
			
			if(!$source) {
				Mage::getSingleton("adminhtml/session")->addError("Source not found.");
				$this->_redirect("*/*/new");
				return;
			}
			
			mysql_query("Delete from $uploadtool_diamonds_inventory where source = '".$source."'") or die(mysql_error());
	
			Mage::getSingleton("adminhtml/session")->addSuccess($source . ' Diamonds Removed.');
			$this->_redirect("*/*/new");
			return;
			
		} catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/new");
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
			
			$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');
			$uploadtool_price_increase = Mage::getSingleton("core/resource")->getTableName('uploadtool_price_increase');
			$uploadtool_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_vendor');
			$uploadtool_custom_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_custom_vendor');
			$uploadtool_settings = Mage::getSingleton("core/resource")->getTableName('uploadtool_settings');
			
			mysql_query("TRUNCATE TABLE $uploadtool_price_increase");
			
			$priceIncrease = array();
			$priceIncreases[] = array('price_from'=>'100000.01','price_to'=>'10000000','price_increase'=>'5');
			$priceIncreases[] = array('price_from'=>'50000.01','price_to'=>'100000','price_increase'=>'8');
			$priceIncreases[] = array('price_from'=>'30000.01','price_to'=>'50000','price_increase'=>'10');
			$priceIncreases[] = array('price_from'=>'25000.01','price_to'=>'30000','price_increase'=>'15');
			$priceIncreases[] = array('price_from'=>'20000.01','price_to'=>'25000','price_increase'=>'18');
			$priceIncreases[] = array('price_from'=>'15000.01','price_to'=>'20000','price_increase'=>'20');
			$priceIncreases[] = array('price_from'=>'10000.01','price_to'=>'15000','price_increase'=>'22');
			$priceIncreases[] = array('price_from'=>'5000.01','price_to'=>'10000','price_increase'=>'25');
			$priceIncreases[] = array('price_from'=>'3500.01','price_to'=>'5000','price_increase'=>'30');
			$priceIncreases[] = array('price_from'=>'2000.01','price_to'=>'3500','price_increase'=>'50');
			$priceIncreases[] = array('price_from'=>'1000.01','price_to'=>'2000','price_increase'=>'60');
			$priceIncreases[] = array('price_from'=>'500.01','price_to'=>'1000','price_increase'=>'80');
			$priceIncreases[] = array('price_from'=>'1','price_to'=>'500','price_increase'=>'100');
			
			
			$price_increase_custom = array();
			if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_custom')) {
				
				$uploadtool_custom_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_custom_vendor');
				$custom_vendor_query = "SELECT * FROM `$uploadtool_custom_vendor`";
				$result_custom_vendor = @mysql_db_query($mdb_name, $custom_vendor_query) or die("Failed Query of ".$custom_vendor_query);
			
				while($custom_vendor_row = mysql_fetch_array($result_custom_vendor)) {
					$vendorName = $custom_vendor_row['custom_vendor_name'];
					$price_increase_custom[$vendorName] = $vendorName;
				}
			}
			
			$price_increase_vendor = array();
			if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_jewelerslink'))
			{
				$uploadtool_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_vendor');
				$custom_query = "SELECT * FROM `$uploadtool_vendor`";
				$result_vendor = @mysql_db_query($mdb_name, $custom_query) or die("Failed Query of ".$custom_query);
				
				while($vendor_row = mysql_fetch_array($result_vendor)) {
					$vendorName = $vendor_row['vendor_name'];
					$price_increase_vendor[$vendorName] = $vendorName;
				}
			}
			
			//echo "<pre>"; print_r($price_increase_vendor); exit;
			
			foreach ($priceIncreases as $priceIncrease) {
				
				$price_from = $priceIncrease['price_from'];
				$price_to = $priceIncrease['price_to'];
				$price_increase_default = $priceIncrease['price_increase'];
				
				$insert = "INSERT INTO `$uploadtool_price_increase` SET price_from = '".$price_from."', 
																		price_to = '".$price_to."'";
				
				
				if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_jewelerslink')) {
					$insert .= ",`price_increase` = '".$price_increase_default."'";
				}
				
				if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_rapnet')) {
					$insert .= ",`price_increase_rapnet` = '".$price_increase_default."'";
				}
				
				if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_polygon')) {
					$insert .= ",`price_increase_polygon` = '".$price_increase_default."'";
				}
				
				if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_custom')) {
					foreach ($price_increase_custom as $vendorName => $savedPercent) {
						$price_increase_column = 'price_increase_'.$vendorName;
						
						$insert .= ",`$price_increase_column` = '".$price_increase_default."'";
					}
				}
				
				if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_jewelerslink')) {
					foreach ($price_increase_vendor as $vendorName => $savedPercent) {
						$price_increase_column = 'price_increase_'.$vendorName;
						$insert .= ",`$price_increase_column` = '".$price_increase_default."'";
					}
				}
				//echo $insert; exit;
				mysql_query($insert)or die(mysql_error()."==>".$insert);
				
				//exit;
			}
			
			Mage::getSingleton("adminhtml/session")->addSuccess("Price Increase Restored to default values.");
			$this->_redirect("*/*/new");
				
		}
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/new");
			return;
		}
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam("id") > 0 ) {
			try {
				$model = Mage::getModel("uploadtool/uploadtool");
				 
				$model->setId($this->getRequest()->getParam("id"))
					->delete();
					 
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
				$this->_redirect("*/*/");
			} catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
				$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
			}
		}
		$this->_redirect("*/*/");
	}

    public function massDeleteAction() {
        $uploadtoolIds = $this->getRequest()->getParam("uploadtool");
        if(!is_array($uploadtoolIds)) {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Please select item(s)"));
        } else {
            try {
                foreach ($uploadtoolIds as $uploadtoolId) {
                    $uploadtool = Mage::getModel("uploadtool/uploadtool")->load($uploadtoolId);
                    $uploadtool->delete();
                }
                Mage::getSingleton("adminhtml/session")->addSuccess(
                    Mage::helper("adminhtml")->__(
                        "Total of %d record(s) were successfully deleted", count($uploadtoolIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
            }
        }
        $this->_redirect("*/*/index");
    }
	
    public function massStatusAction()
    {
        $uploadtoolIds = $this->getRequest()->getParam("uploadtool");
        if(!is_array($uploadtoolIds)) {
            Mage::getSingleton("adminhtml/session")->addError($this->__("Please select item(s)"));
        } else {
            try {
                foreach ($uploadtoolIds as $uploadtoolId) {
                    $uploadtool = Mage::getSingleton("uploadtool/uploadtool")
                        ->load($uploadtoolId)
                        ->setStatus($this->getRequest()->getParam("status"))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__("Total of %d record(s) were successfully updated", count($uploadtoolIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect("*/*/index");
    }
  
    public function exportCsvAction()
    {
        $fileName   = "uploadtool.csv";
        $content    = $this->getLayout()->createBlock("uploadtool/adminhtml_uploadtool_grid")
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = "uploadtool.xml";
        $content    = $this->getLayout()->createBlock("uploadtool/adminhtml_uploadtool_grid")
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    } 

    protected function _sendUploadResponse($fileName, $content, $contentType="application/octet-stream")
    {
        $response = $this->getResponse();
        $response->setHeader("HTTP/1.1 200 OK","");
        $response->setHeader("Pragma", "public", true);
        $response->setHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0", true);
        $response->setHeader("Content-Disposition", "attachment; filename=".$fileName);
        $response->setHeader("Last-Modified", date("r"));
        $response->setHeader("Accept-Ranges", "bytes");
        $response->setHeader("Content-Length", strlen($content));
        $response->setHeader("Content-type", $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
	protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('jewelryshare/uploadtool');
    }
    
    public function resetPriceAction()
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
		
			$uploadtoolIds = $this->getRequest()->getParam("vendor");
			$uploadtool_price_increase = Mage::getSingleton("core/resource")->getTableName('uploadtool_price_increase');
			$columnname=$uploadtoolIds;
			if($columnname)
			{
				mysql_query("update `$uploadtool_price_increase` set `$columnname` = `defaultprice`") or die(mysql_error());
				Mage::getSingleton("adminhtml/session")->addSuccess("Successfully Restored.");
			}	
			$this->_redirect("*/*/new"); 
			return;
		 
	}
}
