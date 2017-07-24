<?php
// Change current directory to the directory of current script
chdir(dirname(__FILE__));

ini_set('memory_limit','1024M');
ini_set('max_execution_time', 18000);
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

require_once '../../../app/Mage.php';
//Varien_Profiler::enable();
//Mage::setIsDeveloperMode(true);
umask(0);
Mage::app();

$categoryMappingCSV = array_map('str_getcsv', file('Category-Mapping.csv'));
$categoryMapping = array();
$ic = 0;
foreach ($categoryMappingCSV as $categoryRow) {
	if($ic == 0) {
		$ic++; continue;
	}
	$categoryMapping[$categoryRow[0]] = $categoryRow[1];
	$ic++;
}
//echo "<pre>"; print_r($categoryMapping); exit;

$categorySortOrderCSV = array_map('str_getcsv', file('Category-SortOrder.csv'));
$categorySortOrder = array();
$ic = 0;
foreach ($categorySortOrderCSV as $categoryRow) {
	if($ic == 0) {
		$ic++; continue;
	}
	$categorySortOrder[$categoryRow[0]] = $categoryRow[1];
	$ic++;
}
//echo "<pre>"; print_r($categorySortOrderCSV); exit;

// assuming that your script file is located in magmi/integration/scripts/myscript.php,
// include "magmi_defs.php" and "magmi_datapump.php" first (note: there are two folders "inc" in different subfolders).

require_once("../../inc/magmi_defs.php");
require_once("../inc/magmi_datapump.php");
	

$dp = Magmi_DataPumpFactory::getDataPumpInstance("productimport");
$dp->beginImportSession("123_import_products", "update");

//$url = "http://r.123refills.com/import/example.csv"; // testing
//$url = "http://r.123refills.com/import/product_data_test.csv"; // testing
//$url = "http://egi.xpiva.com/product_rss"; // live old
$url = "http://erp.easygroup.us/product_rss"; // live

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);

$result = curl_exec($ch);
curl_close($ch);


$lines = explode( "\n", $result );
$lines = array_map('str_getcsv', $lines);

$row=0;

//echo "<pre>"; print_r($lines); exit;
$groupArray = array();

