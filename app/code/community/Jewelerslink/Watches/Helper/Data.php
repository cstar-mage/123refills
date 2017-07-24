<?php

class Jewelerslink_Watches_Helper_Data extends Mage_Core_Helper_Abstract
{
	
	public function getImportCSV() {
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
		
			$attributes = $this->_getImportAttributes();
			$mapped_attributes = array_keys($attributes);
			//echo "<pre>";print_r($mapped_attributes); exit;
			$mapped_string = json_encode($mapped_attributes);
		
			$username = Mage::getStoreConfig('watches/user_detail/ideal_username');
			$password = Mage::getStoreConfig('watches/user_detail/ideal_password');
	
			$data_string = json_encode($vendorArray);
	
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_URL,"http://www.jewelerslink.com/watch/index/getjson");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array("username"=>$username,"password"=>$password,"vendors"=>$data_string,"attributes"=>$mapped_string));
			$data = curl_exec($ch);
			curl_close($ch);
			//echo $data; exit;
		
			if($data == "Invalid Login") {
					
				return array("success"=>0 ,"message"=> "Unauthenticate Login, Go to ( System > Configuration > Watches Config ) and enter Jewelerslink Login Detail");
					
			} else {
				//echo $data; exit;
		
				$existingProducts = Mage::getModel('catalog/product')->getCollection();
				$existingProducts->addAttributeToSelect('sku');
		
				$existSkus = array();
				foreach($existingProducts as $exists) {
					$existSkus[] = $exists->getSku();
				}
				//echo "<pre>"; print_r($existSkus); exit;
				$jsonData = json_decode($data, true);
		
				$mappedHeader =  array();
				foreach($jsonData[0] as $key => $header){
		
					if($header == 'sku') {
						$skuKey = $key;
					}
					if(isset($attributes[$header]) && $attributes[$header] != "") {
						$mappedHeader[] = $attributes[$header];
					} else {
						$mappedHeader[] = $header;
					}
				}
				$jsonData[0] = $mappedHeader;
				//echo "<pre>"; print_r($jsonData);exit;
		
				$csvData = array();
				$csvData[] = $jsonData[0];
				$csvData[0] = $mappedHeader;
				foreach($jsonData as $csvRow) {
					if(!in_array($csvRow[$skuKey], $existSkus)) {
						$csvData[] = $csvRow;
					}
				}
		
				//echo "<pre>"; print_r($csvData);exit;
		
				$priceTable = Mage::getSingleton('core/resource')->getTableName('watches_priceincrease');
				$query = "SELECT * FROM $priceTable";
				$result= mysql_query($query);
				while($row = mysql_fetch_array($result)) {
					$price_from[] = $row['price_from'];
					$price_to[] = $row['price_to'];
					$price_increase_per = $row['price_increase']/100 ;
					$price_increase_final[] = 1 + $price_increase_per ;
				}
		
		
				// Apply Price Increase before saving csv because we are not storing watches to database like diamonds.
				$row=0;
				$csvRowCnt = 1;
				foreach($csvData as $column) {
		
					if($row==0){
						$row++;
						continue;
					}
		
					if(isset($csvData[$csvRowCnt]['price']) && $csvData[$csvRowCnt]['price'] != "") {
						$price = $column['price'];
						if($price == 0) $price = "";
						$csvData[$csvRowCnt]['price'] = $price;
					}
		
					if(isset($csvData[$csvRowCnt]['special_price']) && $csvData[$csvRowCnt]['special_price'] != "") {
						$special_price = $column['special_price'];
						if($special_price == 0) $special_price = "";
						$csvData[$csvRowCnt]['special_price'] = $special_price;
					}
		
					if(isset($csvData[$csvRowCnt]['tier_price']) && $csvData[$csvRowCnt]['tier_price'] != "") {
						$tier_price = $column['tier_price'];
						if($tier_price == 0) $tier_price = "";
						$csvData[$csvRowCnt]['tier_price'] = $tier_price;
					}
		
					if(isset($csvData[$csvRowCnt]['msrp']) && $csvData[$csvRowCnt]['msrp'] != "") {
						$msrp = $column['msrp'];
						if($msrp == 0) $msrp = "";
						$csvData[$csvRowCnt]['msrp'] = $msrp;
					}
		
					if(isset($csvData[$csvRowCnt]['g14_price']) && $csvData[$csvRowCnt]['g14_price'] != "") {
						$g14_price = $column['g14_price'];
						if($g14_price == 0) $g14_price = "";
						$csvData[$csvRowCnt]['g14_price'] = $g14_price;
					}
		
					if(isset($csvData[$csvRowCnt]['g18_price']) && $csvData[$csvRowCnt]['g18_price'] != "") {
						$g18_price = $column['g18_price'];
						if($g18_price == 0) $g18_price = "";
						$csvData[$csvRowCnt]['g18_price'] = $g18_price;
					}
		
					if(isset($csvData[$csvRowCnt]['plat_price']) && $csvData[$csvRowCnt]['plat_price'] != "") {
						$plat_price = $column['plat_price'];
						if($plat_price == 0) $plat_price = "";
						$csvData[$csvRowCnt]['plat_price'] = $plat_price;
					}
		
					if(isset($csvData[$csvRowCnt]['pall_price']) && $csvData[$csvRowCnt]['pall_price'] != "") {
						$pall_price = $column['pall_price'];
						if($pall_price == 0) $pall_price = "";
						$csvData[$csvRowCnt]['pall_price'] = $pall_price;
					}
		
					for($i=0; $i < count($price_increase_final); $i++) {
		
						if($price_increase_final[$i] != '') {
		
							if(isset($csvData[$csvRowCnt]['price']) && $csvData[$csvRowCnt]['price'] != "") {
								if(($price >= $price_from[$i]) && ($price <= $price_to[$i]) && ($price != 0) && ($price != '')) {
									$incPrice = $price*$price_increase_final[$i];
									//echo $incPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['price'] = $incPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['special_price']) && $csvData[$csvRowCnt]['special_price'] != "") {
								if(($special_price >= $price_from[$i]) && ($special_price <= $price_to[$i]) && ($special_price != 0) && ($special_price != '')) {
		
									$incSpPrice = $special_price*$price_increase_final[$i];
									//echo $incSpPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['special_price'] = $incSpPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['tier_price']) && $csvData[$csvRowCnt]['tier_price'] != "") {
								if(($tier_price >= $price_from[$i]) && ($tier_price <= $price_to[$i]) && ($tier_price != 0) && ($tier_price != '')) {
		
									$incTrPrice = $tier_price*$price_increase_final[$i];
									//echo $incTrPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['tier_price'] = $incTrPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['msrp']) && $csvData[$csvRowCnt]['msrp'] != "") {
								if(($msrp >= $price_from[$i]) && ($msrp <= $price_to[$i]) && ($msrp != 0) && ($msrp != '')) {
		
									$incMSPrice = $msrp*$price_increase_final[$i];
									//echo $incMSPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['msrp'] = $incMSPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['g14_price']) && $csvData[$csvRowCnt]['g14_price'] != "") {
								if(($g14_price >= $price_from[$i]) && ($g14_price <= $price_to[$i]) && ($g14_price != 0) && ($g14_price != '')) {
		
									$incG14Price = $g14_price*$price_increase_final[$i];
									//echo $incG14Price."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['g14_price'] = $incG14Price;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['g18_price']) && $csvData[$csvRowCnt]['g18_price'] != "") {
								if(($g18_price >= $price_from[$i]) && ($g18_price <= $price_to[$i]) && ($g18_price != 0) && ($g18_price != '')) {
		
									$incG18Price = $g18_price*$price_increase_final[$i];
									//echo $incG18Price."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['g18_price'] = $incG18Price;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['plat_price']) && $csvData[$csvRowCnt]['plat_price'] != "") {
								if(($plat_price >= $price_from[$i]) && ($plat_price <= $price_to[$i]) && ($plat_price != 0) && ($plat_price != '')) {
		
									$incPtPrice = $plat_price*$price_increase_final[$i];
									//echo $incPtPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['plat_price'] = $incPtPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['pall_price']) && $csvData[$csvRowCnt]['pall_price'] != "") {
								if(($pall_price >= $price_from[$i]) && ($pall_price <= $price_to[$i]) && ($pall_price != 0) && ($pall_price != '')) {
		
									$incPlPrice = $pall_price*$price_increase_final[$i];
									//echo $incPlPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['pall_price'] = $incPlPrice;
								}
							}
		
						}
					}
		
					$csvRowCnt++;
				}
				//echo "<pre>"; print_r($csvData);exit;
		
				$path = Mage::getBaseDir("var") . DS ."import" . DS;
				$fp = fopen($path."watches_import.csv", "w") or die("can't open file");
				foreach ($csvData as $fields) {
					fputcsv($fp, $fields);
				}
				fclose($fp);
		
				return array("success"=>1 ,"message"=> (count($csvData)-1)." New Products CSV Created from Jewelerslink Inventory.");
			}
		
		}
		catch (Exception $e) {
			return array("success"=>0 ,"message"=> $e->getMessage());
		}
	}
	
	public function _getImportAttributes()
	{
		$attributes = Mage::getResourceModel('jewelerslink_watches/codes_collection')->getImportAttributes();
		return $attributes;
	}
	
	public function getImages() {
		
		try {
			$path = Mage::getBaseDir("var") . DS ."import" . DS;
			$fp = fopen($path."watches_import.csv",'r') or die("can't open file");
			$row=0;
			$count = 1;
			while($csv_line = fgetcsv($fp,1024))
			{
				//echo "<pre>";print_r($csv_line);
				if($row==0){
		
					foreach($csv_line as $key => $field) {
		
						if($field == 'image') {
							$imageKey = $key;
						}
						if($field == 'small_image') {
							$small_imageKey = $key;
						}
						if($field == 'thumbnail') {
							$thumbnailKey = $key;
						}
						if($field == 'gallery') {
							$galleryKey = $key;
						}
		
					}
		
					$row++;
					continue;
				}
		
				if(isset($imageKey) && $imageKey != "") {
					// Main Image Save
					$imagePath = str_replace("/jewelerslink","",$csv_line[$imageKey]);
					$httpUrl = str_replace(" ","%20","http://images.jewelerslink.com/watch/".$imagePath);
					$imageName = basename($imagePath);
					$localpath = Mage::getBaseDir()."/media/import/jewelerslink/".str_replace($imageName,"",$imagePath)."/";
					if(!is_dir($localpath)) mkdir($localpath,0777,true);
					if(!file_exists($localpath.$imageName))
						copy($httpUrl, $localpath.$imageName);
				}
		
				if(isset($small_imageKey) && $small_imageKey != "") {
					// Small Image Save
					$simagePath = str_replace("/jewelerslink","",$csv_line[$small_imageKey]);
					$shttpUrl = str_replace(" ","%20","http://images.jewelerslink.com/watch/".$simagePath);
					$simageName = basename($simagePath);
					$slocalpath = Mage::getBaseDir()."/media/import/jewelerslink/".str_replace($simageName,"",$simagePath)."/";
					if(!is_dir($slocalpath)) mkdir($slocalpath,0777,true);
					if(!file_exists($slocalpath.$simageName))
						copy($shttpUrl, $slocalpath.$simageName);
				}
		
				if(isset($thumbnailKey) && $thumbnailKey != "") {
					// Thumbnail Image Save
					$timagePath = str_replace("/jewelerslink","",$csv_line[$thumbnailKey]);
					$thttpUrl = str_replace(" ","%20","http://images.jewelerslink.com/watch/".$timagePath);
					$timageName = basename($timagePath);
					$tlocalpath = Mage::getBaseDir()."/media/import/jewelerslink/".str_replace($timageName,"",$timagePath)."/";
					if(!is_dir($tlocalpath)) mkdir($tlocalpath,0777,true);
					if(!file_exists($tlocalpath.$timageName))
						copy($thttpUrl, $tlocalpath.$timageName);
				}
		
				if(isset($galleryKey) && $galleryKey != "") {
					// Galley Images Save
					$galleryArray = explode(";",$csv_line[$galleryKey]);
		
					foreach($galleryArray as $galleryImg) {
						$gimagePath = str_replace("/jewelerslink","",$galleryImg);
						$ghttpUrl = str_replace(" ","%20","http://images.jewelerslink.com/watch/".$gimagePath);
						$gimageName = basename($gimagePath);
						$glocalpath = Mage::getBaseDir()."/media/import/jewelerslink/".str_replace($gimageName,"",$gimagePath)."/";
						if(!is_dir($glocalpath)) mkdir($glocalpath,0777,true);
						if(!file_exists($glocalpath.$gimageName))
							copy($ghttpUrl, $glocalpath.$gimageName);
					}
				}
		
			}
		
			return array("success"=>1 ,"message"=>"Images written successfully.");
		}
		catch (Exception $e) {
			return array("success"=>0 ,"message"=> $e->getMessage());
		}
	}
	
	public function importProducts() {
		
		//$_SERVER['SERVER_PORT']='443';
		Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
		
		$profileId = 3; //put your profile id here
		
		$filename = Mage::app()->getRequest()->setParam('files','watches_import.csv');
		$filename = Mage::app()->getRequest()->getParam('files'); // set the filename that is to be imported - file needs to be present in var/import directory
		
		if (!isset($filename))  {
			die("No file has been set!");
		}
		$logFileName= $filename.'.log';
		$recordCount = 0;
		
		//Mage::log("Import Started",null,$logFileName);
		
		$profile = Mage::getModel('dataflow/profile');
		
		$userModel = Mage::getModel('admin/user');
		$userModel->setUserId(0);
		Mage::getSingleton('admin/session')->setUser($userModel);
		
		if ($profileId) {
			$profile->load($profileId);
			if (!$profile->getId()) {
				//Mage::getSingleton('adminhtml/session')->addError('The profile you are trying to save no longer exists');
				return array("success"=>0 ,"message"=>"The profile you are trying to save no longer exists");
			}
		}
		
		Mage::register('current_convert_profile', $profile);
		
		$profile->run();
		
		$batchModel = Mage::getSingleton('dataflow/batch');
		if ($batchModel->getId()) {
			if ($batchModel->getAdapter()) {
				$batchId = $batchModel->getId();
				$batchImportModel = $batchModel->getBatchImportModel();
				$importIds = $batchImportModel->getIdCollection();
		
				$batchModel = Mage::getModel('dataflow/batch')->load($batchId);
				$adapter = Mage::getModel($batchModel->getAdapter());
				foreach ($importIds as $importId) {
					$recordCount++;
		
					try{
						$batchImportModel->load($importId);
						if (!$batchImportModel->getId()) {
							$errors[] = Mage::helper('dataflow')->__('Skip undefined row');
							continue;
						}
		
						$importData = $batchImportModel->getBatchData();
						try {
							$adapter->saveRow($importData);
						} catch (Exception $e) {
							echo $e->getMessage();
							continue;
						}
		
						if ($recordCount%100 == 0) {
							echo 'Processed: '.$recordCount . ''.chr(13).'\n';
						}
					} catch(Exception $ex) {
						echo 'Record# ' . $recordCount . ' - SKU = ' . $importData['sku']. ' - Error - ' . $ex->getMessage().'\n';
					}
				}
				foreach ($profile->getExceptions() as $e) {
					array("success"=>0 ,"message"=> $e->getMessage());
				}
			}
		}
		return array("success"=>1 ,"message"=>"Product Import Completed.");
		
	}
	
	public function getUpdateCSV() {
		
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
		
			$attributes = $this->_getUpdateAttributes();
			$mapped_attributes = array_keys($attributes);
			//echo "<pre>";print_r($mapped_attributes); exit;
				
			$mapped_string = json_encode($mapped_attributes);
				
			$username = Mage::getStoreConfig('watches/user_detail/ideal_username');
			$password = Mage::getStoreConfig('watches/user_detail/ideal_password');
	
			$data_string = json_encode($vendorArray);
	
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_URL,"http://www.jewelerslink.com/watch/index/getMappedUpdateJson");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array("username"=>$username,"password"=>$password,"vendors"=>$data_string,"attributes"=>$mapped_string));
			$data = curl_exec($ch);
			curl_close($ch);
			//echo $data; exit;
		
			if($data == "Invalid Login") {
		
				return array("success"=>0 ,"message"=>"Unauthenticate Login, Go to ( System > Configuration > Watches Config ) and enter Jewelerslink Login Detail");
		
			} else {
				//echo $data;exit;
		
				$existingProducts = Mage::getModel('catalog/product')->getCollection();
				$existingProducts->addAttributeToSelect('sku');
		
				$existSkus = array();
				foreach($existingProducts as $exists) {
					$existSkus[] = $exists->getSku();
				}
				//echo "<pre>"; print_r($existSkus); exit;
				$jsonData = json_decode($data, true);
		
				//echo "<pre>"; print_r($jsonData); exit;
		
				$mappedHeader =  array();
				foreach($jsonData[0] as $key => $header){
		
					if($header == 'sku') {
						$skuKey = $key;
					}
					if(isset($attributes[$header]) && $attributes[$header] != "") {
						$newHeader = $attributes[$header];
						$mappedHeader[$newHeader] = $newHeader;
					} else {
						$mappedHeader[$header] = $header;
					}
				}
				$jsonData[0] = $mappedHeader;
				//echo "<pre>"; print_r($jsonData);exit;
		
				$csvData = array();
				$rowCnt = 0;
				foreach($jsonData as $csvRow) {
		
					if($rowCnt==0) {
						$csvData[] = $csvRow;
					} else {
						if(in_array($csvRow[$skuKey], $existSkus)) {
							$csvData[] = $csvRow;
						}
					}
					$rowCnt++;
				}
		
				//echo "<pre>"; print_r($csvData);exit;
		
				$priceTable = Mage::getSingleton('core/resource')->getTableName('watches_priceincrease');
				$query = "SELECT * FROM $priceTable";
				$result= mysql_query($query);
				while($row = mysql_fetch_array($result)) {
					$price_from[] = $row['price_from'];
					$price_to[] = $row['price_to'];
					$price_increase_per = $row['price_increase']/100 ;
					$price_increase_final[] = 1 + $price_increase_per ;
				}
		
		
				// Apply Price Increase before saving csv because we are not storing watches to database like diamonds.
				$row=0;
				$csvRowCnt = 1;
				foreach($csvData as $column) {
		
					if($row==0){
						$row++;
						continue;
					}
		
					if(isset($csvData[$csvRowCnt]['price']) && $csvData[$csvRowCnt]['price'] != "") {
						$price = $column['price'];
						if($price == 0) $price = "";
						$csvData[$csvRowCnt]['price'] = $price;
					}
		
					if(isset($csvData[$csvRowCnt]['special_price']) && $csvData[$csvRowCnt]['special_price'] != "") {
						$special_price = $column['special_price'];
						if($special_price == 0) $special_price = "";
						$csvData[$csvRowCnt]['special_price'] = $special_price;
					}
		
					if(isset($csvData[$csvRowCnt]['tier_price']) && $csvData[$csvRowCnt]['tier_price'] != "") {
						$tier_price = $column['tier_price'];
						if($tier_price == 0) $tier_price = "";
						$csvData[$csvRowCnt]['tier_price'] = $tier_price;
					}
		
					if(isset($csvData[$csvRowCnt]['msrp']) && $csvData[$csvRowCnt]['msrp'] != "") {
						$msrp = $column['msrp'];
						if($msrp == 0) $msrp = "";
						$csvData[$csvRowCnt]['msrp'] = $msrp;
					}
		
					if(isset($csvData[$csvRowCnt]['g14_price']) && $csvData[$csvRowCnt]['g14_price'] != "") {
						$g14_price = $column['g14_price'];
						if($g14_price == 0) $g14_price = "";
						$csvData[$csvRowCnt]['g14_price'] = $g14_price;
					}
		
					if(isset($csvData[$csvRowCnt]['g18_price']) && $csvData[$csvRowCnt]['g18_price'] != "") {
						$g18_price = $column['g18_price'];
						if($g18_price == 0) $g18_price = "";
						$csvData[$csvRowCnt]['g18_price'] = $g18_price;
					}
		
					if(isset($csvData[$csvRowCnt]['plat_price']) && $csvData[$csvRowCnt]['plat_price'] != "") {
						$plat_price = $column['plat_price'];
						if($plat_price == 0) $plat_price = "";
						$csvData[$csvRowCnt]['plat_price'] = $plat_price;
					}
		
					if(isset($csvData[$csvRowCnt]['pall_price']) && $csvData[$csvRowCnt]['pall_price'] != "") {
						$pall_price = $column['pall_price'];
						if($pall_price == 0) $pall_price = "";
						$csvData[$csvRowCnt]['pall_price'] = $pall_price;
					}
		
					//echo $price ."==";
					for($i=0; $i < count($price_increase_final); $i++) {
		
						if($price_increase_final[$i] != '') {
		
							if(isset($csvData[$csvRowCnt]['price']) && $csvData[$csvRowCnt]['price'] != "") {
								if(($price >= $price_from[$i]) && ($price <= $price_to[$i]) && ($price != 0) && ($price != '')) {
									$incPrice = $price*$price_increase_final[$i];
									//echo $incPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['price'] = $incPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['special_price']) && $csvData[$csvRowCnt]['special_price'] != "") {
								if(($special_price >= $price_from[$i]) && ($special_price <= $price_to[$i]) && ($special_price != 0) && ($special_price != '')) {
		
									$incSpPrice = $special_price*$price_increase_final[$i];
									//echo $incSpPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['special_price'] = $incSpPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['tier_price']) && $csvData[$csvRowCnt]['tier_price'] != "") {
								if(($tier_price >= $price_from[$i]) && ($tier_price <= $price_to[$i]) && ($tier_price != 0) && ($tier_price != '')) {
		
									$incTrPrice = $tier_price*$price_increase_final[$i];
									//echo $incTrPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['tier_price'] = $incTrPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['msrp']) && $csvData[$csvRowCnt]['msrp'] != "") {
								if(($msrp >= $price_from[$i]) && ($msrp <= $price_to[$i]) && ($msrp != 0) && ($msrp != '')) {
		
									$incMSPrice = $msrp*$price_increase_final[$i];
									//echo $incMSPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['msrp'] = $incMSPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['g14_price']) && $csvData[$csvRowCnt]['g14_price'] != "") {
								if(($g14_price >= $price_from[$i]) && ($g14_price <= $price_to[$i]) && ($g14_price != 0) && ($g14_price != '')) {
		
									$incG14Price = $g14_price*$price_increase_final[$i];
									//echo $incG14Price."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['g14_price'] = $incG14Price;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['g18_price']) && $csvData[$csvRowCnt]['g18_price'] != "") {
								if(($g18_price >= $price_from[$i]) && ($g18_price <= $price_to[$i]) && ($g18_price != 0) && ($g18_price != '')) {
		
									$incG18Price = $g18_price*$price_increase_final[$i];
									//echo $incG18Price."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['g18_price'] = $incG18Price;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['plat_price']) && $csvData[$csvRowCnt]['plat_price'] != "") {
								if(($plat_price >= $price_from[$i]) && ($plat_price <= $price_to[$i]) && ($plat_price != 0) && ($plat_price != '')) {
		
									$incPtPrice = $plat_price*$price_increase_final[$i];
									//echo $incPtPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['plat_price'] = $incPtPrice;
								}
							}
		
							if(isset($csvData[$csvRowCnt]['pall_price']) && $csvData[$csvRowCnt]['pall_price'] != "") {
								if(($pall_price >= $price_from[$i]) && ($pall_price <= $price_to[$i]) && ($pall_price != 0) && ($pall_price != '')) {
		
									$incPlPrice = $pall_price*$price_increase_final[$i];
									//echo $incPlPrice."==".$csvRowCnt."<br>";
									$csvData[$csvRowCnt]['pall_price'] = $incPlPrice;
								}
							}
		
						}
					}
		
					$csvRowCnt++;
				}
				//echo "<pre>"; print_r($csvData);exit;
		
				$path = Mage::getBaseDir("var") . DS ."import" . DS;
				$fp = fopen($path."watches_update.csv", "w") or die("can't open file");
				foreach ($csvData as $fields) {
					fputcsv($fp, $fields);
				}
				fclose($fp);
		
				return array("success"=>1 ,"message"=>(count($csvData)-1)." Update Products CSV Created from Jewelerslink Inventory.");
			}
		
		}
		catch (Exception $e) {
			return array("success"=>0 ,"message"=>$e->getMessage());
		}
	}
	
	public function _getUpdateAttributes()
	{
		$attributes = Mage::getResourceModel('jewelerslink_watches/codes_collection')->getUpdateAttributes();
		return $attributes;
	}
	
	public function updateProducts() {

		//$_SERVER['SERVER_PORT']='443';
		Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
		
		$profileId = 3; //put your profile id here
		
		$filename = Mage::app()->getRequest()->setParam('files','watches_update.csv');
		$filename = Mage::app()->getRequest()->getParam('files'); // set the filename that is to be imported - file needs to be present in var/import directory
		
		if (!isset($filename))  {
			die("No file has been set!");
		}
		$logFileName= $filename.'.log';
		$recordCount = 0;
		
		//Mage::log("Import Started",null,$logFileName);
		
		$profile = Mage::getModel('dataflow/profile');
		
		$userModel = Mage::getModel('admin/user');
		$userModel->setUserId(0);
		Mage::getSingleton('admin/session')->setUser($userModel);
		
		if ($profileId) {
			$profile->load($profileId);
			if (!$profile->getId()) {
				Mage::getSingleton('adminhtml/session')->addError('The profile you are trying to save no longer exists');
			}
		}
		
		Mage::register('current_convert_profile', $profile);
		
		$profile->run();
		
		$batchModel = Mage::getSingleton('dataflow/batch');
		if ($batchModel->getId()) {
			if ($batchModel->getAdapter()) {
				$batchId = $batchModel->getId();
				$batchImportModel = $batchModel->getBatchImportModel();
				$importIds = $batchImportModel->getIdCollection();
		
				$batchModel = Mage::getModel('dataflow/batch')->load($batchId);
				$adapter = Mage::getModel($batchModel->getAdapter());
				foreach ($importIds as $importId) {
					$recordCount++;
		
					try{
						$batchImportModel->load($importId);
						if (!$batchImportModel->getId()) {
							$errors[] = Mage::helper('dataflow')->__('Skip undefined row');
							continue;
						}
		
						$importData = $batchImportModel->getBatchData();
						try {
							$adapter->saveRow($importData);
						} catch (Exception $e) {
							echo $e->getMessage();
							continue;
						}
		
						if ($recordCount%100 == 0) {
							echo 'Processed: '.$recordCount . ''.chr(13).'\n';
						}
					} catch(Exception $ex) {
						echo 'Record# ' . $recordCount . ' - SKU = ' . $importData['sku']. ' - Error - ' . $ex->getMessage().'\n';
					}
				}
				foreach ($profile->getExceptions() as $e) {
					echo $e->getMessage();
				}
			}
		}
		
		return array("success"=>1 ,"message"=> "Product Update Completed.");
		
	}
	
	/**
	 * Checking if some required attributes missed
	 *
	 * @param array $attributes
	 * @return bool
	 */
	public function checkRequired($attributes)
	{
		return true;
		 
		$attributeConfig = Mage::getConfig()->getNode(Jewelerslink_Watches_Model_Import::XML_NODE_FIND_FEED_ATTRIBUTES);
		$attributeRequired = array();
		foreach ($attributeConfig->children() as $ac) {
			if ((int)$ac->required) {
				$attributeRequired[] = (string)$ac->label;
			}
		}
	
		//echo "<pre>"; print_r($attributeRequired); exit;
	
		foreach ($attributeRequired as $value) {
			if (!isset($attributes[$value])) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Product entity type
	 *
	 * @return int
	 */
	public function getProductEntityType()
	{
		return Mage::getSingleton('eav/config')->getEntityType('catalog_product')->getId();
	}
	
}