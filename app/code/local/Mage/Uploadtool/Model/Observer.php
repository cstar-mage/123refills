<?php 
class Mage_Uploadtool_Model_Observer {
	
	const XML_PATH_DIAMOND_IMPORT_ENABLED = 'cronjobs/uploadtool/enabled_import';
	const XML_PATH_SENDREPORT_ENABLED = 'cronjobs/uploadtool/enabled_sendreport';
	const XML_PATH_RAPNET_IMPORT_ENABLED = 'cronjobs/uploadtool_rapnet/enabled_sendreport';
	const XML_PATH_POLYGON_IMPORT_ENABLED = 'cronjobs/uploadtool_polygon/enabled_sendreport';
	
	
	public function diamondsImport() {
		
		if (!Mage::getStoreConfigFlag(self::XML_PATH_DIAMOND_IMPORT_ENABLED)) {
			return;
		}
		
		$importCSV = Mage::helper('uploadtool')->getImportCSV();
		$saveCSV = Mage::helper('uploadtool')->saveCSV();
		Mage::helper('uploadtool')->filterDiamonds();
		
		echo $importCSV['message'];
		echo $saveCSV['message'];
		return $this;
	}
	
	public function rapnetImport() {
	
		if (!Mage::getStoreConfigFlag(self::XML_PATH_RAPNET_IMPORT_ENABLED)) {
			return;
		}
	
		$importCSV = Mage::helper('uploadtool')->getRapnetList();
		$saveCSV = Mage::helper('uploadtool')->updateRapnetDiamonds();
	
		echo $importCSV['message'];
		echo $saveCSV['message'];
		return $this;
	}
	
	public function polygonImport() {
	
		if (!Mage::getStoreConfigFlag(self::XML_PATH_POLYGON_IMPORT_ENABLED)) {
			return;
		}
	
		$import = Mage::helper('uploadtool')->importPolygon();
	
		echo $import['message'];
		echo $import['message'];
		return $this;
	}
	
