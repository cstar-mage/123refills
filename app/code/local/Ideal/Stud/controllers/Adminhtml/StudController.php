<?php
 
class Ideal_Stud_Adminhtml_StudController extends Mage_Adminhtml_Controller_action
{	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu("stud/items")
			->_addBreadcrumb(Mage::helper("adminhtml")->__("Items Manager"), Mage::helper("adminhtml")->__("Item Manager"));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {

		$id     = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("stud/stud")->load($id);

		if ($model->getId() || $id == 0) {

			$data = Mage::getSingleton("adminhtml/session")->getFormData(true);


			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register("stud_data", $model);

			$this->loadLayout();
			$this->_setActiveMenu("stud/items");

			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item Manager"), Mage::helper("adminhtml")->__("Item Manager"));
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item News"), Mage::helper("adminhtml")->__("Item News"));

			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock("stud/adminhtml_stud_edit"))
				->_addLeft($this->getLayout()->createBlock("stud/adminhtml_stud_edit_tabs"));

			$this->renderLayout();
		} else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("stud")->__("Item does not exist"));
			$this->_redirect("*/*/");
		}
	}
 
	public function newAction() {
		$this->_forward("edit");
	}
 
	public function saveAction() {	
		try{
 
			
			$post  = $this->getRequest()->getPost();
			
		/*	echo "<pre>";
			print_r($post);
			exit; */

			$data = array();
			$data1 = array();
			
			$storeId = Mage::app()->getStore()->getStoreId();
			$config = new Mage_Core_Model_Config();

				
			$config->saveConfig('stud/general_settings/d14k_white_gold', $post["14k_white_gold"] , 'default', $storeId);
			$config->saveConfig('stud/general_settings/d14k_yellow_gold', $post["14k_yellow_gold"] , 'default', $storeId);
			$config->saveConfig('stud/general_settings/d14k_rose_gold', $post["14k_rose_gold"] , 'default', $storeId); 
			$config->saveConfig('stud/general_settings/d18k_white_gold', $post["18k_white_gold"] , 'default', $storeId);
			$config->saveConfig('stud/general_settings/d18k_yellow_gold', $post["18k_yellow_gold"] , 'default', $storeId);
			$config->saveConfig('stud/general_settings/d18k_rose_gold', $post["18k_rose_gold"] , 'default', $storeId);
			$config->saveConfig('stud/general_settings/platinum', $post["platinum"] , 'default', $storeId);
			$config->saveConfig('stud/general_settings/studcolor', $post["studcolor"] , 'default', $storeId);
			$config->saveConfig('stud/general_settings/studfontcolor', $post["studfontcolor"] , 'default', $storeId);
			$config->saveConfig('stud/general_settings/studactivefontcolor', $post["studactivefontcolor"] , 'default', $storeId);



			//echo "<pre>";
			//print_r($post);
			//exit; 

				 $findme = "count";

				 foreach ($post as $key => $value) {

				 	if(strpos($key, "breakloop")){
						break;
					}
					if(strpos($key, $findme)){					
						continue;			
					}
				 	
				 	$count1 = count($value);

				 /* 	echo '-----------------------------------';
				 	echo '<pre>';
				 	print_r($value);
				 	echo '</pre>';
				 	echo '-----------------------------------';
*/
				 	if(is_array($value)){

				 		for($n=2;$n<count($value);$n+=3){

				 		//	echo $value[0].'->'.$value[1].'->'.$value[$n].'->'.$value[$n+1].'->'.$value[$n+2].'-><br>';
				 			if($value[$n] == ""){

				 				$valueprice = "0";

				 			}else{

				 				$valueprice = $value[$n];

				 			}

				 			
				 			$dataarray = array('shape' => $value[1], 'carat' => $value[0], 'dbfield' => $value[$n+2], 'price' => $valueprice);
				 		

				 			
				 			//array('diamondstud_id' => $value[$n+1] , 'shape' => $value[1], 'carat' => $value[0], 'dbfield' => $value[$n+2], 'price' => $value[$n]);
				 			
				 			/* echo "<pre>";
				 			print_r($dataarray); */
				 			
				 			$aa = $n+1;
				 			

				 			if($value[$aa] >= 1){
				 			
				 				$model = Mage::getModel('stud/stud')->load($value[$aa])->addData($dataarray);
								$model->setId($value[$aa])->save();

				 							 												

				 			}else{

				 				$model = Mage::getSingleton('stud/stud')->setData($dataarray);
								$model->save(); 
								

				 			}

				 		}

				 	}
				

				 

				}



			
			
			Mage::getSingleton("adminhtml/session")->addSuccess("Information Saved.");
			$this->_redirect("*/*/new");
			return;
		}
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/new");
			return;	
        }
	}
	 
	public function insertinpopupAction()
	{
	 	$fancycolor['LIGHT'] = 9;
		$fancycolor['F.LIGHT'] = 10;
		$fancycolor['FANCY'] = 11;
		$fancycolor['INTENSE'] = 12;
		$fancycolor['VIVID'] = 13;
		$fancycolor['DEEP'] = 14; 
		try
		{
			$magento_db 	= 	Mage::getStoreConfig('stud/db_detail/db_database'); 
			$mdb_name 		= 	Mage::getStoreConfig('stud/db_detail/db_name');
			$mdb_user 		= 	Mage::getStoreConfig('stud/db_detail/db_username');
			$mdb_passwd 	= 	Mage::getStoreConfig('stud/db_detail/db_userpassword');
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
			
			if (!$magento_connection)
			{
				die('Unable to connect to the Magento database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Magento Database not found.");
			
			$select_vendor = 'select * from `vendor`';
			$result = mysql_query($select_vendor);
			while($row = mysql_fetch_array($result))
			{
				$SELLER_IDS[$row['vendor_id']] = $row['rap_percent'];
				$SELLER_NAMES[$row['vendor_name']] = $row['rap_percent'];
			}	
			
			$user = Mage::getStoreConfig('stud/user_detail/rapnet_username');
			$passwd = Mage::getStoreConfig('stud/user_detail/rapnet_password');
			
			define('RAPNET_USER', $user);
			define('RAPNET_PASS', $passwd);
			
			$auth_url = "https://technet.rapaport.com/HTTP/Authenticate.aspx";
			$post_string = "username=".RAPNET_USER."&password=" . urlencode(RAPNET_PASS);
			
			$request = curl_init($auth_url); //initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); //set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); //Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); //use HTTP POST to send form data
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); //uncomment this line if you get no gateway response.
			$auth_ticket = curl_exec($request); //execute curl post and store results in $auth_ticket
			curl_close ($request);
	
			define('RAPNET_LINK', 'technet.rapaport.com/HTTP/RapLink/download.aspx?SellerLogin='.implode(',', array_keys($SELLER_IDS)).'&SortBy=Owner&White=1&Fancy=1&Programmatically=yes&Version=0.8&UseCheckedCulommns=1&cCT=1&cCERT=1&cCLAR=1&cCOLR=1&cCRTCM=1&cCountry=1&cCITY=1&cCROWN=1&cCulet=1&cCuletSize=1&cCuletCondition=1&cCUT=1&cDPTH=1&cFancyColor=1&cFLR=1&cGIRDLE=1&cGirdleMin=1&cGirdleMax=1&cFancyColorIntensity=1&cLOTNN=1&cMEAS=1&cMeasLength=1&cMeasWidth=1&cMeasDepth=1&cFancyColorOvertone=1&cPAVILION=1&cPOL=1&cTPr=1&cRapSpec=1&cOWNER=1&cAct=1&cNC=1&cSHP=1&cSTATE=1&cSTOCK_NO=1&cSYM=1&cTBL=1&cSTONES=1&cCertificateImage=1&cCertID=1&cFluorColor=1&cFluorIntensity=1&cDateUpdated=1'.'&ticket='.$auth_ticket); 
			
			$handle = fopen('http://'.RAPNET_LINK, 'r');
			$csv_terminated = "\n";
			$csv_separator = ",";
			$csv_enclosed = "'";
			$csv_escaped = "\\";
			$CSV = "";
			
			while (($data = fgetcsv($handle, 0, ",")) !== FALSE) 
			{ 
				for ($field = 0; $field < count($data); $field++) 
				{ 
					if($field == 29)
					{
						$CSV.= ''.$csv_separator;
					}
					else
					{
						$CSV.= $data[$field].$csv_separator;					
					}	
				}
				$CSV.= $csv_terminated;
			}
			
			$path = Mage::getBaseDir("var") . DS ."import" . DS;
			$fp = fopen($path."products.csv", "w") or die("can't open file");
			fputs($fp, rtrim($CSV));
			fclose($fp);
			
			Mage::getSingleton("adminhtml/session")->addSuccess("Successfully get list from Rapnet.");
			$this->_redirect("*/*/new");
		}		
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/new");
			return;				
        }
	} 
	
	
	public function reindexAction()
	{
		try
		{
			$magento_db 	= 	Mage::getStoreConfig('stud/db_detail/db_database'); 
			$mdb_name 		= 	Mage::getStoreConfig('stud/db_detail/db_name');
			$mdb_user 		= 	Mage::getStoreConfig('stud/db_detail/db_username');
			$mdb_passwd 	= 	Mage::getStoreConfig('stud/db_detail/db_userpassword');
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
			
			if (!$magento_connection)
			{
				die('Unable to connect to the database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
			mysql_query("TRUNCATE TABLE diamonds_inventory");
			
			$path = Mage::getBaseDir("var") . DS ."import" . DS;
			$fp = fopen($path."products.csv",'r') or die("can't open file");
			$row=0;
			$count = 1;
			while($csv_line = fgetcsv($fp,1024))
			{
				if($row==0){
					$row++;
					continue;
				}
				$qstring = "insert into `diamonds_inventory` SET 
						owner = '".$csv_line[0]."',
						shape = '".$csv_line[1]."',
						carat = '".$csv_line[2]."',
						color = '".$csv_line[3]."',
						fancycolor = '".$csv_line[4]."',
						fancy_intensity = '".$csv_line[5]."',
						clarity = '".$csv_line[7]."',
						cut = '".$csv_line[8]."',
						polish = '".$csv_line[9]."',
						symmetry = '".$csv_line[10]."',
						fluorescence = '".$csv_line[11]."',
						dimensions = '".$csv_line[13]."',
						certificate = '".$csv_line[17]."',
						cert_number = '".$csv_line[18]."',
						stock_number = '".$csv_line[19]."',
						cost = '".$csv_line[20]."',
						totalprice = '".$csv_line[20]."',
						depth = '".$csv_line[21]."',
						tabl = '".$csv_line[22]."',
						girdle = '".$csv_line[23]."',
						culet = '".$csv_line[26]."',
						crown = '".$csv_line[27]."',
						pavilion = '".$csv_line[28]."',
						city = '".$csv_line[30]."',
						state = '".$csv_line[31]."',
						country = '".$csv_line[32]."',
						number_stones = '".$csv_line[33]."',
						image = '".$csv_line[34]."',
						lotno = '".$csv_line[35]."',
						make = '".$csv_line[36]."'";
						
				mysql_query($qstring);
			}
			
			$query = "SELECT * FROM applied_rule";
			$result= mysql_query($query);
			while($row = mysql_fetch_array($result))
			{
				 $price_from[] = $row[price_from];
				 $price_to[] = $row[price_to];
				 $price_increase_per = $row[price_increase]/100 ;
				 $price_increase_final[] = 1 + $price_increase_per ;		
			}
			
			
			$del = "DELETE FROM `diamonds_inventory` where totalprice = 0.00 or carat=0 or clarity='';";
			mysql_query($del);

			for($i=0; $i<100; $i++)
			{
				if($price_increase_final[$i] != '')
				{
					$query_update = "UPDATE diamonds_inventory SET totalprice = totalprice*".$price_increase_final[$i]." where cost between ".$price_from[$i]." AND ".$price_to[$i];
					//echo '<br/>';
				mysql_query($query_update);
				}
			
			}

			$ROUND= "update `diamonds_inventory` set `shape` = 'ROUND' where `shape`='B' or `shape`='RB' or `shape`='BR';";
			$PRINCESS= "update `diamonds_inventory` set `shape` = 'PRINCESS' where `shape`='PR';";
			$EMERALD= "update `diamonds_inventory` set `shape` = 'EMERALD' where `shape`='E' or `shape`='EC';";
			$ASSCHER= "update `diamonds_inventory` set `shape` = 'ASSCHER' where `shape`='AS' or `shape`='AC';";
			$MARQUISE= "update `diamonds_inventory` set `shape` = 'MARQUISE' where `shape`='M' or `shape`='MQ';";
			$OVAL= "update `diamonds_inventory` set `shape` = 'OVAL' where `shape`='O' or `shape`='OV' or `shape`='OC';";
			$RADIANT= "update `diamonds_inventory` set `shape` = 'RADIANT' where `shape`='R' or `shape`='RAD';";
			$PEAR= "update `diamonds_inventory` set `shape` = 'PEAR' where `shape`='P' or `shape`='PS';";
			$CUSHION= "update `diamonds_inventory` set `shape` = 'CUSHION' where `shape`='C' or `shape`='CU' or `shape`='CMB';";
			$HEART= "update `diamonds_inventory` set `shape` = 'HEART' where `shape`='H' or `shape`='HM' or `shape`='HS';";
			$TRILLION = "update `diamonds_inventory` set `shape` = 'TRIANGULAR' where `shape`='TRI' or `shape`='T';";

			$DelShape = "DELETE FROM `diamonds_inventory` WHERE `shape` NOT IN ('ROUND', 'PRINCESS', 'EMERALD', 'ASSCHER', 'MARQUISE', 'OVAL', 'RADIANT', 'PEAR', 'CUSHION', 'HEART', 'TRIANGULAR') OR `dimensions`='0.00x0.00x0.00' OR `dimensions`='0.00-0.00x0.00';";
		
			$shadelight= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 9   where `fancy_intensity`='LIGHT' OR `fancy_intensity`='Light' OR `fancy_intensity`='light';"; 
			$shadefancylight= "update `diamonds_inventory` set `color` = `fancycolor`,`fancycolor` = 10 where `fancy_intensity`='Fancy Light' OR `fancy_intensity`='FANCY LIGHT' OR `fancy_intensity`='fancy light';"; 	
			$shadefancy= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 11  where `fancy_intensity`='FANCY' OR `fancy_intensity`='Fancy' OR `fancy_intensity`='fancy';";	
			$shadefancyintense= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 12 where `fancy_intensity`='Fancy Intense' OR `fancy_intensity`='fancy intense' OR `fancy_intensity`='FANCY INTENSE';";
			$shadefancyvivid= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 13 where `fancy_intensity`='VIVID' OR `fancy_intensity`='Vivid' OR `fancy_intensity`='vivid';";
			$shadefancydeep= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 14 where `fancy_intensity`='Fancy Deep' OR `fancy_intensity`='FANCY DEEP' OR `fancy_intensity`='fancy deep';";
			
			mysql_query($ROUND);
			mysql_query($PRINCESS);
			mysql_query($EMERALD);
			mysql_query($ASSCHER);
			mysql_query($MARQUISE);
			mysql_query($OVAL);  
			mysql_query($RADIANT);  
			mysql_query($PEAR);  
			mysql_query($CUSHION);  
			mysql_query($HEART);  
			mysql_query($TRILLION);  
			
			mysql_query($DelShape);  	
			
			mysql_query($shadelight);
			mysql_query($shadefancylight);
			mysql_query($shadefancy);
			mysql_query($shadefancyintense);
			mysql_query($shadefancyvivid);
			mysql_query($shadefancydeep);
			
			$sql = "select count(lotno) from diamonds_inventory "; 
			$result = mysql_query($sql); 
			$row = mysql_fetch_row($result); 
			$count = $row[0];
									
			Mage::getSingleton("adminhtml/session")->addSuccess($count." Diamond(s) Inserted.");
			$this->_redirect("*/*/new");

		}		
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/new");
			return;				
		}
	}
	
 	public function inventoryupdateAction()
	{
////////////////////////////////////////  Code for adding into inventory table  /////////////////////////////////////////
				$Shape['RB'] = 'ROUND';
				$Shape['BR'] = 'ROUND';
				$Shape['PS'] = 'PRINCESS';
				$Shape['OV'] = 'OVAL';
				$Shape['HS'] = 'HEART';
				$Shape['MQ'] = 'MARQUISE';
				$Shape['PR'] = 'PEAR';
				$Shape['CU'] = 'CUSHION';
				$Shape['EC'] = 'EMERALD';
				$Shape['RAD'] = 'RADIANT';
				$Shape['AC'] = 'ASSCHER';
				$Shape['TR'] = 'TRILLION';
				
				$Shape['HM'] = 'HEART';
				
				$Shape['OC'] = 'OVAL';		
				 
				
				$path = Mage::getBaseDir("var") . DS ."import" . DS;	
				
				$fp = fopen($path."upload_product.csv","r") or die("can't open file");
				$row=0;
				
				
				$write = Mage::getSingleton("core/resource")->getConnection("core_write");
				$sql = "TRUNCATE TABLE `inventorynew`";
				$readresult = $write->query($sql);			
				
				while($csv_line = fgetcsv($fp,2058)){					
					if($row==0){
						foreach($csv_line as $key=>$lineValue)
						{
							if($lineValue == "sku")
							{
								$sku=$key;
								break;
							}
						}
						$row++;
						continue;
					}else{
						
						$_product = Mage::getModel("catalog/product");
						$Id = $_product->getIdBySku($csv_line[5]);
						if($Id)
						{
								$_product = $_product->load($Id);
								
								$lotno          = $csv_line[$sku]; 
								
								$shape          = $_product->getResource()->getAttribute("diamond_shape")->getFrontend()->getValue($_product);
								
								$lab            = $_product->getData("lab");
								
								$carat          = $_product->getData("diamond_carat");
								$stone          = 1;
								$color          = $_product->getResource()->getAttribute("diamond_color")->getFrontend()->getValue($_product);
								$clarity        = $_product->getResource()->getAttribute("diamond_clarity")->getFrontend()->getValue($_product);
								$cut            = "";
								$culet          = $_product->getResource()->getAttribute("diamond_cutlet")->getFrontend()->getValue($_product);
								

								$dimensions    = $_product->getData("dimension_length")."x".$_product->getData("dimension_width");
								
								if($_product->getData("dimension_height")!= ""||$_product->getData("dimension_height")!=NULL)
								{
									$dimensions.="x".$_product->getData("dimension_height");
								}
								$depth          = $_product->getData("diamond_depth");
								$tabl           = $_product->getData("diamond_table");
								$crown_angle    = $_product->getData("crown_angle");
								$crown_height   = $_product->getData("crown_height");
								$pavilion_height= $_product->getData("pavilion_height");
								$polish         = $_product->getResource()->getAttribute("diamond_polish")->getFrontend()->getValue($_product);
								$symmetry       = $_product->getResource()->getAttribute("diamond_symmetry")->getFrontend()->getValue($_product);
								
								
								
								
								$fluorescence   = $_product->getResource()->getAttribute("diamond_fluor")->getFrontend()->getValue($_product);
								$girdle         = $_product->getResource()->getAttribute("diamond_girdle")->getFrontend()->getValue($_product);
								$certificate    = $_product->getData("certificate_id ");;
								$ppc            = "";
								$colorcode      = "";
								$claritycode    = "";
								$fancycolor     = $_product->getData("fancy_color");
								$totalprice     = $_product->getData("price");
								
								
								
								if($cut == "No")
								{
									$cut = "";
								}
								if($culet == "No")
								{
									$culet = "";
								}
								
								if($color == "No")
								{
									$color = "";
								}
								
								if($clarity == "No")
								{
									$clarity = "";
								}
								
								if($polish == "No")
								{
									$polish = "";
								}
								
								if($fluorescence == "No")
								{
									$fluorescence = "";
								}
								
								if($girdle == "No")
								{
									$girdle = "";
								}
								
								if($symmetry == "No" )
								{
									$symmetry = "";
								}
							
						
							$sqlQuery = "insert into `inventorynew` set
													`lotno` = '".$lotno."',
													`shape` = '".$shape."',
													`lab` = '".$lab."',
													
													`carat` = '".$carat."',
													`stone` = '".$stone."',
													`color` = '".$color."',
													`clarity` = '".$clarity."',
													`cut` = '".$cut."',
													`culet` = '".$culet."',
													`dimensions` = '".$dimensions."',
													`depth` = '".$depth."',
													`tabl` = '".$tabl."',
													`crown_angle` = '".$crown_angle."',
													`crown_height` = '".$crown_height."',
													`pavilion_height` = '".$pavilion_height."',
													`polish` = '".$polish."',
													`symmetry` = '".$symmetry."',
													`fluorescence` = '".$fluorescence."',
													`girdle` = '".$girdle."',
													`certificate` = '".$certificate."',
													`ppc` = '".$ppc."',
													`colorcode` = '".$colorcode."',
													`claritycode` = '".$claritycode."',
													`fancycolor` = '".$fancycolor."',
													`totalprice` = '".$totalprice."',
													`product_id` = '".$Id."'
											";
							
							$readresult = $write->query($sqlQuery);
						
							
							
						}else{
								Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Error During Update Inventory."));
						
						}
						
					}	
				}
				Mage::getSingleton("adminhtml/session")->addSuccess("Inventory updated.");
				$this->_redirect("*/*/new");
				return;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	}
 
 
 
 
 
	public function deleteAction() {
		if( $this->getRequest()->getParam("id") > 0 ) {
			try {
				$model = Mage::getModel("stud/stud");
				 
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
        $studIds = $this->getRequest()->getParam("stud");
        if(!is_array($studIds)) {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Please select item(s)"));
        } else {
            try {
                foreach ($studIds as $studId) {
                    $stud = Mage::getModel("stud/stud")->load($studId);
                    $stud->delete();
                }
                Mage::getSingleton("adminhtml/session")->addSuccess(
                    Mage::helper("adminhtml")->__(
                        "Total of %d record(s) were successfully deleted", count($studIds)
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
        $studIds = $this->getRequest()->getParam("stud");
        if(!is_array($studIds)) {
            Mage::getSingleton("adminhtml/session")->addError($this->__("Please select item(s)"));
        } else {
            try {
                foreach ($studIds as $studId) {
                    $stud = Mage::getSingleton("stud/stud")
                        ->load($studId)
                        ->setStatus($this->getRequest()->getParam("status"))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__("Total of %d record(s) were successfully updated", count($studIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect("*/*/index");
    }
  
    public function exportCsvAction()
    {
        $fileName   = "stud.csv";
        $content    = $this->getLayout()->createBlock("stud/adminhtml_stud_grid")
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = "stud.xml";
        $content    = $this->getLayout()->createBlock("stud/adminhtml_stud_grid")
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
    	return Mage::getSingleton('admin/session')->isAllowed('catalog/stud');
    }
}