foreach($lines as $column)
{
	if($row==0){
		$row++;
		continue;
	}

	$id_sku = $column[0];
	
	$sku = "";
	if(isset($column[1]) && $column[1] != '') $sku = trim($column[1]);

	if(!$sku) continue;

	$item = array(); // new item
	
	$mfg_code = $column[2];
	$name = $column[3];
	$description = $sdescription = $column[4];
	if(!$column[4]) {
		$description = $sdescription = $column[3];
	}
	
	$price = "";
	if(isset($column[5]) && $column[5] != '' && $column[5] > 0) {
		$price = $column[5];
	}
	$special_price = "";
	if(isset($column[23]) && $column[23] != '' && $column[23] > 0) {
		$special_price = $column[23];
	}
	
	//this condition is added because client feed coming without list_price values so in that case price1 used as main price.
	if($price == "" && $special_price != "") {
		$price = $special_price;
		$special_price = "";
	}

	$printer_brand = $column[6]; // multiselect
	$weight = $column[7];
	$product_type = trim($column[8]); // dropdown 
	
	$image = $column[9];
	$small_image = $column[11];
	$thumbnail = $column[10];

	$product_color = $column[12]; //multiselect

	$yield = $column[13];
	$capacity = $column[14];
	$refillsQty = $column[15];
	$formula = $column[16];
	$shelflife = $column[17];
	$video = $column[18];
	$cartId = $column[27];
	$printer_type = $column[28]; // item type, has data like Inkjet,Toner
	$website_category = $column[29]; // not sure why its moved at last column
	
	$meta_title = $column[30];
	$meta_description = $column[31];
	$meta_keyword = $column[32];
	
	
	//TASK: http://production.idealbrandmarketing.com/task_detail.php?ti=12913
	//How to tell difference in data for import: 123refills - column "Publish 1" = True inkedibles - column "Publish 2" = True
	/* $publish1 = $column[20];
	$publish2 = $column[21];
	//echo $publish1 . "=="; continue;
	if(trim($publish1) != 'True') continue; */
	
	// He added new publishing rules. To determine where to publish product use column Publish and A = 123refills, B = InkEdibles.
	if(isset($column[19]) && $column[19] == "") continue; // skip if blank
	$publish = explode(",",$column[19]);
	if (!in_array("A", $publish)) continue; // A is for 123refeils
	//echo $sku . "==" . $price ."==". $special_price . "==". $cartId."<br>"; //continue;
	
	$item['type'] = 'simple';
	$item['websites'] = 'base';
	$item['store_id'] = '0';
	$item['store'] = 'admin';
	$item['attribute_set'] = 'Default';
	$item['status'] = 'Enabled';
	$item['visibility'] = '4';//'Catalog, Search';
	$item['tax_class_id'] = 'Taxable Goods';
	//manage stocks = No
	//$item['qty'] = '10';
	//$item['is_in_stock'] = '1';
	
	$item['id_sku'] = $id_sku;
	$item['sku'] = $sku;
	//$item['name'] = $name; //updated from data spin
	//http://production.idealbrandmarketing.com/task_detail.php?ti=14461
	//$item['url_key'] = Mage::getModel('catalog/product_url')->formatUrlKey($name.'-'.$sku); //for unique url
	//$item['url_key'] = Mage::getModel('catalog/product_url')->formatUrlKey($name); //for unique url
	
	//$item['description'] = $description; //updated from data spin
	//$item['short_description'] = $sdescription; //updated from data spin
	$item['weight'] = $weight;
	$item['price'] = $price;
	$item['special_price'] = $special_price;
	
	$item['image_link'] = $image;
	$item['small_image_link'] = $small_image;
	$item['thumbnail_link'] = $thumbnail;
	
	// imported real images becuase links from feed was causing SSL errors.
	//$item['image'] = $image;
	//$item['small_image'] = $small_image;
	//$item['thumbnail'] = $thumbnail;
	
	$item['cart_id'] = $cartId;
	$item['printer_type'] = $printer_type;
	$item['mfg_code'] = $mfg_code;
	
	if(trim($printer_brand) != '')  $item['printer_brand'] = trim($printer_brand);
	if(trim($product_type) != '') $item['product_type'] = trim($product_type);
	
	$product_color = explode('/',$product_color);
	$product_colorArray = array();
	foreach ($product_color as $color) {
		if(trim($color) != '') {
			$product_colorArray[] = trim($color);
		}
	}
	$product_colors = implode(',',$product_colorArray);
	$item['product_color'] = $product_colors;
	
	$item['yield'] = $yield;
	$item['capacity'] = $capacity;
	
	if(trim($shelflife) != '') $item['shelflife'] = trim($shelflife);
	if(trim($formula) != '') $item['formula'] = trim($formula);
	
	$item['video'] = $video;
	$item['refills_qty'] = $refillsQty;
	
	
	$seriesArray = array();
	$modelArray = array();
	$compatiblePrinters = array();
	$compatibleCartridges = array();
	
	if($website_category != '') {
	
		$item['website_category'] = $website_category;
		
		$categoryIds = array();
		$website_category = rtrim($website_category,',');
	
		$parentCategories = explode(',',$website_category);
	
		foreach ($parentCategories as $parentCat) {
				
			$levels = explode('/',$parentCat);
			//echo "<pre>"; print_r($levels); exit;
			
			$cartridgeFlag = false;
			$level = 0; // Printers has 4 levels
			if(trim($levels[0]) == 'Cartridges') { // Cartridges has 3 levels and no series
				$level = 1;
				$cartridgeFlag = true;
			}
				
			foreach ($levels as $levelCat) {
				$categoryName = trim($levelCat);
	
				if($level == 2) {
						
					if(!$categoryName) {
						$level++; continue;
					}
						
					$printerSeriesArray = explode('Series',trim($categoryName));
					//echo "<pre>"; print_r($printerSeriesArray); echo "</pre>";
					$printerSeries = "";
					if(isset($printerSeriesArray[1]) && $printerSeriesArray[1] != '') {
						$printerSeries = trim(ltrim($printerSeriesArray[1],'-'));
					}
					
					if(!$printerSeries) {
						$level++; continue;
					}
	
					$groupArray[$parentCat]['series'] = $printerSeries;
					$seriesArray[] = $printerSeries;
				}
				if($level == 3) {
						
					if(!$categoryName) {
						$level++; continue;
					}
						
					/* $groupArray[$parentCat]['model'] = trim($categoryName);
					$modelArray[] = trim($categoryName);
					
					if($cartridgeFlag == true) {
						$compatibleCartridges[] = trim($categoryName);
					} else {
						$compatiblePrinters[] = trim($categoryName);
					} */
					
					//logic to get last word as Model if repeats with series word
					//for example: series is Pixma ip and model is PIXMA iP4500 then Model = iP4500 for better search result
					$modelName = trim($categoryName);
					if((count(explode(' ',$modelName)) > 1) && (isset($groupArray[$parentCat]['series'])) && ($groupArray[$parentCat]['series'] != "")) {
					
						foreach(explode(' ',$groupArray[$parentCat]['series']) as $seriesWord)
						{
							if (strpos($modelName,$seriesWord) !== false) {
								//echo 'one of the series word was found inside model name.';
								$modelName = str_replace(array(' series',' Series'),"",$modelName); // to fix issue with "5500 Series","CP5200 Series" etc.
								$split = explode(" ", $modelName); // last word as model
								$modelName = $split[count($split)-1];
								break;
							}
						}
						//echo $modelName; exit;
					}
						
					$groupArray[$parentCat]['model'] = $modelName;
					$modelArray[] = $modelName;
					
				}
				$level++;
			}
				
			$groupBrand = str_replace(array(' Cartridges',' Printers'), '', trim($levels[1])); // Brother Printers or Brother Cartridges will result Brother as brand
			$groupArray[$parentCat]['printer_brand'] = $groupBrand;
			if($printer_type) {
				$groupArray[$parentCat]['printer_type'] = $printer_type;
			}
			$groupArray[$parentCat]['associated'][] = $sku; //$sku;
			
			if($cartridgeFlag == true) {
				// just for info, group products won't be there for cartridges!
				$groupSku = str_replace(' ','-',$groupArray[$parentCat]['printer_brand']) . '_' . str_replace(' ','-',$groupArray[$parentCat]['model']);
			} else {
				$groupSku = str_replace(' ','-',$groupArray[$parentCat]['printer_brand']) . '_' .  str_replace(' ','-',$groupArray[$parentCat]['series']) . '_' . str_replace(' ','-',$groupArray[$parentCat]['model']);
			}
				
			$groupArray[$parentCat]['grouped_sku'] = $groupSku;
				
			if($cartridgeFlag == true) {
				//Compatible Cartridges won't have groups and no links on details page
				$compatibleCartridges[] = $groupArray[$parentCat]['model'];
			} else {
				$compatiblePrinters[] = $groupSku;
			}
		}
	}
	//echo "<pre>"; print_r(array_unique($seriesArray)); echo "</pre>";
	//echo "<pre>"; print_r(array_unique($modelArray)); echo "</pre>";
	//echo "<pre>"; print_r(array_unique($compatibleCartridges)); echo "</pre>";
	//echo "<pre>"; print_r(array_unique($compatiblePrinters)); echo "</pre>";
	//continue;
	
	$printer_series = implode(',',array_unique($seriesArray));
	$item['printer_series'] = $printer_series;
	
	$printer_model = implode(',',array_unique($modelArray));
	$item['printer_model'] = $printer_model;
	
	$item['compatible_cartridges'] = implode(",",array_unique($compatibleCartridges));
	$item['compatible_printers'] = implode(",",array_unique($compatiblePrinters));
	
	$internal_category = trim($column[8]); // internal category
	$item['internal_category'] = $internal_category;
	//Task: http://production.idealbrandmarketing.com/task_detail.php?ti=14193
	if(isset($categorySortOrder[$internal_category]) && $categorySortOrder[$internal_category] != '') {
		$item['internal_category_sort'] = $categorySortOrder[$internal_category];
	}
	
	if(isset($categoryMapping[$internal_category]) && $categoryMapping[$internal_category] != '') {
		$item['categories'] = $categoryMapping[$internal_category];
	}
	
	//$item['meta_title'] = $meta_title; //updated from data spin
	//$item['meta_description'] = $meta_description; //updated from data spin
	$item['meta_keyword'] = $meta_keyword;
	
	$dp->ingest($item);
	
	echo "Simple: " . $sku." ";
	//echo "<pre>"; print_r($item); echo "</pre>";
	$row++;
	//exit;
	unset($item);
}
//echo "<pre>"; print_r($groupArray); echo "</pre>";
//exit;