	public function sendReportDiamonds() {
		
		if (!Mage::getStoreConfigFlag(self::XML_PATH_SENDREPORT_ENABLED)) {
			return;
		}
		
		$daily_jpg=Mage::getBaseUrl().'images/daily.jpg';
		$elogo_jpg=Mage::getBaseUrl().'images/e_logo.jpg';
		$flogo_jpg=Mage::getBaseUrl().'images/f_logo.jpg';
		$fromemailaddr=Mage::getStoreConfig('trans_email/ident_general/email');
		$back_img=Mage::getBaseUrl().'images/shadow.png';
		
		
		try
		{
			$resource = Mage::getConfig()->getNode('global/resources')->asArray();
			$magento_db = $resource['default_setup']['connection']['host'];
			$mdb_user = $resource['default_setup']['connection']['username'];
			$mdb_passwd = $resource['default_setup']['connection']['password'];
			$mdb_name = $resource['default_setup']['connection']['dbname'];
			//echo $magento_db." - ".$mdb_user." - ".$mdb_passwd." - ".$mdb_name;
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
		
			if (!$magento_connection)
			{
				die('Unable to connect to the database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
		
			$uploadtool_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_vendor');
			$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');
		
			$query = "SELECT $uploadtool_vendor.vendor_name as vendor, count($uploadtool_diamonds_inventory.owner) as diams FROM
			`$uploadtool_vendor` left join `$uploadtool_diamonds_inventory` on $uploadtool_vendor.vendor_name = $uploadtool_diamonds_inventory.owner
			group by $uploadtool_vendor.vendor_name";
		
			//echo $query;
			$result= mysql_query($query);
			if (!$result) {
				echo 'Could not run query: ' . mysql_error();
				exit;
			}
			$messageBody = "";
			$emailbool="";
			if(mysql_num_rows($result) > 0){
		
				$messageBody .="<html><head><meta http-equiv='Content-Type'  content='text/html charset=UTF-8' />	<title>Jewelerslink Report</title></head><body style='margin:0'>";
				$messageBody .="<div style='background:url($back_img)repeat-y scroll center center rgba(0, 0, 0, 0);margin: 0 auto;width: 588px;'>";
				$messageBody .='<table style="margin: 0px auto; text-align: center ! important;" cellpadding="0" cellspacing="0">';
				$messageBody .="<tr><td><a href='http://jewelerslink.com/'><img src='".$elogo_jpg."' style='width:100%' /></a></td>
		</tr><tr><td><img src='".$daily_jpg."' style='width:100%' /><td></tr><tr>
		<td><p class='title_text' style=' border-bottom: 2px solid #bfc0c1; border-top: 2px solid #bfc0c1;color: #010101;display: table;    font-family:sans-serif;
		font-size: 18px;  margin:10px auto;padding: 8px 0; text-align: center;text-transform: uppercase; width: 91%;'>Diamond Synchronization Report</p></td>
		</tr><tr><td>";
				$messageBody .= "<table width = '92%' cellspacing='0' style='margin:0 auto'>";
				$messageBody .= "<thead style='background-color: rgb(102, 102, 102); color: rgb(255, 255, 255); line-height: 31px;'>";
				$messageBody .= "<th align='left' style='font-family:sans-serif;'>&nbsp;Vendor</th>";
				$messageBody .= "<th align='right' style='font-family:sans-serif;'>Diamonds&nbsp;</th>";
				$messageBody .= "</thead>";
				$messageBody .= "<tbody>";
				while($row = mysql_fetch_array($result))
				{
					$messageBody .= "<tr>";
					$messageBody .= "<td align='left'  style='font-family:sans-serif;'>&nbsp;".$row['vendor']."</td>";
					$messageBody .= "<td align='right' style='font-family:sans-serif;'>".$row['diams']."&nbsp;</td>";
					$messageBody .= "</tr>";
				}
				$messageBody .= "</tbody>";
				$messageBody .= "</table>";
				$emailbool="1";
			}
			else { // $messageBody .= "No diamonds found";$emailbool="";
			}
			//echo "test email";
			$fromuser="support@idealbrandmarketing.com";
			$jewelryto= $fromemailaddr;
			//$jewelryto="support@idealbrandmarketing.com";
		
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From:'.$fromuser." <".$fromuser.">\r\n";
			$headers .= "Bcc: data@jewelerslink.com\r\n";
			$subject = "JewelersLink Daily Report -".date("d/m/Y");
			$message .= $sitelogo;
			$messageBody= "<tr><td>".$messageBody."";
			$messageBody .= "</td></tr>";
			//mail($jewelryto,$subject,$message,$headers);
		
			//echo $messageBody;
		}
		catch (Exception $e) {
			echo $e->getMessage();
			exit;
		}
		?>
		
		<?php
		
		try
		{
			$resource = Mage::getConfig()->getNode('global/resources')->asArray();
			$magento_db = $resource['default_setup']['connection']['host'];
			$mdb_user = $resource['default_setup']['connection']['username'];
			$mdb_passwd = $resource['default_setup']['connection']['password'];
			$mdb_name = $resource['default_setup']['connection']['dbname'];
		
			//echo $magento_db." - ".$mdb_user." - ".$mdb_passwd." - ".$mdb_name;
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
		
			if (!$magento_connection)
			{
				die('Unable to connect to the database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
			$query = "SELECT * from jewelryshare_vendor";
			//echo $query;
			$result= mysql_query($query);
			if (!$result) {
				echo 'Could not run query: ' . mysql_error();
				exit;
			}
			$vendors = "";
			if(mysql_num_rows($result) > 0){
				while($row = mysql_fetch_array($result))
				{
					$vendors[] = $row['vendor_name'];
				}
			}
			//echo "<pre>";
			//print_r($vendors);
			//exit;
		
			$productColl = Mage::getModel("catalog/product")->getCollection();
		
			//exit;
		
			$products = $productColl->getData();
			//echo "<pre>";
			//print_r($products);
			//exit;
			//$messageBody = "";
			$emailbool="";
			if(mysql_num_rows($result) > 0){
		
				$messageBody .="<tr>
				<td><p class='title_text' style=' border-bottom: 2px solid #bfc0c1; border-top: 2px solid #bfc0c1;color: #010101;display: table;font-family:sans-serif;
				font-size: 18px; margin:10px auto;    padding: 8px 0;    text-align: center;    text-transform: uppercase;    width: 91%;'>Jewelry Synchronization Report</p></td>
				</tr><tr><td>";
				$messageBody .= "<table width = '92%' cellspacing='0' style='margin:0 auto'>";
				$messageBody .= "<thead style='background-color: rgb(102, 102, 102); color: rgb(255, 255, 255); line-height: 31px;'>";
				$messageBody .= "<th align='left' style='font-family:sans-serif;'>&nbsp;Vendor</th>";
				$messageBody .= "<th style='font-family:sans-serif;'>Updated Products</th>";
				$messageBody .= "<th align='right' style='font-family:sans-serif;'>Jewelry&nbsp;</th>";
				$messageBody .= "</thead>";
				
				 
				foreach($vendors as $productlist)
				{
					$productColl = Mage::getModel('catalog/product')->getCollection();
					$productColl->addAttributeToSelect('*');
					$productColl->addFieldToFilter(
							'manufacturer',
							array(
									'eq' => Mage::getResourceModel('catalog/product')
									->getAttribute('manufacturer')
									->getSource()
									->getOptionId($productlist)
							)
					);
					$product_count=$productColl->Count();
					$productColl->addAttributeToSort('updated_at');
					$firstItem = $productColl->getLastItem();
					if($firstItem->getUpdatedAt())
					{
						$lastupdate=date("d-m-Y",strtotime($firstItem->getUpdatedAt()));
						$dates=date("Y-m-d",strtotime($firstItem->getUpdatedAt()));
					}
						
					$collection = Mage::getModel('catalog/product')->getCollection();
					$collection->addAttributeToSelect('*');
					$collection->addFieldToFilter(
							'manufacturer',
							array(
									'eq' => Mage::getResourceModel('catalog/product')
									->getAttribute('manufacturer')
									->getSource()
									->getOptionId($productlist)
							)
					);
						
					$collection->addAttributeToFilter('updated_at', array(
							'from' => $dates."00:00:00",
							'to' =>  $dates."23:59:59",
							'date' => true,
					));
		
					//echo $collection->count();
						
					$messageBody .= "<tr>";
					if($lastupdate)
					{
						$messageBody .= "<td align='left' style='font-family:sans-serif;' >&nbsp;".$productlist."<br/>Last Updated".$lastupdate."</td>";
					}
					else
					{
						$messageBody .= "<td align='left' style='font-family:sans-serif;'>&nbsp;".$productlist."</td>";
					}
					$messageBody .= "<td align='center' style='font-family:sans-serif;'>".$collection->count()."</td>";
					$messageBody .= "<td align='right' style='font-family:sans-serif;'>".$product_count."&nbsp;</td>";
					$messageBody .= "</tr>";
					$emailbool="1";
					//echo $productColl->Count();
				}
				
				$messageBody .= "</table>";
				$messageBody .= "</td></tr>";
			}
			else 
			{ 
			  //	$messageBody .= "No diamonds found";$emailbool="";
				
			}
			/* --------------------------------------------- Jewelries Report --------------------------------------------------------------*/
			 
				$fromuser="support@idealbrandmarketing.com";
				//$jewelryto="support@idealbrandmarketing.com";
				//echo $message; 	
				
				$query = "SELECT * from watches_vendor";
				//echo $query;
				$result1= mysql_query($query);
				 
				if(mysql_num_rows($result) > 0){
					while($row = mysql_fetch_array($result1))
					{
						//echo $row['vendor_name'];
						$vendorss[] = $row['vendor_name'];
					}
					
					if(count($vendorss) > 0)
					{
						$message .="<tr>
						<td><p class='title_text' style=' border-bottom: 2px solid #bfc0c1; border-top: 2px solid #bfc0c1;color: #010101;display: table;font-family:sans-serif;
						font-size: 18px; margin:10px auto;    padding: 8px 0;    text-align: center;    text-transform: uppercase;    width: 91%;'>Watches Synchronization Report</p></td>
						</tr><tr><td>";
					
						$message .= "<table width = '92%' cellspacing='0' style='margin:0 auto'>";
						$message .= "<thead style='background-color: rgb(102, 102, 102); color: rgb(255, 255, 255); line-height: 31px;'>";
						$message .= "<th align='left' style='font-family:sans-serif;'>&nbsp;Vendor</th>";
						$message .= "<th align='right' style='font-family:sans-serif;'>Watches</th>";
						$message .= "</thead>";
						$message .= "<tbody>";
						foreach($vendorss as $productlist)
						{
							$productColl = Mage::getModel('catalog/product')->getCollection();
							$productColl->addAttributeToSelect('*');
							$productColl->addFieldToFilter(
									'manufacturer',
									array(
											'eq' => Mage::getResourceModel('catalog/product')
											->getAttribute('manufacturer')
											->getSource()
											->getOptionId($productlist)
									)
							);
							$product_count=$productColl->Count();
					
					
							//echo $collection->count();
					
							$message .= "<tr>";
							$message .= "<td align='left' style='font-family:sans-serif;' >".$productlist."</td>";
							$message .= "<td align='right' style='font-family:sans-serif;'>".$product_count."&nbsp;</td>";
							$message .= "</tr>";
							$emailbool="1";
							//echo $productColl->Count();
						}
						$message .= "</tbody>";
						$message .= "</table>";
					}
					
				
				}
				
				$messageBody.="<tr><td style='height:20px;border-bottom:1px solid #e3e3e3'></td></tr>";
				$messageBody.="<tr><td><img src='".$flogo_jpg."' style='width:100%' /></td></tr>";
				$messageBody.="<tr><td>
				<ul style='margin-bottom:0;'>
				<li style='list-style:outside none none; text-align: center;width: 85px;float:left;'><a href='http://www.jewelerslink.com/why-link/' style='color: #010101;font-size: 10px;text-align: center;text-decoration: none;font-family:sans-serif;'>WHY LINK</a></li>
				<li style='list-style:outside none none; text-align: center;width: 85px;float:left;'><a href='http://www.jewelerslink.com/about/' style='color: #010101;font-size: 10px;text-align: center;text-decoration: none;font-family:sans-serif;'>ABOUT US</a></li>
				<li style='list-style:outside none none; text-align: center;width: 85px;float:left;'><a href='http://www.jewelerslink.com/client/' style='color: #010101;font-size: 10px;text-align: center;text-decoration: none;font-family:sans-serif;'>CLIENTS</a></li>
				<li style='list-style:outside none none; text-align: center;width: 85px;float:left;'><a href='http://www.jewelerslink.com/membership/' style='color: #010101;font-size: 10px;text-align: center;text-decoration: none;font-family:sans-serif;'>MEMBERSHIP</a></li>
				<li style='list-style:outside none none; text-align: center;width: 85px;float:left;'><a href='http://www.jewelerslink.com/contacts/' style='color: #010101;font-size: 10px;text-align: center;text-decoration: none;font-family:sans-serif;'>CONTACT US</a></li>
				</ul><tr>
				<td><p style='text-align:center;margin-bottom:20px'><span style='font-size: 12px;    font-weight: bold;font-family:sans-serif;'>213.291.8883</span><span style=' font-family: serif;    font-size: 12px;    font-weight: bold;    padding-left: 5px;    padding-right: 5px;'>|</span></span>
				<span><a href='http://jewelerslink.com/' style=' color: #457bbb;font-family: serif;    font-size: 12px;    font-weight: bold;    text-decoration: none;font-family:sans-serif;'>JEWELERSLINK.COM</a></span></p></td>		</tr>
				</table>
				</div>
				</body>
				</html>";
				 		 
				mail($jewelryto,$subject,$messageBody,$headers);
		
		  //	echo $messageBody;
				echo 'Done';
				
				return $this;
		}
		catch (Exception $e) { 
			echo $e->getMessage();
			exit;
		}
		
	}
	
	public function removeplaceddiamonds(Varien_Event_Observer $observer)
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
 
		$orders = Mage::getResourceModel('sales/order_collection');
		foreach($orders as $order)
		{
			$items = $order->getAllVisibleItems();
			foreach($items as $item)
			{
				$sku[] = "'".$item->getSku()."'";
				 
			}
		}
		
		$lotno=implode(',',$sku);
		//echo "DELETE FROM `$uploadtool_diamonds_inventory` WHERE `lotno` IN ($lotno)";
		mysql_query("DELETE FROM `$uploadtool_diamonds_inventory` WHERE `lotno` IN ($lotno)") or die(mysql_error());
		//Mage::log('My log message: '.$lotno);
	} 

}
?>
