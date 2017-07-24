<?php 
class Mage_Uploadtool_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function diamondSettings($field)
	{
		$uploadtool_settings = Mage::getSingleton("core/resource")->getTableName('uploadtool_settings');

		$read = Mage::getSingleton( 'core/resource' )->getConnection( 'core_read' );
		//$write = Mage::getSingleton( 'core/resource' )->getConnection( 'core_write' );
		
		$query = "select * from `$uploadtool_settings` where `field` = '".$field."'";
		$result = $read->query( $query );
		
		while ( $row = $result->fetch() ) {
			return $row['value'];
		}
	}
	
	public function alterMissingColumns() {
		
		$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');
		
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "source", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "spacialshape", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "frontviewimage", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "sideviewimage", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "gasviewimage", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "girdleviewimage", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "giacertimage", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "eglcertimage", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "certificate_url", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "image_or_video_link", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "ags_certificate", "VARCHAR( 255 ) NULL" );		
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "crown_height", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "crown_angle", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "pavilion_depth", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "pavilion_angle", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "photo2", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "photo3", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "photo4", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "photo5", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "photo6", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "photo7", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "culet_condition", "VARCHAR( 255 ) NULL" ); 
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "cash_price", "VARCHAR( 255 ) NULL" ); 
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "percent_rap", "VARCHAR( 255 ) NULL" );
		$this->add_column_if_not_exist($uploadtool_diamonds_inventory, "image_flag", "TINYINT(2)" );  
		
	}
	
	public function add_column_if_not_exist($table, $column, $column_attr = "VARCHAR( 255 ) NULL" ){
		$exists = false;
		$columns = mysql_query("show columns from $table");
		while($c = mysql_fetch_assoc($columns)){
			if($c['Field'] == $column){
				$exists = true;
				break;
			}
		}
		if(!$exists){
			mysql_query("ALTER TABLE `$table` ADD `$column`  $column_attr") or die(mysql_error());
		}
	}
	
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
	
			$uploadtool_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_vendor');
			$select_vendor = 'select * from `'.$uploadtool_vendor.'`';
	
			$result = mysql_query($select_vendor) or die(mysql_error());
			while($row = mysql_fetch_array($result))
			{
				//$SELLER_IDS[$row['vendor_id']] = $row['rap_percent'];
				//$SELLER_NAMES[$row['vendor_name']] = $row['rap_percent'];
				$vendorArray[] = $row['vendor_name'];
			}
	
			//$username = Mage::getStoreConfig('uploadtool/user_detail/ideal_username');
			//$password = Mage::getStoreConfig('uploadtool/user_detail/ideal_password');
			$username = Mage::helper('uploadtool')->diamondSettings('jewelerslink_username');
			$password = Mage::helper('uploadtool')->diamondSettings('jewelerslink_password');
	
			$data_string = json_encode($vendorArray);
	
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_URL,"http://www.jewelerslink.com/uploader/index/getjson");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array("username"=>$username,"password"=>$password,"vendors"=>$data_string));
			$data = curl_exec($ch);
			curl_close($ch);
			//echo $data;
	
			if($data == "Invalid Login") {
	
				//Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Unauthenticate Login, Go to http://www.jewelerslink.com and connect with us."));
				//$this->_redirect("*/*/new");
				return array("success"=>0,"message"=>"Unauthenticate Login, Go to ( Jewelerslink >> Manage Diamonds >> Settings ) and enter Jewelerslink Login Detail");
				exit;
	
			} else {
				//echo $data; exit;
				$csvData = json_decode($data, true);
				//echo "<pre>"; print_r($csvData);exit;
	
				$path = Mage::getBaseDir("var") . DS ."import" . DS;
				$fp = fopen($path."diamonds.csv", "w") or die("can't open jewelerslink file");
				foreach ($csvData as $fields) {
					fputcsv($fp, $fields);
				}
				fclose($fp);
	
				//Mage::getSingleton("adminhtml/session")->addSuccess("Successfully get list from Jewelerslink Inventory.");
				return array("success"=>1,"message"=>"Successfully get list from Jewelerslink Inventory.");
				//$this->_redirect("*/*/new");
			}
	
		}
		catch (Exception $e) {
			///Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			//$this->_redirect("*/*/new");
			return array("success"=>0,"message"=>$e->getMessage());
		}
	
	}
	
	public function getGoogleCsv() {
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
	
			$uploadtool_settings = Mage::getSingleton("core/resource")->getTableName('uploadtool_settings');
			
			$table = Mage::getSingleton('core/resource')->getTableName('uploadtool_settings');
			$query = "SELECT * FROM `$table` where `field` = 'google_csv' LIMIT 1";
			$result = @mysql_db_query($mdb_name, $query) or die("Failed Query of ".$query);
				
			$GoogleCsv = "";
			$row = mysql_fetch_array($result);
			$GoogleCsv = $row['value'];
				
			if(!$GoogleCsv) {
				//Mage::getSingleton("adminhtml/session")->addError("You must save Polygon User ID first");
				//$this->_redirect("*/*/new");
				//return;
				return array("success"=>0,"message"=>"You must save Google Csv first");
			}
			
			
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_URL,$GoogleCsv);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			$data = curl_exec($ch);
			curl_close($ch);
				
			$path = Mage::getBaseDir("var") . DS ."import" . DS . "google" . DS;

			if(!is_dir($path)) {
				mkdir($path, 0777, true);
			}
							
			$fp = fopen($path."google.csv", "w") or die("can't open Google CSV file");
			fputs($fp, rtrim($data));
			fclose($fp);
			
			//Mage::getSingleton("adminhtml/session")->addSuccess("Successfully get list from Jewelerslink Inventory.");
			return array("success"=>1,"message"=>"Successfully get list from Google Url.");
	
		}
		catch (Exception $e) {
			///Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			//$this->_redirect("*/*/new");
			return array("success"=>0,"message"=>$e->getMessage());
		}
	
	}
	
	
	public function saveCSV() {
	
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
	
			$this->alterMissingColumns();
	
			$path = Mage::getBaseDir("var") . DS ."import" . DS;
			$fp = fopen($path."diamonds.csv",'r') or die("can't open jewelerslink file");
			
			mysql_query("Delete from $uploadtool_diamonds_inventory where source = 'jewelerslink'") or die(mysql_error());
			
			$row=0;
			$count = 1;
			
			$stock = "select lotno,stock_number from `$uploadtool_diamonds_inventory`";
			$stockdata = mysql_query($stock);
			$stockgroup=array();
			$stock_Numbers=array();
			$i=0;
			while($stocksrecord=mysql_fetch_array($stockdata))
			{
				$stockgroup[$i] = $stocksrecord['lotno'];
				$stock_Numbers[$i] = $stocksrecord['stock_number'];
				$i++;
			}
						
			while($csv_line = fgetcsv($fp))
			{
				if($row==0){
					$row++;
					//echo "<pre>"; print_r($csv_line); exit;
					continue;
				}
				
				$girdleThin = $csv_line[24];
				$girdleThick = $csv_line[25];
				$girdle = "";
				if($girdleThin && $girdleThick) {
					$girdle = $girdleThin."-".$girdleThick;
				} elseif($girdleThin && !$girdleThick) {
					$girdle = $girdleThin;
				} elseif(!$girdleThin && $girdleThick) {
					$girdle = $girdleThick;
				} else {
					$girdle = "";
				}
				
				$length=$csv_line[14];
				$width=$csv_line[15];
				$ratio=0.0;
				if($length != '' && $width != '')
				{
					 $ratio=$length/$width;
				}
				
				if(in_array($csv_line[19], $stockgroup)) { continue; }
				if(in_array($csv_line[19], $stock_Numbers)) { continue; }
				
				$dimensions=$csv_line[13];
				if($dimensions == '') {
					if($csv_line[14] &&  $csv_line[15] && $csv_line[16])
					{
						$dimensions = $csv_line[14].'x'.$csv_line[15].'x'.$csv_line[16];
					}
				}
				/*
				$stock = "select *from `$uploadtool_diamonds_inventory` where lotno = '".$csv_line[19]."' ";
				$num_rows = mysql_query($stock);
				$num_rows = mysql_num_rows($num_rows) ;
				if($num_rows > 0) { continue; } */
				//		spacialshape = '".$csv_line[50]."',
				
				$qstring = "insert into `$uploadtool_diamonds_inventory` SET
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
							fluorescence = '".$csv_line[12]."',
							fluorescence_color = '".$csv_line[11]."',
							dimensions = '".$dimensions."',
							certificate = '".$csv_line[17]."',
							cert_number = '".$csv_line[18]."',
							stock_number = '".trim($csv_line[19])."',
							cost = '".$csv_line[20]."',
							totalprice = '".$csv_line[20]."',
							depth = '".$csv_line[21]."',
							tabl = '".$csv_line[22]."',
							girdle = '".$girdle."',
							culet = '".$csv_line[26]."',
							crown = '".$csv_line[27]."',
							pavilion = '".$csv_line[28]."',
							availability = '".$csv_line[29]."',
							city = '".$csv_line[30]."',
							state = '".$csv_line[31]."',
							country = '".$csv_line[32]."',
							number_stones = '".$csv_line[33]."',
							image = '".$csv_line[34]."',
							lotno = '".trim($csv_line[19])."', 
							make = '".$csv_line[36]."',
							percent_rap = '".$csv_line[39]."',
							ratio='".$ratio."',
							full_description = '".$csv_line[45]."',
							diamond_polices = '".$csv_line[46]."',
							gem_advisor = '".$csv_line[47]."',
							gia_facetware = '".$csv_line[48]."',
							helium_report = '".$csv_line[49]."',
							frontviewimage = '".$csv_line[51]."',
							sideviewimage = '".$csv_line[52]."',
							gasviewimage = '".$csv_line[53]."',
							girdleviewimage = '".$csv_line[54]."',
							giacertimage = '".$csv_line[55]."',
							eglcertimage = '".$csv_line[56]."', 
							certificate_url = '".$csv_line[57]."',
							image_or_video_link = '".$csv_line[58]."',
							ags_certificate = '".$csv_line[59]."',
							diamond_image = '".$csv_line[60]."',
							crown_height = '".$csv_line[61]."',
							crown_angle = '".$csv_line[62]."',
							pavilion_depth = '".$csv_line[63]."',
							pavilion_angle = '".$csv_line[64]."',
							cash_price = '".$csv_line[65]."',
							photo2 = '".$csv_line[66]."',
							photo3 = '".$csv_line[67]."',
							photo4 = '".$csv_line[68]."',
							photo5 = '".$csv_line[69]."',
							photo6 = '".$csv_line[70]."',
							photo7 = '".$csv_line[71]."',
							culet_condition = '".$csv_line[72]."',
							source = 'jewelerslink'";
							mysql_query($qstring) or die(mysql_error());
			}
	
			$this->applyPriceIncrease('jewelerslink');
			$this->updateRows();
	
			$sql = "select count(lotno) from `$uploadtool_diamonds_inventory` where source = 'jewelerslink' ";
			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
			$count = $row[0];
	
			return array("success"=>1,"message"=> $count." Diamond(s) Inserted from Jewelerslink.");
	
		}
		catch (Exception $e) {
			return array("success"=>0,"message" => $e->getMessage());
		}
	}
	
	public function applyPriceIncrease($source) {
		
		$uploadtool_price_increase = Mage::getSingleton("core/resource")->getTableName('uploadtool_price_increase');
		$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');

		$query = "SELECT * FROM `$uploadtool_price_increase`";
		$result= mysql_query($query);
		
		if($source != 'jewelerslink') 
		{	
				while($row = mysql_fetch_array($result))
				{
					$price_from[] = $row['price_from'];
					$price_to[] = $row['price_to'];
					
					$vendor_price_increase = $row['price_increase'];
					if($source != 'jewelerslink') {
						$price_increase_column = 'price_increase_'.$source;
						$vendor_price_increase = $row[$price_increase_column];
					}
					$price_increase_per = $vendor_price_increase/100 ;
					$price_increase_final[] = 1 + $price_increase_per ;
				}
						
				for($i=0; $i<100; $i++)
					{
					if(isset($price_increase_final[$i]) && ($price_increase_final[$i] != '')) {
						$query_update = "UPDATE `$uploadtool_diamonds_inventory` SET `totalprice` = cost*".$price_increase_final[$i]." where (`cost` BETWEEN ".$price_from[$i]." AND ".$price_to[$i] . ") AND source = '".$source."'";	
						//echo $query_update . "<br>";
						mysql_query($query_update) or die(mysql_error());
					}
				}
		}
		
		if($source == 'jewelerslink') 
		{	
			$uploadtool_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_vendor');
			$custom_query = "SELECT * FROM `$uploadtool_vendor`";
			$result_vendor = mysql_query($custom_query);  
			while($vendor_row = mysql_fetch_array($result_vendor)) 
			{
				$vendorNameJl = $vendor_row['vendor_name'];
				$price_increase_column_vende[] = array('price_increase_'.$vendorNameJl,$vendorNameJl);	
			}
			
			while($row = mysql_fetch_array($result))
			{
				$price_from = $row['price_from'];
				$price_to = $row['price_to'];
				foreach($price_increase_column_vende as $price_increase_column_vender) 
				{
					 
					$vendor_price_increase = $row[$price_increase_column_vender[0]];
					//echo "<br>" .$vendor_price_increase;
					$price_increase_per = $vendor_price_increase/100 ;
					$price_increase_final = 1 +$price_increase_per ;	 
					if(isset($price_increase_final) && ($price_increase_final != '')) 
					{	
						$query_update1 = "UPDATE `$uploadtool_diamonds_inventory` SET  `totalprice` = cost * ".$price_increase_final." where (`cost` BETWEEN ".$row['price_from']." AND ".$row['price_to'] . ") AND `source` = '".$source."' AND `owner` = '".$price_increase_column_vender[1]."'";	
						//echo $query_update1."<br>"; 
						mysql_query($query_update1) or die(mysql_error());	
					}
				}
			}
		}
		//exit;
	}
	
	public function updateRows() {
		
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
		
		mysql_query("DELETE FROM `$uploadtool_diamonds_inventory` where totalprice = 0.00 or carat=0 or (clarity='' AND fancy_intensity='')") or die(mysql_error());
		
		//updating bankwire_price
		$bankwire_per = 0;
		$table_us = Mage::getSingleton('core/resource')->getTableName('uploadtool_settings');
		$query_us = "SELECT * FROM `$table_us` where `field` = 'diamond_bankwire_price' LIMIT 1";
		$result_us = @mysql_db_query($mdb_name, $query_us) or die("Failed Query of ".$query);
		$row_us = mysql_fetch_array($result_us);
		if(is_array($row_us)){
			$bankwire_per = $row_us['value'];
			if($bankwire_per) $bankwire_per = $bankwire_per/100;
		}
		//$bankwire_price = round( $csv_line[20] - ($csv_line[20]*$bankwire_per/100));
		mysql_query("update `$uploadtool_diamonds_inventory` set `bankwire_price` = (`totalprice` - (`totalprice`*".$bankwire_per."))") or die(mysql_error());
		//ENDS updating bankwire_price
		
		mysql_query("DELETE FROM `$uploadtool_diamonds_inventory` where `source` = '' or `source` IS NULL ") or die(mysql_error());
		
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'ROUND' where `shape`='B' or `shape`='RB' or `shape`='BR'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'PRINCESS' where `shape` IN ('PR','Pri')") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'EMERALD' where `shape`='E' or `shape`='EC' or `shape`='Sq. Emerald' or `shape`='Em'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'ASSCHER' where `shape`='AS' or `shape`='AC'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'MARQUISE' where `shape`='M' or `shape`='MQ' or `shape`='Mq'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'OVAL' where `shape`='O' or `shape`='OV' or `shape`='OC'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'RADIANT' where `shape`='R' or `shape`='RAD' or `shape` = 'Square Radiant'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'PEAR' where `shape`='P' or `shape`='PS'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'CUSHION' where `shape`='C' or `shape`='CU' or `shape`='CMB' or `shape`='Cushion Modified'  or `shape`='Cush'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'HEART' where `shape`='H' or `shape`='HM' or `shape`='HS' or `shape`='Hrt' ") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'TRIANGULAR' where `shape`='TRI' or `shape`='T'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'TRILLION' where `shape`='Trillion' or `shape`='TRILLIANT'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'OLD_EUROPEAN' where `shape`='OLD EUROPEAN' or `shape`='EUROPEAN'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'VINTAGE_CUSHION' where `shape`='VINTAGE CUSHION'") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `shape` = 'RECTANGULAR_VINTAGE_CUSHION' where `shape`='RECTANGULAR VINTAGE CUSHION'") or die(mysql_error());
		
		mysql_query("DELETE FROM `$uploadtool_diamonds_inventory` WHERE `shape` NOT IN ('ROUND', 'PRINCESS', 'EMERALD', 'ASSCHER', 'MARQUISE', 'OVAL', 'RADIANT', 'PEAR', 'CUSHION', 'HEART', 'TRIANGULAR', 'TRILLIANT','TRILLION','OLD_EUROPEAN','VINTAGE_CUSHION','RECTANGULAR_VINTAGE_CUSHION','ascendancy_heart_arrows','platinum_select_round','august_vintage_european','the_solasfera_diamond','the_star_129','the_eighternity_diamond','august_vintage_cushion','august_vintage_star','platinum_select_vintage','platinum_select_modern','brellia_cushion_hearts','the_octavia_asscher','the_solasfera_princess','platinum_select_princess','ideal2_hearts_arrows')") or die(mysql_error());
		mysql_query("DELETE FROM `$uploadtool_diamonds_inventory` where lotno=''") or die(mysql_error());
		
		mysql_query("update `$uploadtool_diamonds_inventory` set `color` = fancycolor, `fancy_intensity` = 'L' where `fancy_intensity` IN ('LIGHT','Light','light','l','L')") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `color` = fancycolor, `fancy_intensity` = 'FL' where `fancy_intensity` IN ('Fancy Light','FANCY LIGHT','fancy light')") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `color` = fancycolor, `fancy_intensity` = 'F'  where `fancy_intensity` IN ('FANCY','Fancy','fancy','FC','F','Y')") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `color` = fancycolor, `fancy_intensity` = 'I' where `fancy_intensity` IN ('Fancy Intense','fancy intense','FANCY INTENSE','I')") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `color` = fancycolor, `fancy_intensity` = 'V' where `fancy_intensity` IN ('VIVID','Vivid','vivid','V','v')") or die(mysql_error());
		mysql_query("update `$uploadtool_diamonds_inventory` set `color` = fancycolor, `fancy_intensity` = 'D' where `fancy_intensity` IN ('Fancy Deep','FANCY DEEP','fancy deep','D','B')") or die(mysql_error());
		
		// Update cut To standards
		mysql_query("update `$uploadtool_diamonds_inventory` set `cut` = 'EX' where `cut` IN ('Excellent',' EX','ex','excellent','Excel')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `cut` = 'F' where `cut` IN ('Fair','fair','FR')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `cut` = 'G' where `cut` IN ('Good',' good','GOOD','GD')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `cut` = 'I' where `cut` IN ('Ideal',' ID','id','ideal','ID-0-')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `cut` = 'VG' where `cut` IN ('Very Good','Very')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `cut` = 'P' where `cut` IN ('Poor')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `cut` = '' where `cut` IN ('None')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `cut` = 'H&A' where `cut` IN ('Hearts & Arrows Ideal','Heart')");
		
		// Update symmetry To standards
		mysql_query("update `$uploadtool_diamonds_inventory` set `symmetry` = 'EX' where `symmetry` IN ('Excellent','E','ex','excellent')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `symmetry` = 'F' where `symmetry` IN ('Fair','fair')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `symmetry` = 'G' where `symmetry` IN ('Good','good','GD')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `symmetry` = 'I' where `symmetry` IN ('Ideal','ID','id','ideal')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `symmetry` = 'VG' where `symmetry` IN ('Very Good','very good','Very','Very ')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `symmetry` = 'P' where `symmetry` IN ('Poor','poor')");
			
		// Update polish To standards
		mysql_query("update `$uploadtool_diamonds_inventory` set `polish` = 'EX' where `polish` IN ('Excellent','E','ex','excellent')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `polish` = 'F' where `polish` IN ('Fair','fair')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `polish` = 'G' where `polish` IN ('Good','good')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `polish` = 'I' where `polish` IN ('Ideal','ID','id','ideal')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `polish` = 'VG' where `polish` IN ('Very Good','very good')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `polish` = 'P' where `polish` IN ('Poor','poor')");
		
		
		// Update culet To standards
		mysql_query("update `$uploadtool_diamonds_inventory` set `culet` = 'N' where `culet` IN ('','P','p','NONE','NON','none','non','POINTED','N/A')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `culet` = 'VS' where `culet` IN ('VSM','VS','VERY SMALL','V.S','vs','vsm','Very Small')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `culet` = 'S' where `culet` IN ('SML','Small','small','sml')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `culet` = 'M' where `culet` IN ('MED','Med','med','Medium','medium')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `culet` = 'SL' where `culet` IN ('sl','Slightly Large','Sl.Large','slightly large','sl.large')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `culet` = 'L' where `culet` IN ('LO','lo','Large','large')");
			
		// Update fluorescence To standards
		mysql_query("update `$uploadtool_diamonds_inventory` set `fluorescence` = 'F' where `fluorescence` IN ('Faint','FB','FNT','FaintBlue','VF')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `fluorescence` = 'M' where `fluorescence` IN ('Medium','MB','MED','MED Blue','MED White','MED Yellow','MY','MediumBlue')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `fluorescence` = 'N' where `fluorescence` IN ('None','NON','non','NIL','')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `fluorescence` = 'S' where `fluorescence` IN ('Strong','SB','STG','STG Blue','SY','STB','StrongBlue')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `fluorescence` = 'SL' where `fluorescence` IN ('SLT','Slight')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `fluorescence` = 'VS' where `fluorescence` IN ('Very Strong','VSB','VST','V','VST Blue','VSTG','Very Stron','Very Strong')");
		mysql_query("update `$uploadtool_diamonds_inventory` set `fluorescence` = 'VSL' where `fluorescence` IN ('Very Slight')");
		
		mysql_query("Update `$uploadtool_diamonds_inventory` set `certificate` = 'EGL USA' where `certificate` IN ('EGLLA','EGL LA','EGLNY','EGL NY')") or die(mysql_error());
		
		// Update bad images url To blank
		$imageFields = array('image', 'diamond_image', 'frontviewimage', 'sideviewimage', 'gasviewimage', 'girdleviewimage', 'giacertimage', 'eglcertimage', 'certificate_url', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6', 'photo7');
		foreach($imageFields as $imageField){
			mysql_query("Update `$uploadtool_diamonds_inventory` set `".$imageField."` = '' where (`".$imageField."` NOT LIKE '%.pdf')  and (`".$imageField."` NOT LIKE '%.jpg') AND (`".$imageField."` NOT LIKE '%.jpeg') AND (`".$imageField."` NOT LIKE '%.png') AND (`".$imageField."` NOT LIKE '%.gif')") or die(mysql_error());
		}
		
	    #mysql_query ( "update `diamonds_inventory` set `shape` = 'Pri' where `shape` IN ('Princess')" ) or die(mysql_error());
		#mysql_query ( "update `diamonds_inventory` set `shape` = 'Cush' where `shape` IN ('cu','cushion')") or die(mysql_error());
		
	}
	
	public function getRapnetList() {
		
		try
		{
			$user = Mage::helper('uploadtool')->diamondSettings('rapnet_username');
			$passwd = Mage::helper('uploadtool')->diamondSettings('rapnet_password');
			if($user == "" || $passwd == ""){
				//Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Please Enter valid RapNet Login Detail to settings"));
				//$this->_redirect("*/*/new");
				return array("success"=>0,"message"=>"Please Enter valid RapNet Login Detail to settings");
			}
		
			$auth_url = "https://technet.rapaport.com/HTTP/Authenticate.aspx";
			$post_string = "username=".$user."&password=" . urlencode($passwd);
		
			$request = curl_init($auth_url); //initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); //set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); //Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); //use HTTP POST to send form data
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); //uncomment this line if you get no gateway response.
			$auth_ticket = curl_exec($request); //execute curl post and store results in $auth_ticket
			$httpcode = curl_getinfo($request, CURLINFO_HTTP_CODE);
			curl_close ($request);
			if($httpcode != "200"){
				//Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Unauthenticate Login. Enter valid RapNet Login Detail to settings"));
				//$this->_redirect("*/*/new");
				return array("success"=>0,"message"=>"Unauthenticate Login. Enter valid RapNet Login Details to settings");
			}
				
			define('RAPNET_LINK', 'technet.rapaport.com/HTTP/DLS/GetFile.aspx?ticket='.$auth_ticket);
		
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
			
			$path = Mage::getBaseDir().DS."/var/import".DS."rapnet".DS;
			$fp = fopen($path."rapnet.csv", "w") or die("can't open file");
			fputs($fp, rtrim($CSV));
			fclose($fp);
		
			//Mage::getSingleton("adminhtml/session")->addSuccess("Successfully get list from RapNet Inventory.");
			//$this->_redirect("*/*/new");
			return array("success"=>1,"message"=>"Successfully get list from RapNet Inventory");
		}
		catch (Exception $e) {
			//Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			//$this->_redirect("*/*/new");
			//return;
			return array("success"=>0,"message"=>$e->getMessage());
		}
	}
	
	public function updateRapnetDiamonds() {
		
		ini_set('memory_limit','-1');
		ini_set('auto_detect_line_endings',TRUE);
		
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
			$uploadtool_settings = Mage::getSingleton("core/resource")->getTableName('uploadtool_settings');
		
			$this->alterMissingColumns();
		
			$lotnoMyCaseArray = explode ( ",", trim ( str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/lotno' ) ) ) ) );
			$ownerMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/owner' ) ) ) );
			$shapeMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/shape' ) ) ) );
			$caratMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/carat' ) ) ) );
			$colorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/color' ) ) ) );
			$clarityMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/clarity' ) ) ) );
			$cutMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cut' ) ) ) );
			$culetMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/culet' ) ) ) );
			$crownMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/crown' ) ) ) );
			$pavilionMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/pavilion' ) ) ) );
			$dimsMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/dimensions' ) ) ) );
			$m1MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m1' ) ) ) );
			$m2MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m2' ) ) ) );
			$m3MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m3' ) ) ) );
			$depthMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/depth' ) ) ) );
			$tablMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/tabl' ) ) ) );
			$polishMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/polish' ) ) ) );
			$symMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/symmetry' ) ) ) );
			$fluorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fluorescence' ) ) ) );
			$fluorIntMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fluorescence_intensity' ) ) ) );
			$girdleMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle' ) ) ) );
			$girthinMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle_thin' ) ) ) );
			$girthikMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle_thik' ) ) ) );
			$fcolorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancycolor' ) ) ) );
			$fintensMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancy_intensity' ) ) ) );
			$foverMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancy_overtone' ) ) ) );
			$cashpriceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cash_price' ) ) ) );
			$rappriceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/rap_price' ) ) ) );
			$rapdiscMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/rap_discount' ) ) ) );
			$pricecaratMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/price_per_carat' ) ) ) );
			$priceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/totalprice' ) ) ) );
			$labMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/lab' ) ) ) );
			$labCommentMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/labratory_comments' ) ) ) );
			$clarityCharMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/clarity_char' ) ) ) );
			$nostonesMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/number_stones' ) ) ) );
			$certnoMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cert_number' ) ) ) );
			$vstocknoMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/stock_number' ) ) ) );
			$makeMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/make' ) ) ) );
			$cityMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/city' ) ) ) );
			$stateMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/state' ) ) ) );
			$countryMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/country' ) ) ) );
			$imageMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/image' ) ) ) );
			$dimageMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/diamond_image' ) ) ) );
			$availMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/availability' ) ) ) );
			$insMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/inscription' ) ) ) );
			$treatMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/treatment' ) ) ) );
			$ktsMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/key_to_symbols' ) ) ) );
			//echo "<pre>"; print_r($lotnoMyCaseArray);exit;
			
			$path = Mage::getBaseDir("var") . DS ."import/rapnet" . DS;
			$fp = fopen($path."rapnet.csv",'r') or die("can't open rapnet file");
			
			mysql_query("Delete from $uploadtool_diamonds_inventory where source = 'rapnet'") or die(mysql_error());
			
			$row=0;
			$count = 1;
						
			while($csv_line = fgetcsv($fp)){
				if($row==0){
					
					$currentHeaders = $csv_line;
					foreach ( $currentHeaders as $key => $headerTitle ) {
						$headerTitle = str_replace ( " ", "", strtoupper ( $headerTitle ) );
						$headerTitle = trim ( $headerTitle );
							
						if (in_array ( $headerTitle, $shapeMyCaseArray )) {
							$shapeKey = $key;
						}
							
						if (in_array ( $headerTitle, $ownerMyCaseArray )) {
							$ownerKey = $key;
						}
						
						if (in_array ( $headerTitle, $caratMyCaseArray )) {
							$caratKey = $key;
						}
							
						if (in_array ( $headerTitle, $colorMyCaseArray )) {
							$colorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fcolorMyCaseArray )) {
							$fcolorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fintensMyCaseArray )) {
							$fcintsKey = $key;
						}
							
						if (in_array ( $headerTitle, $foverMyCaseArray )) {
							$fcolovtKey = $key;
						}
							
						if (in_array ( $headerTitle, $clarityMyCaseArray )) {
							$clarityKey = $key;
						}
							
						if (in_array ( $headerTitle, $cutMyCaseArray )) {
							$cutKey = $key;
						}
							
						if (in_array ( $headerTitle, $polishMyCaseArray )) {
							$polishKey = $key;
						}
							
						if (in_array ( $headerTitle, $symMyCaseArray )) {
							$symmetryKey = $key;
						}
							
						if (in_array ( $headerTitle, $fluorMyCaseArray )) {
							$flcolorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fluorIntMyCaseArray )) {
							$flintensKey = $key;
						}
							
						if (in_array ( $headerTitle, $dimsMyCaseArray )) {
							$dimensionsKey = $key;
						}
							
						if(in_array($headerTitle, $m1MyCaseArray)) {
							$m1Key = $key;
						}
						if(in_array($headerTitle, $m2MyCaseArray)) {
							$m2Key = $key;
						}
						if(in_array($headerTitle, $m3MyCaseArray)) {
							$m3Key = $key;
						}
							
						if (in_array ( $headerTitle, $labMyCaseArray )) {
							$labKey = $key;
						}
							
						if (in_array ( $headerTitle, $labCommentMyCaseArray )) {
							$labCommentKey = $key;
						}
							
						if (in_array ( $headerTitle, $clarityCharMyCaseArray )) {
							$clarityCharKey = $key;
						}
					
						if (in_array ( $headerTitle, $certnoMyCaseArray )) {
							$certnoKey = $key;
						}
							
						if (in_array ( $headerTitle, $lotnoMyCaseArray )) {
							$lotnoKey = $key;
						}
					
						if (in_array ( $headerTitle, $priceMyCaseArray )) {
							$priceKey = $key;
						}
							
						if (in_array ( $headerTitle, $pricecaratMyCaseArray ) && ($pricecaratKey =="")) {
							$pricecaratKey = $key;
						}
							
						if (in_array ( $headerTitle, $cashpriceMyCaseArray )) {
							$cashpriceKey = $key;
						}
					
						if (in_array ( $headerTitle, $rappriceMyCaseArray )) {
							$rappriceKey = $key;
						}
							
						if (in_array ( $headerTitle, $rapdiscMyCaseArray )) {
							$rapdiscKey = $key;
						}
							
						if (in_array ( $headerTitle, $depthMyCaseArray )) {
							$depthKey = $key;
						}
							
						if (in_array ( $headerTitle, $tablMyCaseArray )) {
							$tblKey = $key;
						}
					
						if (in_array ( $headerTitle, $girdleMyCaseArray )) {
							$girdleKey = $key;
						}
							
						if (in_array ( $headerTitle, $girthinMyCaseArray )) {
							$girthinKey = $key;
						}
							
						if (in_array ( $headerTitle, $girthikMyCaseArray )) {
							$girthickKey = $key;
						}
							
						if (in_array ( $headerTitle, $culetMyCaseArray )) {
							$culetKey = $key;
						}
							
						if (in_array ( $headerTitle, $crownMyCaseArray )) {
							$crownKey = $key;
						}
							
						if (in_array ( $headerTitle, $pavilionMyCaseArray )) {
							$pavilionKey = $key;
						}
							
						if (in_array ( $headerTitle, $cityMyCaseArray )) {
							$cityKey = $key;
						}
							
						if (in_array ( $headerTitle, $stateMyCaseArray )) {
							$stateKey = $key;
						}
							
						if (in_array ( $headerTitle, $countryMyCaseArray )) {
							$contryKey = $key;
						}
							
						if (in_array ( $headerTitle, $nostonesMyCaseArray )) {
							$nostoneKey = $key;
						}
							
						if (in_array ( $headerTitle, $imageMyCaseArray )) {
							$certimgKey = $key;
						}
					
						if (in_array ( $headerTitle, $dimageMyCaseArray )) {
							$dimgKey = $key;
						}
					
						if (in_array ( $headerTitle, $makeMyCaseArray )) {
							$makeKey = $key;
						}
							
						if (in_array ( $headerTitle, $availMyCaseArray )) {
							$availKey = $key;
						}
							
						if (in_array ( $headerTitle, $insMyCaseArray )) {
							$insKey = $key;
						}
							
						if (in_array ( $headerTitle, $treatMyCaseArray )) {
							$treatKey = $key;
						}
							
						if (in_array ( $headerTitle, $ktsMyCaseArray )) {
							$ktsKey = $key;
						}
					}
					$row++;
					continue;
				}
		
				$lotno = "";
				if(isset($csv_line[$lotnoKey])) {
					$lotno = $csv_line[$lotnoKey];
				}
				
				//echo $lotno; exit;
				if($lotno == "") {
					continue;
				}
				
				//owner
				$owner = "";
				if(isset($csv_line[$ownerKey])) {
					$owner = $csv_line[$ownerKey];
				}
				
				//shape
				$shape = "";
				if(isset($csv_line[$shapeKey])) {
					$shape = $csv_line[$shapeKey];	
				}
				
				//carat
				$carat = "";
				if(isset($csv_line[$caratKey])) {
					$carat = $csv_line[$caratKey];
				}
				
				//color
				$color = "";
				if(isset($csv_line[$colorKey])) {
					$color = $csv_line[$colorKey];
				}
				
				//clarity
				$clarity = "";
				if(isset($csv_line[$clarityKey])) {
					$clarity = $csv_line[$clarityKey];
				}
				
				//cut
				$cut = "";
				if(isset($csv_line[$cutKey])) {
					$cut = $csv_line[$cutKey];
				}
				
				//culet
				$culet = "";
				if(isset($csv_line[$culetKey])) {
					$culet = $csv_line[$culetKey];
				}
				
				//crown
				$crown = "";
				if(isset($csv_line[$crownKey])) {
					$crown = $csv_line[$crownKey];
				}
				
				//pavilion
				$pavilion = "";
				if(isset($csv_line[$pavilionKey])) {
					$pavilion = $csv_line[$pavilionKey];
				}
				
				//dimensions
				$dimensions = "";
				if(isset($csv_line[$dimensionsKey])) {
					$dimensions = $csv_line[$dimensionsKey];
				}
				
				//dim_height
				$dim_height = "";
				if(isset($csv_line[$m1Key])) {
					$dim_height = $csv_line[$m1Key];
				}
				
				//dim_width
				$dim_width = "";
				if(isset($csv_line[$m2Key])) {
					$dim_width = $csv_line[$m2Key];
				}
				
				//dim_depth
				$dim_depth = "";
				if(isset($csv_line[$m3Key])) {
					$dim_depth = $csv_line[$m3Key];
				}
				
				if($dimensions != "") {
					$dim = $dimensions;
					$findme = '-';
					$dash_dim = strpos ( $dim, $findme );
				
					if ($dash_dim == true) {
						$dim_h_w_d = explode ( "x", $dim );
						$dim_h_w = trim ( $dim_h_w_d [0] );
						$remove_dash = explode ( "-", $dim_h_w );
						$dim_height = trim ( $remove_dash [0] );
						$dim_width = trim ( $remove_dash [1] );
						$dim_depth = trim ( $dim_h_w_d [1] );
					} else if(strpos ( $dim, "X" ) == true) {
						$dim_h_w_d = explode ( "X", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					} else if(strpos ( $dim, "*" ) == true) {
						$dim_h_w_d = explode ( "*", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					} else {
						$dim_h_w_d = explode ( "x", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					}
				
				
				} else {
				
					if($dim_height != "" && $dim_width != "" && $dim_depth != "") {
						$dimensions = $dim_height.'x'.$dim_width.'x'.$dim_depth;
					}
				
				}
				//ratio
				$ratio = "";
				if($dim_height != "" && $dim_width != "") {
					$ratio = number_format($dim_height/$dim_width, 2, '.', '');
				}
				//echo $dimensions."===".$dim_height."===".$dim_width."===".$dim_depth."===".$ratio; exit;
				
				//depth
				$depth = "";
				if(isset($csv_line[$depthKey])) {
					$depth = $csv_line[$depthKey];
				}
				
				//tabl
				$tabl = "";
				if(isset($csv_line[$tblKey])) {
					$tabl = $csv_line[$tblKey];
				}
				
				//polish
				$polish = "";
				if(isset($csv_line[$polishKey])) {
					$polish = $csv_line[$polishKey];
				}
				
				//symmetry
				$symmetry = "";
				if(isset($csv_line[$symmetryKey])) {
					$symmetry = $csv_line[$symmetryKey];
				}
				
				//fluorescence
				$fluorescence = "";
				if(isset($csv_line[$flcolorKey])) {
					$fluorescence = $csv_line[$flcolorKey];
				}
				//fluorescence_intensity
				$fluorescence_intensity = "";
				if(isset($csv_line[$flintensKey])) {
					$fluorescence_intensity = $csv_line[$flintensKey];
				}
				
				//girdle
				$girdle = "";
				if(isset($csv_line[$girdleKey])) {
					$girdle = $csv_line[$girdleKey];
				}
				
				//girdle_min
				$girdle_min = "";
				if(isset($csv_line[$girthinKey])) {
					$girdle_min = $csv_line[$girthinKey];
				}
				
				//girdle_max
				$girdle_max = "";
				if(isset($csv_line[$girthickKey])) {
					$girdle_max = $csv_line[$girthickKey];
				}
				//echo $girdle . "===" . $girdle_min ."===". $girdle_max; exit;
				
				//fancy_intensity
				$fancy_intensity = "";
				if(isset($csv_line[$fcintsKey])) {
					$fancy_intensity = $csv_line[$fcintsKey];
				}
				
				//fancycolor
				$fancycolor = "";
				if(isset($csv_line[$fcolorKey])) {
					$fancycolor = $csv_line[$fcolorKey];
				}
				
				//fancy_overtone
				$fancy_overtone = "";
				if(isset($csv_line[$fcolovtKey])) {
					$fancy_overtone = $csv_line[$fcolovtKey];
				}
				
				//totalprice
				$totalprice = "";
				if(isset($csv_line[$priceKey])) {
					$totalprice = $csv_line[$priceKey];
				}
				
				//price_per_carat
				$price_per_carat = "";
				if(isset($csv_line[$pricecaratKey])) {
					$price_per_carat = $csv_line[$pricecaratKey];
				}
				
				//rap_price
				$rap_price = "";
				if(isset($csv_line[$rappriceKey])) {
					$rap_price = $csv_line[$rappriceKey];
				}
				
				//percent_rap
				$percent_rap = "";
				if(isset($csv_line[$rapdiscKey])) {
					$percent_rap = $csv_line[$rapdiscKey];
				}
				
				$discChars = array("-","%");
				$priceChars = array(",","$");
				
				$percent_rap = str_replace($discChars,"",$percent_rap);
				$totalprice = str_replace($priceChars,"",$totalprice);
				$price_per_carat = str_replace($priceChars,"",$price_per_carat);
				$rap_price = str_replace($priceChars,"",$rap_price);
				
				
				if($price_per_carat == "" && $totalprice != "") {
					$price_per_carat = $totalprice/$carat;
				}
				if($totalprice == "" && $price_per_carat != "") {
					$totalprice = $price_per_carat*$carat;
				}
				
				if($totalprice == "" && $price_per_carat == "") {
					if($rap_price != "") {
						$rap_disc = str_replace("-","",$percent_rap);
						$rap_disc = (100-$rap_disc)/100;
				
						$totalprice =  $rap_price*$carat*$rap_disc; //cost = rap price * carat weight * discount
						$price_per_carat = $totalprice/$carat;
					}
				}
				
				//echo $lotno."--".$totalprice."--".$price_per_carat; exit;
				
				//Lab
				$Lab = "";
				if(isset($csv_line[$labKey])) {
					$Lab = $csv_line[$labKey];
				}
				
				//number_stones
				$number_stones = "";
				if(isset($csv_line[$nostoneKey])) {
					$number_stones = $csv_line[$nostoneKey];
				}
				
				//cert_number
				$cert_number = "";
				if(isset($csv_line[$certnoKey])) {
					$cert_number = $csv_line[$certnoKey];
				}
				
				//make
				$make = "";
				if(isset($csv_line[$makeKey])) {
					$make = $csv_line[$makeKey];
				}
				
				//city
				$city = "";
				if(isset($csv_line[$cityKey])) {
					$city = $csv_line[$cityKey];
				}
				
				//state
				$state = "";
				if(isset($csv_line[$stateKey])) {
					$state = $csv_line[$stateKey];
				}
				
				//country
				$country = "";
				if(isset($csv_line[$contryKey])) {
					$country = $csv_line[$contryKey];
				}
				
				//image
				$image = "";
				if(isset($csv_line[$certimgKey])) {
					$image = $csv_line[$certimgKey];
				}
				
				//diamond_image
				$dimgKey = "";
				if(isset($csv_line[$dimgKey])) {
					$dimage = $csv_line[$dimgKey];
				}
				
				//availability
				$availability = "";
				if(isset($csv_line[$availKey])) {
					$availability = $csv_line[$availKey];
				} 
				
				//comment
				$comment = "";
				if(isset($csv_line[$labCommentKey])) {
					$comment = $csv_line[$labCommentKey];
				}
				
				//clarity_char
				$clarity_char = "";
				if(isset($csv_line[$clarityCharKey])) {
					$clarity_char = $csv_line[$clarityCharKey];
				}
				
				//key_to_symbol
				$key_to_symbol = "";
				if(isset($csv_line[$ktsKey])) {
					$key_to_symbol = $csv_line[$ktsKey];
				}
				
				//treatment
				$treatment = "";
				if(isset($csv_line[$treatKey])) {
					$treatment = $csv_line[$treatKey];
				}
								
				$qstring = "insert into `$uploadtool_diamonds_inventory` SET
						owner = '".mysql_real_escape_string($owner)."',
						shape = '".$shape."',
						carat = '".(intval(($carat*100))/100)."',
						color = '".$color."',
						fancycolor = '".($fancycolor)."',
						fancy_intensity = '".($fancy_intensity)."',
						clarity = '".($clarity)."',
						cut = '".($cut)."',
						polish = '".($polish)."',
						symmetry = '".($symmetry)."',
						fluorescence = '".($fluorescence_intensity)."',
						fluorescence_color = '".$fluorescence."',
						dimensions = '".($dimensions)."',
						Lab = '".($Lab)."',
						certificate = '".($Lab)."',
						cert_number = '".($cert_number)."',
						stock_number = '".trim($lotno)."',
						cost = '".round($totalprice)."',
						totalprice = '".round($totalprice)."',
						depth = '".($depth)."',
						tabl = '".($tabl)."',
						girdle = '".($girdle)."',
						culet = '".($culet)."',
						crown = '".($crown)."',
						pavilion = '".($pavilion)."',
						availability = '".($availability)."',
						city = '".mysql_real_escape_string($city)."',
						state = '".($state)."',
						country = '".($country)."',
						lotno = '".trim($lotno)."',
						percent_rap = '".$percent_rap."',
						number_stones = '".($number_stones)."',
						image = '".mysql_real_escape_string($image)."',
						diamond_image = '".mysql_real_escape_string($dimage)."',
						source = 'rapnet'";
		
				mysql_query($qstring) or die(mysql_error()."==>".$qstring);
				//echo $qstring; exit;
			}
		
			$this->applyPriceIncrease('rapnet');
			$this->updateRows();
			
			$sql = "select count(lotno) from $uploadtool_diamonds_inventory  where source = 'rapnet'";
			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
			$count = $row[0];
		
			return array("success"=>1,"message"=>$count." Diamond(s) Inserted from Rapnet.");
		}
		catch (Exception $e) {
			//Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			//$this->_redirect("*/*/new");
			return array("success"=>0,"message"=>$e->getMessage());
		}	
	}

	public function importPolygon() {
	
		ini_set('memory_limit','-1');
		ini_set('auto_detect_line_endings',TRUE);
	
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
	
			$lotnoMyCaseArray = explode ( ",", trim ( str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/lotno' ) ) ) ) );
			$ownerMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/owner' ) ) ) );
			$shapeMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/shape' ) ) ) );
			$caratMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/carat' ) ) ) );
			$colorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/color' ) ) ) );
			$clarityMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/clarity' ) ) ) );
			$cutMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cut' ) ) ) );
			$culetMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/culet' ) ) ) );
			$crownMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/crown' ) ) ) );
			$pavilionMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/pavilion' ) ) ) );
			$dimsMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/dimensions' ) ) ) );
			$m1MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m1' ) ) ) );
			$m2MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m2' ) ) ) );
			$m3MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m3' ) ) ) );
			$depthMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/depth' ) ) ) );
			$tablMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/tabl' ) ) ) );
			$polishMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/polish' ) ) ) );
			$symMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/symmetry' ) ) ) );
			$fluorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fluorescence' ) ) ) );
			$fluorIntMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fluorescence_intensity' ) ) ) );
			$girdleMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle' ) ) ) );
			$girthinMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle_thin' ) ) ) );
			$girthikMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle_thik' ) ) ) );
			$fcolorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancycolor' ) ) ) );
			$fintensMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancy_intensity' ) ) ) );
			$foverMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancy_overtone' ) ) ) );
			$cashpriceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cash_price' ) ) ) );
			$rappriceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/rap_price' ) ) ) );
			$rapdiscMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/rap_discount' ) ) ) );
			$pricecaratMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/price_per_carat' ) ) ) );
			$priceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/totalprice' ) ) ) );
			$labMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/lab' ) ) ) );
			$labCommentMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/labratory_comments' ) ) ) );
			$clarityCharMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/clarity_char' ) ) ) );
			$nostonesMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/number_stones' ) ) ) );
			$certnoMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cert_number' ) ) ) );
			$vstocknoMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/stock_number' ) ) ) );
			$makeMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/make' ) ) ) );
			$cityMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/city' ) ) ) );
			$stateMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/state' ) ) ) );
			$countryMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/country' ) ) ) );
			$imageMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/image' ) ) ) );
			$dimageMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/diamond_image' ) ) ) );
			$availMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/availability' ) ) ) );
			$insMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/inscription' ) ) ) );
			$treatMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/treatment' ) ) ) );
			$ktsMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/key_to_symbols' ) ) ) );
			//echo "<pre>"; print_r($lotnoMyCaseArray);exit;
			
			$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');
			$uploadtool_price_increase = Mage::getSingleton("core/resource")->getTableName('uploadtool_price_increase');
			$uploadtool_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_vendor');
			$uploadtool_settings = Mage::getSingleton("core/resource")->getTableName('uploadtool_settings');
			
			$table = Mage::getSingleton('core/resource')->getTableName('uploadtool_settings');
			$query = "SELECT * FROM `$table` where `field` = 'polygon_id' LIMIT 1";
			$result = @mysql_db_query($mdb_name, $query) or die("Failed Query of ".$query);
				
			$PolygonId = "";
			$row = mysql_fetch_array($result);
			$PolygonId = $row['value'];
				
			if(!$PolygonId) {
				//Mage::getSingleton("adminhtml/session")->addError("You must save Polygon User ID first");
				//$this->_redirect("*/*/new");
				//return;
				return array("success"=>0,"message"=>"You must save Polygon User ID first");
			}
				
			$path = Mage::getBaseDir("var") . DS ."import" . DS . "polygon" . DS;
				
			if(!file_exists($path.$PolygonId.".csv")) {
				//Mage::getSingleton("adminhtml/session")->addError("There is no file uploaded on Polygon FTP for Id:".$PolygonId);
				//$this->_redirect("*/*/new");
				//return;
				return array("success"=>0,"message"=>"There is no file uploaded on Polygon FTP for Id:".$PolygonId);
			}
				
			$this->alterMissingColumns();
			
			mysql_query("Delete from $uploadtool_diamonds_inventory where source = 'polygon'") or die(mysql_error());
			
			$fp = fopen($path.$PolygonId.".csv",'r') or die("can't open polygon file");
			
			$row=0;
			$count = 1;
						
			while($csv_line = fgetcsv($fp)){
				if($row==0){
						
					$currentHeaders = $csv_line;
					foreach ( $currentHeaders as $key => $headerTitle ) {
						$headerTitle = str_replace ( " ", "", strtoupper ( $headerTitle ) );
						$headerTitle = trim ( $headerTitle );
							
						if (in_array ( $headerTitle, $shapeMyCaseArray )) {
							$shapeKey = $key;
						}
							
						if (in_array ( $headerTitle, $ownerMyCaseArray )) {
							$ownerKey = $key;
						}
	
						if (in_array ( $headerTitle, $caratMyCaseArray )) {
							$caratKey = $key;
						}
							
						if (in_array ( $headerTitle, $colorMyCaseArray )) {
							$colorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fcolorMyCaseArray )) {
							$fcolorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fintensMyCaseArray )) {
							$fcintsKey = $key;
						}
							
						if (in_array ( $headerTitle, $foverMyCaseArray )) {
							$fcolovtKey = $key;
						}
							
						if (in_array ( $headerTitle, $clarityMyCaseArray )) {
							$clarityKey = $key;
						}
							
						if (in_array ( $headerTitle, $cutMyCaseArray )) {
							$cutKey = $key;
						}
							
						if (in_array ( $headerTitle, $polishMyCaseArray )) {
							$polishKey = $key;
						}
							
						if (in_array ( $headerTitle, $symMyCaseArray )) {
							$symmetryKey = $key;
						}
							
						if (in_array ( $headerTitle, $fluorMyCaseArray )) {
							$flcolorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fluorIntMyCaseArray )) {
							$flintensKey = $key;
						}
							
						if (in_array ( $headerTitle, $dimsMyCaseArray )) {
							$dimensionsKey = $key;
						}
							
						if(in_array($headerTitle, $m1MyCaseArray)) {
							$m1Key = $key;
						}
						if(in_array($headerTitle, $m2MyCaseArray)) {
							$m2Key = $key;
						}
						if(in_array($headerTitle, $m3MyCaseArray)) {
							$m3Key = $key;
						}
							
						if (in_array ( $headerTitle, $labMyCaseArray )) {
							$labKey = $key;
						}
							
						if (in_array ( $headerTitle, $labCommentMyCaseArray )) {
							$labCommentKey = $key;
						}
							
						if (in_array ( $headerTitle, $clarityCharMyCaseArray )) {
							$clarityCharKey = $key;
						}
							
						if (in_array ( $headerTitle, $certnoMyCaseArray )) {
							$certnoKey = $key;
						}
							
						if (in_array ( $headerTitle, $lotnoMyCaseArray )) {
							$lotnoKey = $key;
						}
							
						if (in_array ( $headerTitle, $priceMyCaseArray )) {
							$priceKey = $key;
						}
							
						if (in_array ( $headerTitle, $pricecaratMyCaseArray ) && ($pricecaratKey =="")) {
							$pricecaratKey = $key;
						}
							
						if (in_array ( $headerTitle, $cashpriceMyCaseArray )) {
							$cashpriceKey = $key;
						}
							
						if (in_array ( $headerTitle, $rappriceMyCaseArray )) {
							$rappriceKey = $key;
						}
							
						if (in_array ( $headerTitle, $rapdiscMyCaseArray )) {
							$rapdiscKey = $key;
						}
							
						if (in_array ( $headerTitle, $depthMyCaseArray )) {
							$depthKey = $key;
						}
							
						if (in_array ( $headerTitle, $tablMyCaseArray )) {
							$tblKey = $key;
						}
							
						if (in_array ( $headerTitle, $girdleMyCaseArray )) {
							$girdleKey = $key;
						}
							
						if (in_array ( $headerTitle, $girthinMyCaseArray )) {
							$girthinKey = $key;
						}
							
						if (in_array ( $headerTitle, $girthikMyCaseArray )) {
							$girthickKey = $key;
						}
							
						if (in_array ( $headerTitle, $culetMyCaseArray )) {
							$culetKey = $key;
						}
							
						if (in_array ( $headerTitle, $crownMyCaseArray )) {
							$crownKey = $key;
						}
							
						if (in_array ( $headerTitle, $pavilionMyCaseArray )) {
							$pavilionKey = $key;
						}
							
						if (in_array ( $headerTitle, $cityMyCaseArray )) {
							$cityKey = $key;
						}
							
						if (in_array ( $headerTitle, $stateMyCaseArray )) {
							$stateKey = $key;
						}
							
						if (in_array ( $headerTitle, $countryMyCaseArray )) {
							$contryKey = $key;
						}
							
						if (in_array ( $headerTitle, $nostonesMyCaseArray )) {
							$nostoneKey = $key;
						}
							
						if (in_array ( $headerTitle, $imageMyCaseArray )) {
							$certimgKey = $key;
						}
							
						if (in_array ( $headerTitle, $dimageMyCaseArray )) {
							$dimgKey = $key;
						}
							
						if (in_array ( $headerTitle, $makeMyCaseArray )) {
							$makeKey = $key;
						}
							
						if (in_array ( $headerTitle, $availMyCaseArray )) {
							$availKey = $key;
						}
							
						if (in_array ( $headerTitle, $insMyCaseArray )) {
							$insKey = $key;
						}
							
						if (in_array ( $headerTitle, $treatMyCaseArray )) {
							$treatKey = $key;
						}
							
						if (in_array ( $headerTitle, $ktsMyCaseArray )) {
							$ktsKey = $key;
						}
					}
					$row++;
					continue;
				}
	
				$lotno = "";
				if(isset($csv_line[$lotnoKey])) {
					$lotno = $csv_line[$lotnoKey];
				}
	
				//echo $lotno; exit;
				if($lotno == "") {
					continue;
				}
	
				//owner
				$owner = "";
				if(isset($csv_line[$ownerKey])) {
					$owner = $csv_line[$ownerKey];
				}
	
				//shape
				$shape = "";
				if(isset($csv_line[$shapeKey])) {
					$shape = $csv_line[$shapeKey];
				}
	
				//carat
				$carat = "";
				if(isset($csv_line[$caratKey])) {
					$carat = $csv_line[$caratKey];
				}
	
				//color
				$color = "";
				if(isset($csv_line[$colorKey])) {
					$color = $csv_line[$colorKey];
				}
	
				//clarity
				$clarity = "";
				if(isset($csv_line[$clarityKey])) {
					$clarity = $csv_line[$clarityKey];
				}
	
				//cut
				$cut = "";
				if(isset($csv_line[$cutKey])) {
					$cut = $csv_line[$cutKey];
				}
	
				//culet
				$culet = "";
				if(isset($csv_line[$culetKey])) {
					$culet = $csv_line[$culetKey];
				}
	
				//crown
				$crown = "";
				if(isset($csv_line[$crownKey])) {
					$crown = $csv_line[$crownKey];
				}
	
				//pavilion
				$pavilion = "";
				if(isset($csv_line[$pavilionKey])) {
					$pavilion = $csv_line[$pavilionKey];
				}
	
				//dimensions
				$dimensions = "";
				if(isset($csv_line[$dimensionsKey])) {
					$dimensions = $csv_line[$dimensionsKey];
				}
	
				//dim_height
				$dim_height = "";
				if(isset($csv_line[$m1Key])) {
					$dim_height = $csv_line[$m1Key];
				}
	
				//dim_width
				$dim_width = "";
				if(isset($csv_line[$m2Key])) {
					$dim_width = $csv_line[$m2Key];
				}
	
				//dim_depth
				$dim_depth = "";
				if(isset($csv_line[$m3Key])) {
					$dim_depth = $csv_line[$m3Key];
				}
	
				if($dimensions != "") {
					$dim = $dimensions;
					$findme = '-';
					$dash_dim = strpos ( $dim, $findme );
	
					if ($dash_dim == true) {
						$dim_h_w_d = explode ( "x", $dim );
						$dim_h_w = trim ( $dim_h_w_d [0] );
						$remove_dash = explode ( "-", $dim_h_w );
						$dim_height = trim ( $remove_dash [0] );
						$dim_width = trim ( $remove_dash [1] );
						$dim_depth = trim ( $dim_h_w_d [1] );
					} else if(strpos ( $dim, "X" ) == true) {
						$dim_h_w_d = explode ( "X", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					} else if(strpos ( $dim, "*" ) == true) {
						$dim_h_w_d = explode ( "*", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					} else {
						$dim_h_w_d = explode ( "x", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					}
	
	
				} else {
	
					if($dim_height != "" && $dim_width != "" && $dim_depth != "") {
						$dimensions = $dim_height.'x'.$dim_width.'x'.$dim_depth;
					}
	
				}
				//ratio
				$ratio = "";
				if($dim_height != "" && $dim_width != "") {
					$ratio = number_format($dim_height/$dim_width, 2, '.', '');
				}
				//echo $dimensions."===".$dim_height."===".$dim_width."===".$dim_depth."===".$ratio; exit;
	
				//depth
				$depth = "";
				if(isset($csv_line[$depthKey])) {
					$depth = $csv_line[$depthKey];
				}
	
				//tabl
				$tabl = "";
				if(isset($csv_line[$tblKey])) {
					$tabl = $csv_line[$tblKey];
				}
	
				//polish
				$polish = "";
				if(isset($csv_line[$polishKey])) {
					$polish = $csv_line[$polishKey];
				}
	
				//symmetry
				$symmetry = "";
				if(isset($csv_line[$symmetryKey])) {
					$symmetry = $csv_line[$symmetryKey];
				}
	
				//fluorescence
				$fluorescence = "";
				if(isset($csv_line[$flcolorKey])) {
					$fluorescence = $csv_line[$flcolorKey];
				}
				//fluorescence_intensity
				$fluorescence_intensity = "";
				if(isset($csv_line[$flintensKey])) {
					$fluorescence_intensity = $csv_line[$flintensKey];
				}
	
				//girdle
				$girdle = "";
				if(isset($csv_line[$girdleKey])) {
					$girdle = $csv_line[$girdleKey];
				}
	
				//girdle_min
				$girdle_min = "";
				if(isset($csv_line[$girthinKey])) {
					$girdle_min = $csv_line[$girthinKey];
				}
	
				//girdle_max
				$girdle_max = "";
				if(isset($csv_line[$girthickKey])) {
					$girdle_max = $csv_line[$girthickKey];
				}
				//echo $girdle . "===" . $girdle_min ."===". $girdle_max; exit;
	
				//fancy_intensity
				$fancy_intensity = "";
				if(isset($csv_line[$fcintsKey])) {
					$fancy_intensity = $csv_line[$fcintsKey];
				}
	
				//fancycolor
				$fancycolor = "";
				if(isset($csv_line[$fcolorKey])) {
					$fancycolor = $csv_line[$fcolorKey];
				}
	
				//fancy_overtone
				$fancy_overtone = "";
				if(isset($csv_line[$fcolovtKey])) {
					$fancy_overtone = $csv_line[$fcolovtKey];
				}
	
				//totalprice
				$totalprice = "";
				if(isset($csv_line[$priceKey])) {
					$totalprice = $csv_line[$priceKey];
				}
	
				//price_per_carat
				$price_per_carat = "";
				if(isset($csv_line[$pricecaratKey])) {
					$price_per_carat = $csv_line[$pricecaratKey];
				}
	
				//rap_price
				$rap_price = "";
				if(isset($csv_line[$rappriceKey])) {
					$rap_price = $csv_line[$rappriceKey];
				}
	
				//percent_rap
				$percent_rap = "";
				if(isset($csv_line[$rapdiscKey])) {
					$percent_rap = $csv_line[$rapdiscKey];
				}
	
				$discChars = array("-","%");
				$priceChars = array(",","$");
	
				$percent_rap = str_replace($discChars,"",$percent_rap);
				$totalprice = str_replace($priceChars,"",$totalprice);
				$price_per_carat = str_replace($priceChars,"",$price_per_carat);
				$rap_price = str_replace($priceChars,"",$rap_price);
	
	
				if($price_per_carat == "" && $totalprice != "") {
					$price_per_carat = $totalprice/$carat;
				}
				if($totalprice == "" && $price_per_carat != "") {
					$totalprice = $price_per_carat*$carat;
				}
	
				if($totalprice == "" && $price_per_carat == "") {
					if($rap_price != "") {
						$rap_disc = str_replace("-","",$percent_rap);
						$rap_disc = (100-$rap_disc)/100;
	
						$totalprice =  $rap_price*$carat*$rap_disc; //cost = rap price * carat weight * discount
						$price_per_carat = $totalprice/$carat;
					}
				}
	
				//echo $lotno."--".$totalprice."--".$price_per_carat; exit;
	
				//Lab
				$Lab = "";
				if(isset($csv_line[$labKey])) {
					$Lab = $csv_line[$labKey];
				}
	
				//number_stones
				$number_stones = "";
				if(isset($csv_line[$nostoneKey])) {
					$number_stones = $csv_line[$nostoneKey];
				}
	
				//cert_number
				$cert_number = "";
				if(isset($csv_line[$certnoKey])) {
					$cert_number = $csv_line[$certnoKey];
				}
	
				//make
				$make = "";
				if(isset($csv_line[$makeKey])) {
					$make = $csv_line[$makeKey];
				}
	
				//city
				$city = "";
				if(isset($csv_line[$cityKey])) {
					$city = $csv_line[$cityKey];
				}
	
				//state
				$state = "";
				if(isset($csv_line[$stateKey])) {
					$state = $csv_line[$stateKey];
				}
	
				//country
				$country = "";
				if(isset($csv_line[$contryKey])) {
					$country = $csv_line[$contryKey];
				}
	
				//image
				$image = "";
				if(isset($csv_line[$certimgKey])) {
					$image = $csv_line[$certimgKey];
				}
	
				//diamond_image
				$dimgKey = "";
				if(isset($csv_line[$dimgKey])) {
					$dimage = $csv_line[$dimgKey];
				}
	
				//availability
				$availability = "";
				if(isset($csv_line[$availKey])) {
					$availability = $csv_line[$availKey];
				}
	
				//comment
				$comment = "";
				if(isset($csv_line[$labCommentKey])) {
					$comment = $csv_line[$labCommentKey];
				}
	
				//clarity_char
				$clarity_char = "";
				if(isset($csv_line[$clarityCharKey])) {
					$clarity_char = $csv_line[$clarityCharKey];
				}
	
				//key_to_symbol
				$key_to_symbol = "";
				if(isset($csv_line[$ktsKey])) {
					$key_to_symbol = $csv_line[$ktsKey];
				}
	
				//treatment
				$treatment = "";
				if(isset($csv_line[$treatKey])) {
					$treatment = $csv_line[$treatKey];
				}
					
				$qstring = "insert into `$uploadtool_diamonds_inventory` SET
						owner = '".mysql_real_escape_string($owner)."',
						shape = '".$shape."',
						carat = '".(intval(($carat*100))/100)."',
						color = '".$color."',
						fancycolor = '".($fancycolor)."',
						fancy_intensity = '".($fancy_intensity)."',
						clarity = '".($clarity)."',
						cut = '".($cut)."',
						polish = '".($polish)."',
						symmetry = '".($symmetry)."',
						fluorescence = '".($fluorescence_intensity)."',
						fluorescence_color = '".$fluorescence."',
						dimensions = '".($dimensions)."',
						Lab = '".($Lab)."',
						certificate = '".($Lab)."',
						cert_number = '".($cert_number)."',
						stock_number = '".trim($lotno)."',
						cost = '".round($totalprice)."',
						totalprice = '".round($totalprice)."',
						depth = '".($depth)."',
						tabl = '".($tabl)."',
						girdle = '".($girdle)."',
						culet = '".($culet)."',
						crown = '".($crown)."',
						pavilion = '".($pavilion)."',
						availability = '".($availability)."',
						city = '".($city)."',
						state = '".($state)."',
						country = '".($country)."',
						lotno = '".trim($lotno)."',
						percent_rap = '".$percent_rap."',
						number_stones = '".($number_stones)."',
						image = '".mysql_real_escape_string($image)."',
						diamond_image = '".mysql_real_escape_string($dimage)."',
						source = 'polygon'";
	
				mysql_query($qstring) or die(mysql_error());
				//echo $qstring; exit;
			}
	
			$this->applyPriceIncrease('polygon');
			$this->updateRows();
				
			$sql = "select count(lotno) from `$uploadtool_diamonds_inventory` where source = 'polygon'";
			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
			$count = $row[0];
	
			return array("success"=>1,"message"=>$count." Diamond(s) Inserted from Polygon.");
		}
		catch (Exception $e) {
			//Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			//$this->_redirect("*/*/new");
			return array("success"=>0,"message"=>$e->getMessage());
		}
	}
	
	public function importGoogle() {
	
		ini_set('memory_limit','-1');
		ini_set('auto_detect_line_endings',TRUE);
	
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
	
			$lotnoMyCaseArray = explode ( ",", trim ( str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/lotno' ) ) ) ) );
			$ownerMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/owner' ) ) ) );
			$shapeMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/shape' ) ) ) );
			$caratMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/carat' ) ) ) );
			$colorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/color' ) ) ) );
			$clarityMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/clarity' ) ) ) );
			$cutMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cut' ) ) ) );
			$culetMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/culet' ) ) ) );
			$crownMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/crown' ) ) ) );
			$pavilionMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/pavilion' ) ) ) );
			$dimsMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/dimensions' ) ) ) );
			$m1MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m1' ) ) ) );
			$m2MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m2' ) ) ) );
			$m3MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m3' ) ) ) );
			$depthMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/depth' ) ) ) );
			$tablMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/tabl' ) ) ) );
			$polishMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/polish' ) ) ) );
			$symMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/symmetry' ) ) ) );
			$fluorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fluorescence' ) ) ) );
			$fluorIntMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fluorescence_intensity' ) ) ) );
			$girdleMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle' ) ) ) );
			$girthinMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle_thin' ) ) ) );
			$girthikMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle_thik' ) ) ) );
			$fcolorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancycolor' ) ) ) );
			$fintensMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancy_intensity' ) ) ) );
			$foverMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancy_overtone' ) ) ) );
			$cashpriceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cash_price' ) ) ) );
			$rappriceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/rap_price' ) ) ) );
			$rapdiscMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/rap_discount' ) ) ) );
			$pricecaratMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/price_per_carat' ) ) ) );
			$priceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/totalprice' ) ) ) );
			$labMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/lab' ) ) ) );
			$labCommentMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/labratory_comments' ) ) ) );
			$clarityCharMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/clarity_char' ) ) ) );
			$nostonesMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/number_stones' ) ) ) );
			$certnoMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cert_number' ) ) ) );
			$vstocknoMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/stock_number' ) ) ) );
			$makeMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/make' ) ) ) );
			$cityMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/city' ) ) ) );
			$stateMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/state' ) ) ) );
			$countryMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/country' ) ) ) );
			$imageMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/image' ) ) ) );
			$dimageMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/diamond_image' ) ) ) );
			$availMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/availability' ) ) ) );
			$insMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/inscription' ) ) ) );
			$treatMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/treatment' ) ) ) );
			$ktsMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/key_to_symbols' ) ) ) );
			$descriptionMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/full_description' ) ) ) );
			
			
			//echo "<pre>"; print_r($lotnoMyCaseArray);exit;
			
			$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');
			$uploadtool_settings = Mage::getSingleton("core/resource")->getTableName('uploadtool_settings');
			
			$table = Mage::getSingleton('core/resource')->getTableName('uploadtool_settings');
			$query = "SELECT * FROM `$table` where `field` = 'google_csv' LIMIT 1";
			$result = @mysql_db_query($mdb_name, $query) or die("Failed Query of ".$query);
				
			$GoogleCsv = "";
			$row = mysql_fetch_array($result);
			$GoogleCsv = $row['value'];
				
			if(!$GoogleCsv) {
				//Mage::getSingleton("adminhtml/session")->addError("You must save Polygon User ID first");
				//$this->_redirect("*/*/new");
				//return;
				return array("success"=>0,"message"=>"You must import Google Csv first");
			}
				
			$path = Mage::getBaseDir("var") . DS ."import" . DS . "google" . DS;
				
			if(!file_exists($path."google.csv")) {
				//Mage::getSingleton("adminhtml/session")->addError("There is no file uploaded on Polygon FTP for Id:".$PolygonId);
				//$this->_redirect("*/*/new");
				//return;
				return array("success"=>0,"message"=>"There is no Google Csv found");
			}
				
			$this->alterMissingColumns();
			
			mysql_query("Delete from $uploadtool_diamonds_inventory where source = 'google'") or die(mysql_error());
			
			$fp = fopen($path."google.csv",'r') or die("can't open google csv file");
			
			$row=0;
			$count = 1;

			while($csv_line = fgetcsv($fp)){
				if($row==0){
						
					$currentHeaders = $csv_line;
					foreach ( $currentHeaders as $key => $headerTitle ) {
						$headerTitle = str_replace ( " ", "", strtoupper ( $headerTitle ) );
						$headerTitle = trim ( $headerTitle );
							
						if (in_array ( $headerTitle, $shapeMyCaseArray )) {
							$shapeKey = $key;
						}
							
						if (in_array ( $headerTitle, $ownerMyCaseArray )) {
							$ownerKey = $key;
						}
	
						if (in_array ( $headerTitle, $caratMyCaseArray )) {
							$caratKey = $key;
						}
							
						if (in_array ( $headerTitle, $colorMyCaseArray )) {
							$colorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fcolorMyCaseArray )) {
							$fcolorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fintensMyCaseArray )) {
							$fcintsKey = $key;
						}
							
						if (in_array ( $headerTitle, $foverMyCaseArray )) {
							$fcolovtKey = $key;
						}
							
						if (in_array ( $headerTitle, $clarityMyCaseArray )) {
							$clarityKey = $key;
						}
							
						if (in_array ( $headerTitle, $cutMyCaseArray )) {
							$cutKey = $key;
						}
							
						if (in_array ( $headerTitle, $polishMyCaseArray )) {
							$polishKey = $key;
						}
							
						if (in_array ( $headerTitle, $symMyCaseArray )) {
							$symmetryKey = $key;
						}
							
						if (in_array ( $headerTitle, $fluorMyCaseArray )) {
							$flcolorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fluorIntMyCaseArray )) {
							$flintensKey = $key;
						}
							
						if (in_array ( $headerTitle, $dimsMyCaseArray )) {
							$dimensionsKey = $key;
						}
							
						if(in_array($headerTitle, $m1MyCaseArray)) {
							$m1Key = $key;
						}
						if(in_array($headerTitle, $m2MyCaseArray)) {
							$m2Key = $key;
						}
						if(in_array($headerTitle, $m3MyCaseArray)) {
							$m3Key = $key;
						}
							
						if (in_array ( $headerTitle, $labMyCaseArray )) {
							$labKey = $key;
						}
							
						if (in_array ( $headerTitle, $labCommentMyCaseArray )) {
							$labCommentKey = $key;
						}
							
						if (in_array ( $headerTitle, $clarityCharMyCaseArray )) {
							$clarityCharKey = $key;
						}
							
						if (in_array ( $headerTitle, $certnoMyCaseArray )) {
							$certnoKey = $key;
						}
							
						if (in_array ( $headerTitle, $lotnoMyCaseArray )) {
							$lotnoKey = $key;
						}
							
						if (in_array ( $headerTitle, $priceMyCaseArray )) {
							$priceKey = $key;
						}
							
						if (in_array ( $headerTitle, $pricecaratMyCaseArray ) && ($pricecaratKey =="")) {
							$pricecaratKey = $key;
						}
							
						if (in_array ( $headerTitle, $cashpriceMyCaseArray )) {
							$cashpriceKey = $key;
						}
							
						if (in_array ( $headerTitle, $rappriceMyCaseArray )) {
							$rappriceKey = $key;
						}
							
						if (in_array ( $headerTitle, $rapdiscMyCaseArray )) {
							$rapdiscKey = $key;
						}
							
						if (in_array ( $headerTitle, $depthMyCaseArray )) {
							$depthKey = $key;
						}
							
						if (in_array ( $headerTitle, $tablMyCaseArray )) {
							$tblKey = $key;
						}
							
						if (in_array ( $headerTitle, $girdleMyCaseArray )) {
							$girdleKey = $key;
						}
							
						if (in_array ( $headerTitle, $girthinMyCaseArray )) {
							$girthinKey = $key;
						}
							
						if (in_array ( $headerTitle, $girthikMyCaseArray )) {
							$girthickKey = $key;
						}
							
						if (in_array ( $headerTitle, $culetMyCaseArray )) {
							$culetKey = $key;
						}
							
						if (in_array ( $headerTitle, $crownMyCaseArray )) {
							$crownKey = $key;
						}
							
						if (in_array ( $headerTitle, $pavilionMyCaseArray )) {
							$pavilionKey = $key;
						}
							
						if (in_array ( $headerTitle, $cityMyCaseArray )) {
							$cityKey = $key;
						}
							
						if (in_array ( $headerTitle, $stateMyCaseArray )) {
							$stateKey = $key;
						}
							
						if (in_array ( $headerTitle, $countryMyCaseArray )) {
							$contryKey = $key;
						}
							
						if (in_array ( $headerTitle, $nostonesMyCaseArray )) {
							$nostoneKey = $key;
						}
							
						if (in_array ( $headerTitle, $imageMyCaseArray )) {
							$certimgKey = $key;
						}
							
						if (in_array ( $headerTitle, $dimageMyCaseArray )) {
							$dimgKey = $key;
						}
							
						if (in_array ( $headerTitle, $makeMyCaseArray )) {
							$makeKey = $key;
						}
							
						if (in_array ( $headerTitle, $availMyCaseArray )) {
							$availKey = $key;
						}
							
						if (in_array ( $headerTitle, $insMyCaseArray )) {
							$insKey = $key;
						}
							
						if (in_array ( $headerTitle, $treatMyCaseArray )) {
							$treatKey = $key;
						}
							
						if (in_array ( $headerTitle, $ktsMyCaseArray )) {
							$ktsKey = $key;
						}
						
						if (in_array ( $headerTitle, $descriptionMyCaseArray )) {
							$descriptionKey = $key;
						}
						
					}
					$row++;
					continue;
				}
	
				
				$lotno = "";
				if(isset($csv_line[$lotnoKey])) {
					$lotno = $csv_line[$lotnoKey];
				}
				
				//echo "lotno". $lotno; exit;
				if($lotno == "") {
					continue;
				}
	
				//owner
				$owner = "";
				if(isset($csv_line[$ownerKey])) {
					$owner = $csv_line[$ownerKey];
				}
	
				//shape
				$shape = "";
				if(isset($csv_line[$shapeKey])) {
					$shape = $csv_line[$shapeKey];
				}
	
				//carat
				$carat = "";
				if(isset($csv_line[$caratKey])) {
					$carat = $csv_line[$caratKey];
				}
	
				//color
				$color = "";
				if(isset($csv_line[$colorKey])) {
					$color = $csv_line[$colorKey];
				}
	
				//clarity
				$clarity = "";
				if(isset($csv_line[$clarityKey])) {
					$clarity = $csv_line[$clarityKey];
				}
	
				//cut
				$cut = "";
				if(isset($csv_line[$cutKey])) {
					$cut = $csv_line[$cutKey];
				}
	
				//culet
				$culet = "";
				if(isset($csv_line[$culetKey])) {
					$culet = $csv_line[$culetKey];
				}
	
				//crown
				$crown = "";
				if(isset($csv_line[$crownKey])) {
					$crown = $csv_line[$crownKey];
				}
	
				//pavilion
				$pavilion = "";
				if(isset($csv_line[$pavilionKey])) {
					$pavilion = $csv_line[$pavilionKey];
				}
	
				//dimensions
				$dimensions = "";
				if(isset($csv_line[$dimensionsKey])) {
					$dimensions = $csv_line[$dimensionsKey];
				}
	
				//dim_height
				$dim_height = "";
				if(isset($csv_line[$m1Key])) {
					$dim_height = $csv_line[$m1Key];
				}
	
				//dim_width
				$dim_width = "";
				if(isset($csv_line[$m2Key])) {
					$dim_width = $csv_line[$m2Key];
				}
	
				//dim_depth
				$dim_depth = "";
				if(isset($csv_line[$m3Key])) {
					$dim_depth = $csv_line[$m3Key];
				}
	
				if($dimensions != "") {
					$dim = $dimensions;
					$findme = '-';
					$dash_dim = strpos ( $dim, $findme );
	
					if ($dash_dim == true) {
						$dim_h_w_d = explode ( "x", $dim );
						$dim_h_w = trim ( $dim_h_w_d [0] );
						$remove_dash = explode ( "-", $dim_h_w );
						$dim_height = trim ( $remove_dash [0] );
						$dim_width = trim ( $remove_dash [1] );
						$dim_depth = trim ( $dim_h_w_d [1] );
					} else if(strpos ( $dim, "X" ) == true) {
						$dim_h_w_d = explode ( "X", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					} else if(strpos ( $dim, "*" ) == true) {
						$dim_h_w_d = explode ( "*", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					} else {
						$dim_h_w_d = explode ( "x", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					}
	
	
				} else {
	
					if($dim_height != "" && $dim_width != "" && $dim_depth != "") {
						$dimensions = $dim_height.'x'.$dim_width.'x'.$dim_depth;
					}
	
				}
				//ratio
				$ratio = "";
				if($dim_height != "" && $dim_width != "") {
					$ratio = number_format($dim_height/$dim_width, 2, '.', '');
				}
				//echo $dimensions."===".$dim_height."===".$dim_width."===".$dim_depth."===".$ratio; exit;
	
				//depth
				$depth = "";
				if(isset($csv_line[$depthKey])) {
					$depth = $csv_line[$depthKey];
				}
	
				//tabl
				$tabl = "";
				if(isset($csv_line[$tblKey])) {
					$tabl = $csv_line[$tblKey];
				}
	
				//polish
				$polish = "";
				if(isset($csv_line[$polishKey])) {
					$polish = $csv_line[$polishKey];
				}
	
				//symmetry
				$symmetry = "";
				if(isset($csv_line[$symmetryKey])) {
					$symmetry = $csv_line[$symmetryKey];
				}
	
				//fluorescence
				$fluorescence = "";
				if(isset($csv_line[$flcolorKey])) {
					$fluorescence = $csv_line[$flcolorKey];
				}
				//fluorescence_intensity
				$fluorescence_intensity = "";
				if(isset($csv_line[$flintensKey])) {
					$fluorescence_intensity = $csv_line[$flintensKey];
				}
	
				//girdle
				$girdle = "";
				if(isset($csv_line[$girdleKey])) {
					$girdle = $csv_line[$girdleKey];
				}
	
				//girdle_min
				$girdle_min = "";
				if(isset($csv_line[$girthinKey])) {
					$girdle_min = $csv_line[$girthinKey];
				}
	
				//girdle_max
				$girdle_max = "";
				if(isset($csv_line[$girthickKey])) {
					$girdle_max = $csv_line[$girthickKey];
				}
				//echo $girdle . "===" . $girdle_min ."===". $girdle_max; exit;
	
				//fancy_intensity
				$fancy_intensity = "";
				if(isset($csv_line[$fcintsKey])) {
					$fancy_intensity = $csv_line[$fcintsKey];
				}
	
				//fancycolor
				$fancycolor = "";
				if(isset($csv_line[$fcolorKey])) {
					$fancycolor = $csv_line[$fcolorKey];
				}
	
				//fancy_overtone
				$fancy_overtone = "";
				if(isset($csv_line[$fcolovtKey])) {
					$fancy_overtone = $csv_line[$fcolovtKey];
				}
	
				//totalprice
				$totalprice = "";
				if(isset($csv_line[$priceKey])) {
					$totalprice = $csv_line[$priceKey];
				}
	
				//price_per_carat
				$price_per_carat = "";
				if(isset($csv_line[$pricecaratKey])) {
					$price_per_carat = $csv_line[$pricecaratKey];
				}
	
				//rap_price
				$rap_price = "";
				if(isset($csv_line[$rappriceKey])) {
					$rap_price = $csv_line[$rappriceKey];
				}
	
				//percent_rap
				$percent_rap = "";
				if(isset($csv_line[$rapdiscKey])) {
					$percent_rap = $csv_line[$rapdiscKey];
				}
	
				$discChars = array("-","%");
				$priceChars = array(",","$");
	
				$percent_rap = str_replace($discChars,"",$percent_rap);
				$totalprice = str_replace($priceChars,"",$totalprice);
				$price_per_carat = str_replace($priceChars,"",$price_per_carat);
				$rap_price = str_replace($priceChars,"",$rap_price);
	
	
				if($price_per_carat == "" && $totalprice != "") {
					$price_per_carat = $totalprice/$carat;
				}
				if($totalprice == "" && $price_per_carat != "") {
					$totalprice = $price_per_carat*$carat;
				}
	
				if($totalprice == "" && $price_per_carat == "") {
					if($rap_price != "") {
						$rap_disc = str_replace("-","",$percent_rap);
						$rap_disc = (100-$rap_disc)/100;
	
						$totalprice =  $rap_price*$carat*$rap_disc; //cost = rap price * carat weight * discount
						$price_per_carat = $totalprice/$carat;
					}
				}
	
				//echo $lotno."--".$totalprice."--".$price_per_carat; exit;
	
				//Lab
				$Lab = "";
				if(isset($csv_line[$labKey])) {
					$Lab = $csv_line[$labKey];
				}
	
				//number_stones
				$number_stones = "";
				if(isset($csv_line[$nostoneKey])) {
					$number_stones = $csv_line[$nostoneKey];
				}
	
				//cert_number
				$cert_number = "";
				if(isset($csv_line[$certnoKey])) {
					$cert_number = $csv_line[$certnoKey];
				}
	
				//make
				$make = "";
				if(isset($csv_line[$makeKey])) {
					$make = $csv_line[$makeKey];
				}
	
				//city
				$city = "";
				if(isset($csv_line[$cityKey])) {
					$city = $csv_line[$cityKey];
				}
	
				//state
				$state = "";
				if(isset($csv_line[$stateKey])) {
					$state = $csv_line[$stateKey];
				}
	
				//country
				$country = "";
				if(isset($csv_line[$contryKey])) {
					$country = $csv_line[$contryKey];
				}
	
				//image
				$image = "";
				if(isset($csv_line[$certimgKey])) {
					$image = $csv_line[$certimgKey];
				}
	
				//diamond_image
				$dimgKey = "";
				if(isset($csv_line[$dimgKey])) {
					$dimage = $csv_line[$dimgKey];
				}
	
				//availability
				$availability = "";
				if(isset($csv_line[$availKey])) {
					$availability = $csv_line[$availKey];
				}
	
				//comment
				$comment = "";
				if(isset($csv_line[$labCommentKey])) {
					$comment = $csv_line[$labCommentKey];
				}
	
				//clarity_char
				$clarity_char = "";
				if(isset($csv_line[$clarityCharKey])) {
					$clarity_char = $csv_line[$clarityCharKey];
				}
	
				//key_to_symbol
				$key_to_symbol = "";
				if(isset($csv_line[$ktsKey])) {
					$key_to_symbol = $csv_line[$ktsKey];
				}
				
				$full_description = "";
				if(isset($csv_line[$descriptionKey])) {
					$full_description = $csv_line[$descriptionKey];
				}
				
	
				//treatment
				$treatment = "";
				if(isset($csv_line[$treatKey])) {
					$treatment = $csv_line[$treatKey];
				}
				
				$qstring = "insert into `$uploadtool_diamonds_inventory` SET
						owner = '".mysql_real_escape_string($owner)."',
						shape = '".$shape."',
						carat = '".(intval(($carat*100))/100)."',
						color = '".$color."',
						fancycolor = '".($fancycolor)."',
						fancy_intensity = '".($fancy_intensity)."',
						clarity = '".($clarity)."',
						cut = '".($cut)."',
						polish = '".($polish)."',
						symmetry = '".($symmetry)."',
						fluorescence = '".($fluorescence_intensity)."',
						fluorescence_color = '".$fluorescence."',
						dimensions = '".($dimensions)."',
						Lab = '".($Lab)."',
						certificate = '".($Lab)."',
						cert_number = '".($cert_number)."',
						stock_number = '".trim($lotno)."',
						cost = '".round($totalprice)."',
						totalprice = '".round($totalprice)."',
						depth = '".($depth)."',
						tabl = '".($tabl)."',
						girdle = '".($girdle)."',
						culet = '".($culet)."',
						crown = '".($crown)."',
						pavilion = '".($pavilion)."',
						availability = '".($availability)."',
						city = '".($city)."',
						state = '".($state)."',
						country = '".($country)."',
						lotno = '".trim($lotno)."',
						percent_rap = '".$percent_rap."',
						number_stones = '".($number_stones)."',
						image = '".mysql_real_escape_string($image)."',
						full_description = '".mysql_real_escape_string($full_description)."',
						diamond_image = '".mysql_real_escape_string($dimage)."',
						source = 'google'";
				mysql_query($qstring) or die(mysql_error());
				//echo $qstring; exit;
			}
	
			$this->applyPriceIncrease('google');
			$this->updateRows();
				
			$sql = "select count(lotno) from `$uploadtool_diamonds_inventory` where source = 'google'";
			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
			$count = $row[0];
			
			return array("success"=>1,"message"=>$count." Diamond(s) Inserted from Google CSV.");
		}
		catch (Exception $e) {
			//Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			//$this->_redirect("*/*/new");
			return array("success"=>0,"message"=>$e->getMessage());
		}
	}
	
	
	public function importCustomUploads($vendor) {
	
		ini_set('memory_limit','-1');
		ini_set('auto_detect_line_endings',TRUE);
	
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
			$uploadtool_settings = Mage::getSingleton("core/resource")->getTableName('uploadtool_settings');
			$uploadtool_custom_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_custom_vendor');
	
			if(!$vendor) {
				return array("success"=>0,"message"=>"Invalid Vendor Url Parameter.");
			}
						
			$this->alterMissingColumns();
	
			$lotnoMyCaseArray = explode ( ",", trim ( str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/lotno' ) ) ) ) );
			$ownerMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/owner' ) ) ) );
			$shapeMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/shape' ) ) ) );
			$caratMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/carat' ) ) ) );
			$colorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/color' ) ) ) );
			$clarityMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/clarity' ) ) ) );
			$cutMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cut' ) ) ) );
			$culetMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/culet' ) ) ) );
			$crownMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/crown' ) ) ) );
			$pavilionMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/pavilion' ) ) ) );
			$dimsMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/dimensions' ) ) ) );
			$m1MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m1' ) ) ) );
			$m2MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m2' ) ) ) );
			$m3MyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/m3' ) ) ) );
			$depthMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/depth' ) ) ) );
			$tablMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/tabl' ) ) ) );
			$polishMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/polish' ) ) ) );
			$symMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/symmetry' ) ) ) );
			$fluorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fluorescence' ) ) ) );
			$fluorIntMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fluorescence_intensity' ) ) ) );
			$girdleMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle' ) ) ) );
			$girthinMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle_thin' ) ) ) );
			$girthikMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/girdle_thik' ) ) ) );
			$fcolorMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancycolor' ) ) ) );
			$fintensMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancy_intensity' ) ) ) );
			$foverMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/fancy_overtone' ) ) ) );
			$cashpriceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cash_price' ) ) ) );
			$rappriceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/rap_price' ) ) ) );
			$rapdiscMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/rap_discount' ) ) ) );
			$pricecaratMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/price_per_carat' ) ) ) );
			$priceMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/totalprice' ) ) ) );
			$labMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/lab' ) ) ) );
			$labCommentMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/labratory_comments' ) ) ) );
			$clarityCharMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/clarity_char' ) ) ) );
			$nostonesMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/number_stones' ) ) ) );
			$certnoMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/cert_number' ) ) ) );
			$vstocknoMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/stock_number' ) ) ) );
			$makeMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/make' ) ) ) );
			$cityMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/city' ) ) ) );
			$stateMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/state' ) ) ) );
			$countryMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/country' ) ) ) );
			$imageMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/image' ) ) ) );
			$dimageMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/diamond_image' ) ) ) );
			$availMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/availability' ) ) ) );
			$insMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/inscription' ) ) ) );
			$treatMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/treatment' ) ) ) );
			$ktsMyCaseArray = explode ( ",", str_replace ( " ", "", strtoupper ( Mage::getStoreConfig ( 'uploadtool/csv_title_possibilities/key_to_symbols' ) ) ) );
			//echo "<pre>"; print_r($lotnoMyCaseArray);exit;
				
			$path = Mage::getBaseDir("var") . DS ."import/uploadtool" . DS;
			$fp = fopen($path.$vendor.".csv",'r'); //or die("can't open file");
			if(!$fp) {
				return array("success"=>0,"message"=>"There is no file uploaded for vendor: ".$vendor);
			}
			
			mysql_query("Delete from $uploadtool_diamonds_inventory where source = '".$vendor."'") or die(mysql_error());
			
			$row=0;
			$count = 1;
						
			while($csv_line = fgetcsv($fp)){
				if($row==0){
						
					$currentHeaders = $csv_line;
					foreach ( $currentHeaders as $key => $headerTitle ) {
						$headerTitle = str_replace ( " ", "", strtoupper ( $headerTitle ) );
						$headerTitle = trim ( $headerTitle );
							
						if (in_array ( $headerTitle, $shapeMyCaseArray )) {
							$shapeKey = $key;
						}
							
						if (in_array ( $headerTitle, $ownerMyCaseArray )) {
							$ownerKey = $key;
						}
	
						if (in_array ( $headerTitle, $caratMyCaseArray )) {
							$caratKey = $key;
						}
							
						if (in_array ( $headerTitle, $colorMyCaseArray )) {
							$colorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fcolorMyCaseArray )) {
							$fcolorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fintensMyCaseArray )) {
							$fcintsKey = $key;
						}
							
						if (in_array ( $headerTitle, $foverMyCaseArray )) {
							$fcolovtKey = $key;
						}
							
						if (in_array ( $headerTitle, $clarityMyCaseArray )) {
							$clarityKey = $key;
						}
							
						if (in_array ( $headerTitle, $cutMyCaseArray )) {
							$cutKey = $key;
						}
							
						if (in_array ( $headerTitle, $polishMyCaseArray )) {
							$polishKey = $key;
						}
							
						if (in_array ( $headerTitle, $symMyCaseArray )) {
							$symmetryKey = $key;
						}
							
						if (in_array ( $headerTitle, $fluorMyCaseArray )) {
							$flcolorKey = $key;
						}
							
						if (in_array ( $headerTitle, $fluorIntMyCaseArray )) {
							$flintensKey = $key;
						}
							
						if (in_array ( $headerTitle, $dimsMyCaseArray )) {
							$dimensionsKey = $key;
						}
							
						if(in_array($headerTitle, $m1MyCaseArray)) {
							$m1Key = $key;
						}
						if(in_array($headerTitle, $m2MyCaseArray)) {
							$m2Key = $key;
						}
						if(in_array($headerTitle, $m3MyCaseArray)) {
							$m3Key = $key;
						}
							
						if (in_array ( $headerTitle, $labMyCaseArray )) {
							$labKey = $key;
						}
							
						if (in_array ( $headerTitle, $labCommentMyCaseArray )) {
							$labCommentKey = $key;
						}
							
						if (in_array ( $headerTitle, $clarityCharMyCaseArray )) {
							$clarityCharKey = $key;
						}
							
						if (in_array ( $headerTitle, $certnoMyCaseArray )) {
							$certnoKey = $key;
						}
							
						if (in_array ( $headerTitle, $lotnoMyCaseArray )) {
							$lotnoKey = $key;
						}
							
						if (in_array ( $headerTitle, $priceMyCaseArray )) {
							$priceKey = $key;
						}
							
						if (in_array ( $headerTitle, $pricecaratMyCaseArray ) && ($pricecaratKey =="")) {
							$pricecaratKey = $key;
						}
							
						if (in_array ( $headerTitle, $cashpriceMyCaseArray )) {
							$cashpriceKey = $key;
						}
							
						if (in_array ( $headerTitle, $rappriceMyCaseArray )) {
							$rappriceKey = $key;
						}
							
						if (in_array ( $headerTitle, $rapdiscMyCaseArray )) {
							$rapdiscKey = $key;
						}
							
						if (in_array ( $headerTitle, $depthMyCaseArray )) {
							$depthKey = $key;
						}
							
						if (in_array ( $headerTitle, $tablMyCaseArray )) {
							$tblKey = $key;
						}
							
						if (in_array ( $headerTitle, $girdleMyCaseArray )) {
							$girdleKey = $key;
						}
							
						if (in_array ( $headerTitle, $girthinMyCaseArray )) {
							$girthinKey = $key;
						}
							
						if (in_array ( $headerTitle, $girthikMyCaseArray )) {
							$girthickKey = $key;
						}
							
						if (in_array ( $headerTitle, $culetMyCaseArray )) {
							$culetKey = $key;
						}
							
						if (in_array ( $headerTitle, $crownMyCaseArray )) {
							$crownKey = $key;
						}
							
						if (in_array ( $headerTitle, $pavilionMyCaseArray )) {
							$pavilionKey = $key;
						}
							
						if (in_array ( $headerTitle, $cityMyCaseArray )) {
							$cityKey = $key;
						}
							
						if (in_array ( $headerTitle, $stateMyCaseArray )) {
							$stateKey = $key;
						}
							
						if (in_array ( $headerTitle, $countryMyCaseArray )) {
							$contryKey = $key;
						}
							
						if (in_array ( $headerTitle, $nostonesMyCaseArray )) {
							$nostoneKey = $key;
						}
							
						if (in_array ( $headerTitle, $imageMyCaseArray )) {
							$certimgKey = $key;
						}
							
						if (in_array ( $headerTitle, $dimageMyCaseArray )) {
							$dimgKey = $key;
						}
							
						if (in_array ( $headerTitle, $makeMyCaseArray )) {
							$makeKey = $key;
						}
							
						if (in_array ( $headerTitle, $availMyCaseArray )) {
							$availKey = $key;
						}
							
						if (in_array ( $headerTitle, $insMyCaseArray )) {
							$insKey = $key;
						}
							
						if (in_array ( $headerTitle, $treatMyCaseArray )) {
							$treatKey = $key;
						}
							
						if (in_array ( $headerTitle, $ktsMyCaseArray )) {
							$ktsKey = $key;
						}
					}
					$row++;
					continue;
				}
	
				$lotno = "";
				if(isset($csv_line[$lotnoKey])) {
					$lotno = $csv_line[$lotnoKey];
				}
	
				//echo $lotno; exit;
				if($lotno == "") {
					continue;
				}
	
				//owner
				$owner = "";
				if(isset($csv_line[$ownerKey])) {
					$owner = $csv_line[$ownerKey];
				}
	
				//shape
				$shape = "";
				if(isset($csv_line[$shapeKey])) {
					$shape = $csv_line[$shapeKey];
				}
	
				//carat
				$carat = "";
				if(isset($csv_line[$caratKey])) {
					$carat = $csv_line[$caratKey];
				}
	
				//color
				$color = "";
				if(isset($csv_line[$colorKey])) {
					$color = $csv_line[$colorKey];
				}
	
				//clarity
				$clarity = "";
				if(isset($csv_line[$clarityKey])) {
					$clarity = $csv_line[$clarityKey];
				}
	
				//cut
				$cut = "";
				if(isset($csv_line[$cutKey])) {
					$cut = $csv_line[$cutKey];
				}
	
				//culet
				$culet = "";
				if(isset($csv_line[$culetKey])) {
					$culet = $csv_line[$culetKey];
				}
	
				//crown
				$crown = "";
				if(isset($csv_line[$crownKey])) {
					$crown = $csv_line[$crownKey];
				}
	
				//pavilion
				$pavilion = "";
				if(isset($csv_line[$pavilionKey])) {
					$pavilion = $csv_line[$pavilionKey];
				}
	
				//dimensions
				$dimensions = "";
				if(isset($csv_line[$dimensionsKey])) {
					$dimensions = $csv_line[$dimensionsKey];
				}
	
				//dim_height
				$dim_height = "";
				if(isset($csv_line[$m1Key])) {
					$dim_height = $csv_line[$m1Key];
				}
	
				//dim_width
				$dim_width = "";
				if(isset($csv_line[$m2Key])) {
					$dim_width = $csv_line[$m2Key];
				}
	
				//dim_depth
				$dim_depth = "";
				if(isset($csv_line[$m3Key])) {
					$dim_depth = $csv_line[$m3Key];
				}
	
				if($dimensions != "") {
					$dim = $dimensions;
					$findme = '-';
					$dash_dim = strpos ( $dim, $findme );
	
					if ($dash_dim == true) {
						$dim_h_w_d = explode ( "x", $dim );
						$dim_h_w = trim ( $dim_h_w_d [0] );
						$remove_dash = explode ( "-", $dim_h_w );
						$dim_height = trim ( $remove_dash [0] );
						$dim_width = trim ( $remove_dash [1] );
						$dim_depth = trim ( $dim_h_w_d [1] );
					} else if(strpos ( $dim, "X" ) == true) {
						$dim_h_w_d = explode ( "X", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					} else if(strpos ( $dim, "*" ) == true) {
						$dim_h_w_d = explode ( "*", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					} else {
						$dim_h_w_d = explode ( "x", $dim );
						$dim_height = trim ( $dim_h_w_d [0] );
						$dim_width = trim ( $dim_h_w_d [1] );
						$dim_depth = trim ( $dim_h_w_d [2] );
					}
	
	
				} else {
	
					if($dim_height != "" && $dim_width != "" && $dim_depth != "") {
						$dimensions = $dim_height.'x'.$dim_width.'x'.$dim_depth;
					}
	
				}
				//ratio
				$ratio = "";
				if($dim_height != "" && $dim_width != "") {
					$ratio = number_format($dim_height/$dim_width, 2, '.', '');
				}
				//echo $dimensions."===".$dim_height."===".$dim_width."===".$dim_depth."===".$ratio; exit;
	
				//depth
				$depth = "";
				if(isset($csv_line[$depthKey])) {
					$depth = $csv_line[$depthKey];
				}
	
				//tabl
				$tabl = "";
				if(isset($csv_line[$tblKey])) {
					$tabl = $csv_line[$tblKey];
				}
	
				//polish
				$polish = "";
				if(isset($csv_line[$polishKey])) {
					$polish = $csv_line[$polishKey];
				}
	
				//symmetry
				$symmetry = "";
				if(isset($csv_line[$symmetryKey])) {
					$symmetry = $csv_line[$symmetryKey];
				}
	
				//fluorescence
				$fluorescence = "";
				if(isset($csv_line[$flcolorKey])) {
					$fluorescence = $csv_line[$flcolorKey];
				}
				//fluorescence_intensity
				$fluorescence_intensity = "";
				if(isset($csv_line[$flintensKey])) {
					$fluorescence_intensity = $csv_line[$flintensKey];
				}
	
				//girdle
				$girdle = "";
				if(isset($csv_line[$girdleKey])) {
					$girdle = $csv_line[$girdleKey];
				}
	
				//girdle_min
				$girdle_min = "";
				if(isset($csv_line[$girthinKey])) {
					$girdle_min = $csv_line[$girthinKey];
				}
	
				//girdle_max
				$girdle_max = "";
				if(isset($csv_line[$girthickKey])) {
					$girdle_max = $csv_line[$girthickKey];
				}
				//echo $girdle . "===" . $girdle_min ."===". $girdle_max; exit;
	
				//fancy_intensity
				$fancy_intensity = "";
				if(isset($csv_line[$fcintsKey])) {
					$fancy_intensity = $csv_line[$fcintsKey];
				}
	
				//fancycolor
				$fancycolor = "";
				if(isset($csv_line[$fcolorKey])) {
					$fancycolor = $csv_line[$fcolorKey];
				}
	
				//fancy_overtone
				$fancy_overtone = "";
				if(isset($csv_line[$fcolovtKey])) {
					$fancy_overtone = $csv_line[$fcolovtKey];
				}
	
				//totalprice
				$totalprice = "";
				if(isset($csv_line[$priceKey])) {
					$totalprice = $csv_line[$priceKey];
				}
	
				//price_per_carat
				$price_per_carat = "";
				if(isset($csv_line[$pricecaratKey])) {
					$price_per_carat = $csv_line[$pricecaratKey];
				}
	
				//rap_price
				$rap_price = "";
				if(isset($csv_line[$rappriceKey])) {
					$rap_price = $csv_line[$rappriceKey];
				}
	
				//percent_rap
				$percent_rap = "";
				if(isset($csv_line[$rapdiscKey])) {
					$percent_rap = $csv_line[$rapdiscKey];
				}
	
				$discChars = array("-","%");
				$priceChars = array(",","$");
	
				$percent_rap = str_replace($discChars,"",$percent_rap);
				$totalprice = str_replace($priceChars,"",$totalprice);
				$price_per_carat = str_replace($priceChars,"",$price_per_carat);
				$rap_price = str_replace($priceChars,"",$rap_price);
	
	
				if($price_per_carat == "" && $totalprice != "") {
					$price_per_carat = $totalprice/$carat;
				}
				if($totalprice == "" && $price_per_carat != "") {
					$totalprice = $price_per_carat*$carat;
				}
	
				if($totalprice == "" && $price_per_carat == "") {
					if($rap_price != "") {
						$rap_disc = str_replace("-","",$percent_rap);
						$rap_disc = (100-$rap_disc)/100;
	
						$totalprice =  $rap_price*$carat*$rap_disc; //cost = rap price * carat weight * discount
						$price_per_carat = $totalprice/$carat;
					}
				}
	
				//echo $lotno."--".$totalprice."--".$price_per_carat; exit;
	
				//Lab
				$Lab = "";
				if(isset($csv_line[$labKey])) {
					$Lab = $csv_line[$labKey];
				}
	
				//number_stones
				$number_stones = "";
				if(isset($csv_line[$nostoneKey])) {
					$number_stones = $csv_line[$nostoneKey];
				}
	
				//cert_number
				$cert_number = "";
				if(isset($csv_line[$certnoKey])) {
					$cert_number = $csv_line[$certnoKey];
				}
	
				//make
				$make = "";
				if(isset($csv_line[$makeKey])) {
					$make = $csv_line[$makeKey];
				}
	
				//city
				$city = "";
				if(isset($csv_line[$cityKey])) {
					$city = $csv_line[$cityKey];
				}
	
				//state
				$state = "";
				if(isset($csv_line[$stateKey])) {
					$state = $csv_line[$stateKey];
				}
	
				//country
				$country = "";
				if(isset($csv_line[$contryKey])) {
					$country = $csv_line[$contryKey];
				}
	
				//image
				$image = "";
				if(isset($csv_line[$certimgKey])) {
					$image = $csv_line[$certimgKey];
				}
	
				//diamond_image
				$dimgKey = "";
				if(isset($csv_line[$dimgKey])) {
					$dimage = $csv_line[$dimgKey];
				}
	
				//availability
				$availability = "";
				if(isset($csv_line[$availKey])) {
					$availability = $csv_line[$availKey];
				}
	
				//comment
				$comment = "";
				if(isset($csv_line[$labCommentKey])) {
					$comment = $csv_line[$labCommentKey];
				}
	
				//clarity_char
				$clarity_char = "";
				if(isset($csv_line[$clarityCharKey])) {
					$clarity_char = $csv_line[$clarityCharKey];
				}
	
				//key_to_symbol
				$key_to_symbol = "";
				if(isset($csv_line[$ktsKey])) {
					$key_to_symbol = $csv_line[$ktsKey];
				}
	
				//treatment
				$treatment = "";
				if(isset($csv_line[$treatKey])) {
					$treatment = $csv_line[$treatKey];
				}
	
				$qstring = "insert into `$uploadtool_diamonds_inventory` SET
							owner = '".mysql_real_escape_string($vendor)."',
							shape = '".$shape."',
							carat = '".(intval(($carat*100))/100)."',
							color = '".$color."',
							fancycolor = '".($fancycolor)."',
							fancy_intensity = '".($fancy_intensity)."',
							clarity = '".($clarity)."',
							cut = '".($cut)."',
							polish = '".($polish)."',
							symmetry = '".($symmetry)."',
							fluorescence = '".($fluorescence_intensity)."',
							fluorescence_color = '".$fluorescence."',
							dimensions = '".($dimensions)."',
							Lab = '".($Lab)."',
							certificate = '".($Lab)."',
							cert_number = '".($cert_number)."',
							stock_number = '".trim($lotno)."',
							cost = '".round($totalprice)."',
							totalprice = '".round($totalprice)."',
							depth = '".($depth)."',
							tabl = '".($tabl)."',
							girdle = '".($girdle)."',
							culet = '".($culet)."',
							crown = '".($crown)."',
							pavilion = '".($pavilion)."',
							availability = '".($availability)."',
							city = '".($city)."',
							state = '".($state)."',
							country = '".($country)."',
							lotno = '".trim($lotno)."',
							percent_rap = '".$percent_rap."',
							number_stones = '".($number_stones)."',
							image = '".mysql_real_escape_string($image)."',
							diamond_image = '".mysql_real_escape_string($dimage)."',
							source = '".$vendor."'";
		
				mysql_query($qstring) or die(mysql_error());
				//echo $qstring; exit;
			}
	
			$this->applyPriceIncrease($vendor);
			$this->updateRows();
				
			$update_date = mysql_query("select * from `$uploadtool_custom_vendor` where `custom_vendor_name`='$vendor'") or die(mysql_error());
			$lastUpdate = mysql_num_rows($update_date);
			
			$current = date("Y-m-d H:i:s");
			if($lastUpdate==0) {
				mysql_query("Insert into `$uploadtool_custom_vendor` SET `custom_vendor_name` = '$vendor',`last_updated`='$current'") or die(mysql_error());
			} else {
				mysql_query("Update `$uploadtool_custom_vendor` SET `last_updated`='$current' where `custom_vendor_name` = '$vendor'") or die(mysql_error());
			}
			
			$sql = "select count(lotno) from $uploadtool_diamonds_inventory  where source = '".$vendor."'";
			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
			$count = $row[0];
	
			return array("success"=>1,"message"=>$count." Diamond(s) Inserted from ". $vendor);
		}
		catch (Exception $e) {
			//Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			//$this->_redirect("*/*/new");
			return array("success"=>0,"message"=>$e->getMessage());
		}
	}
	
	 public function filterDiamonds() 
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
		
		
		/* certificate */
		$certificate = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/certificate_slider"));
		$allowedCert=array();
		foreach($certificate as $cert)
		{
			$avail=$cert['avilability'];
			if(isset($avail) && $avail != 1) continue;
			$allowedCert[]="'".$cert['label']."'"; 
			
		}
		$cert=implode(',',$allowedCert);
		$delflou="DELETE FROM `$uploadtool_diamonds_inventory`  WHERE `certificate` NOT IN ( $cert ) ;";
		mysql_query($delflou); 
		
		/* clarity_slider */
		$floure =unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/clarity_slider"));
		$allowedFloure=array();
		foreach($floure as $floure)
		{
		
			$allowedFloure[]="'".$floure['label']."'";
		}
		$floure=implode(',',$allowedFloure);
		$delflou="DELETE FROM `$uploadtool_diamonds_inventory`  WHERE `clarity` NOT IN ( $floure ) AND `fancy_intensity` = '' ;";
		mysql_query($delflou) or die(mysql_error());
	 
		$min_carat=Mage::getStoreConfig("diamondsearch/general_settings/diamondscarat_min");
		$max_carat=Mage::getStoreConfig("diamondsearch/general_settings/diamondscarat_max");
		//echo $min_carat;
		//echo "<br>".$max_carat;
		//if((isset($min_carat) && $min_carat!=''))
		
		
		if((isset($min_carat) && $min_carat!='') && (isset($max_carat) && $max_carat!=''))
		{
			$delcarat="DELETE FROM `$uploadtool_diamonds_inventory`  WHERE `carat`  NOT BETWEEN '$min_carat' AND '$max_carat'";
			// echo "A";
			mysql_query($delcarat) or die(mysql_error());
		}
		
		else if((isset($min_carat) && $min_carat!=''))
		{
			$delcarat="DELETE FROM `$uploadtool_diamonds_inventory`  WHERE `carat` <= '$min_carat' ";
			mysql_query($delcarat) or die(mysql_error());
		}
		
		else if((isset($max_carat) && $max_carat!=''))
		{
			$delcarat="DELETE FROM `$uploadtool_diamonds_inventory`  WHERE `carat` >=   '$max_carat'";
			mysql_query($delcarat) or die(mysql_error());
			
		}	
		
		
     	//move back diamond to inventory if we do a credit memo the product will return to the system or cancel the order
		$orders = Mage::getResourceModel('sales/order_collection')->addFieldToFilter('status', array('nin' => array('canceled')));
		
		foreach($orders as $order)
		{
			$items = $order->getAllVisibleItems();
			foreach($items as $item)
			{
				if($item->getAmountRefunded() > 0) { // skip refunded items - Rohit 28Sept16
					continue;
				}
				$sku[] = "'".$item->getSku()."'";
			}
		}
		
		if((count($sku)) > 0  )
		{
			$lotno=implode(',',$sku);
			mysql_query("DELETE FROM `$uploadtool_diamonds_inventory` WHERE `lotno` IN ($lotno)") or die(mysql_error());
		}
		
		 
		
		
    }
	
	public function filterDiamondsImages() 
    { 
		ini_set('max_execution_time', 0);
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

		$this->alterMissingColumns();
		
		$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');
		$uploadtool_diamonds_images = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_images');
		
		$result = mysql_query("SELECT lotno,diamond_image FROM `$uploadtool_diamonds_inventory`");  
		$storeArray = Array();
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$storeArray[$row['lotno']] =  $row['diamond_image'];
		}
		
		//echo "<pre>";
		//print_r($storeArray);
		//exit;
		foreach($storeArray as $key=>$value)
		{
			$img_flag = 0;
			if (@getimagesize($value))
				$img_flag = 1;
			
			$query_ins_upd = "INSERT INTO `$uploadtool_diamonds_images` (`lotno`, `image_flag`) VALUES('".$key."', ".$img_flag.") ON DUPLICATE KEY UPDATE lotno='".$key."', image_flag=".$img_flag;
			
			mysql_query($query_ins_upd);
			//echo "<br>".$query_update;
		}
	}
	
	
	
	/*public function filterDiamondsImages() 
    { 
		ini_set('max_execution_time', 0);
		
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
 
					
		$this->alterMissingColumns();
		
		$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');
		
		$result = mysql_query("SELECT lotno,diamond_image FROM `$uploadtool_diamonds_inventory` ");  
		$storeArray = Array();
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
			$storeArray[$row['lotno']] =  $row['diamond_image'];  
		}
		
		foreach($storeArray as $key=>$value)
		{
			if (@getimagesize($value))
			{
				$query_update = "UPDATE `$uploadtool_diamonds_inventory` SET `image_flag` = '1' where `lotno`='".$key."'";
			}
			else
			{
				$query_update = "UPDATE `$uploadtool_diamonds_inventory` SET `image_flag` = '0' where `lotno`='".$key."'";
			}
			
			mysql_query($query_update);
		}
		//echo "AAA"; exit;	 
	}*/
	
}