foreach ($groupArray as $groupName => $groupValues) {

	$printer_brand = $groupValues['printer_brand']; // this will be first level category
	$printer_type = $groupValues['printer_type'];
	
	//this was causing duplicate options with dash and without dash
	//$series = str_replace(' ','-',$groupValues['series']);
	//$model = str_replace(' ','-',$groupValues['model']);
	$series = $groupValues['series'];
	$model = $groupValues['model'];

	if($series == '' || $model == '') continue;

	//$groupSku = str_replace(' ','-',$series) . '_' . str_replace(' ','-',$model);
	$groupSku = $groupValues['grouped_sku'];
	
	//$name = $groupName;
	$groupTitle = $groupName;
	if( strpos( $groupName, '/' ) !== false ) {
		$explodeName = explode('/',$groupTitle);
		$groupTitle = $explodeName[count($explodeName)-1]; // get name after last slash
	}
	//http://production.idealbrandmarketing.com/task_detail.php?ti=14261
	$name = $printer_brand . " " . $groupTitle; // changed for better url key
	
	$description = $sdescription = $groupName;
	$weight = 0;

	$item = array(); // new item
	
	$item['type'] = 'grouped';
	$item['websites'] = 'base';
	$item['store_id'] = '0';
	$item['store'] = 'admin';
	$item['attribute_set'] = 'Default';
	$item['status'] = 'Enabled';
	$item['visibility'] = '2';//'Catalog';
	$item['tax_class_id'] = 'Taxable Goods';
	//$item['qty'] = '10';
	//$item['is_in_stock'] = '1';
	
	$item['sku'] = $groupSku;
	//$item['name'] = $name; //updated from data spin
	//$item['description'] = $description; //updated from data spin
	//$item['short_description'] = $sdescription; //updated from data spin
	$item['weight'] = $weight;

	if(trim($printer_brand) != '') $item['printer_brand'] = trim($printer_brand);
	if(trim($series) != '') $item['printer_series'] = trim($series);
	if(trim($model) != '') $item['printer_model'] = trim($model);

	$item['printer_type'] = $printer_type;
	
	$grouped_skus = $groupValues['associated'];
	$item['grouped_skus'] = implode(",",$grouped_skus);

	//brand as category
	$categoryName = $printer_brand;
	$parentForSub = '2'; //root category
	$parentCategory = Mage::getModel('catalog/category')->load($parentForSub);
	$_category = Mage::getModel('catalog/category')->getCollection()
				->addIdFilter($parentCategory->getChildren())
				->addAttributeToFilter('name', $categoryName)
				->getFirstItem();    // Assuming your category names are unique ??

	if(null !== $_category->getId()) {

		$magmiCategory = $categoryName;
		
	} else {
		
		//if brand category does not exist then create/use it under More Brands category
		$magmiCategory = "More Brands/" . $categoryName."::1::1::0";  //category name::[is_active]::[is_anchor]::[include_in_menu]  http://wiki.magmi.org/index.php?title=On_the_fly_category_creator/importer
	}
	
	$item['categories'] = $magmiCategory;
	
	$dp->ingest($item);
	
	echo "Grouped: " . $groupSku." ";
	//echo "<pre>"; print_r($item); echo "</pre>";
	unset($item);
}

// End import Session
$dp->endImportSession();