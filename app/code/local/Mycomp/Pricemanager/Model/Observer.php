<?php

class Mycomp_Pricemanager_Model_Observer {
	public function updatePricemanegerprices() {
		 
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');
			$mainPriceGrabber = Mage::getSingleton('core/resource')->getTableName('pricemanager');
			$metal_needle_array = array();
			$kitco_url = 'http://www.kitco.com/market/';
			$data = file_get_contents($kitco_url);
			$metal_needle_array[] = array('metal' => 'gold', 'needle' => 'GOLD</a>', 'variable' => 'jewelry_current_gold');
			$metal_needle_array[] = array('metal' => 'silver', 'needle' => 'SILVER</a>', 'variable' => 'jewelry_current_silver');
			$metal_needle_array[] = array('metal' => 'platinum', 'needle' => 'PLATINUM</a>', 'variable' => 'jewelry_current_platinum');
			$metal_needle_array[] = array('metal' => 'palladium', 'needle' => 'PALLADIUM</a>', 'variable' => 'jewelry_current_palladium');
			$metal_needle_array[] = array('metal' => 'rhodium', 'needle' => 'RHODIUM</a>', 'variable' => 'jewelry_current_rhodium');
			
			$row_needle = '<td><p>';
			$row_end_needle = '</td>';
			//$table_row_needle = '<tr bgcolor="#f3f3e4" align="center">';
			foreach ($metal_needle_array as $metal_needle) {
			echo 'metal - '. $metal_needle['metal'];
			
			$scrape = strstr($data, $metal_needle['needle']);
			for ($i = 0; $i < 3; $i++) {
			$scrape = strstr($scrape, $row_needle);
			$scrape = substr($scrape, strlen($row_needle));
			}
			$value = substr($scrape, 0, strpos($scrape, $row_end_needle));
			$value = str_replace(',', '', $value);
			$SQL1 = "SELECT * FROM `".$mainPriceGrabber."` WHERE `metal` = '".$metal_needle['metal']."'";
			$readresult=$write->query($SQL1);
			$row = $readresult->fetch();
			if(isset($row['main_id']) && $row['main_id'] != 0){
				$SQLm = "UPDATE `".$mainPriceGrabber."` SET price = '".$value."', `updated` = '".date('Y-m-d H:i:s')."' WHERE `metal` = '".$metal_needle['metal']."'";
			}else{
				$SQLm = "INSERT INTO `".$mainPriceGrabber."` SET price = '".$value."', `updated` = '".date('Y-m-d H:i:s')."', `metal` = '".$metal_needle['metal']."'";
			}
		$write->query($SQLm);
			unset($SQL1);
			unset($readresult);
			unset($row);
			}
    
	}
}