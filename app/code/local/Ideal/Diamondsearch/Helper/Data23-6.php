<?php
class Ideal_Diamondsearch_Helper_Data extends Mage_Core_Helper_Abstract
{
	function getDiamondsArray($stones, $is_fancy, $is_specialshape)
	{
		$diamonds = array();
		$compare_params = array();
		if(isset($_COOKIE["compare_params"])) {
			$compare_params = explode(",",$_COOKIE["compare_params"]);
		}
		$currencySym = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
		foreach ( $stones as $stone) {
			
			$color = $stone['color'];
			if($is_fancy) $color = $stone['fancycolor']." ".$stone['fancy_intensity'];
			$shape = $this->getSpecialshapeAbbr($stone['shape']);
			
			//CALL for price
			$cfp_data = $this->getCallForPriceData();
			$price = "CALL";
			if(!$cfp_data["is_cfp"])
				$price = number_format(round((float)$stone['totalprice']));
				
			$link=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB)."diamond-search".DS.$stone['carat']."-".$stone['shape']."-".$stone['cut']."-".$stone['certificate']."-".$color."-".$stone['clarity']."-diamond-stock-".$stone['lotno']."-cert-".$stone['cert_number'] ;

			$diamonds[] = array(
				"compare" => (in_array($stone['id'],$compare_params)?true:false),
				"id" => (int)$stone['id'],
				"lotno" => $stone['lotno'],
				"shape" => $shape,
				"carat" => number_format((float)$stone['carat'], 2, '.', ''),
				"color" => strtoupper($color),
				"clarity" =>$stone['clarity'],
				"cut" => strtoupper($stone['cut']),
				"fluorescence" => strtoupper(trim($stone['fluorescence'])),
				"ratio" => round($stone['ratio'],2),
				"certificate" => $stone['certificate'],
				"inhouse" => $stone['inhouse'],
				//"totalprice" => str_replace(".00","",Mage::helper('core')->currency($price, true, false)),
				"totalprice" => $currencySym.$price,
				"percent_rap" => round((float)$stone['percent_rap']),
				"availability" => $stone['availability'],
				"dimensions" => $stone['dimensions'],
				"depth" => $stone['depth'],
				"tabl" => $stone['tabl'],
				"polish" => strtoupper($stone['polish']),
				"symmetry" => strtoupper($stone['symmetry']),
				"culet" => strtoupper($stone['culet']),
				"cert_number" => $stone['cert_number'],
				"certificate" => strtoupper($stone['certificate']),
				"crown" => $stone['crown'],
				"pavilion" => $stone['pavilion'],
				"girdle" => strtoupper($stone['girdle']),
				"make" => $stone['make'],
				"country" => $stone['country'],
				//"gem_advisor" => $stone['gem_advisor'],
				//"helium_report" => $stone['make'],
				"image" => $stone['diamond_image'],
				"shape_fullname" => $this->getSpecialAbbrnew($stone['shape']),
				"view" => $link
			);
			
		}
		return $diamonds;
	}
	function sortByOrder($a, $b) {return $a['sortorder'] - $b['sortorder'];}
	function getSlidersData()
	{
		//get Shape Configs
		$shapeConfig = unserialize(Mage::getStoreConfig("diamondsearch/shape_settings/shape_available"));
		usort($shapeConfig, 'sortByOrder');
		$shapesLabelArray = array();
		$shapesArray = array();
		foreach ($shapeConfig as $_item):
			$shapesLabelArray[] = $_item["label"];
			$shapesimageArray[] = $_item["shapeimage"];
			$shapesArray[] = array("label" => $_item["label"], "sortorder" => $_item["sortorder"]);
		endforeach;
		print_r($shapesArray);
		return $shapesArray;
	}
	function getDiamondsHtml($stones, $is_fancy)
	{
		//$resultHlml = '<div class="container top-tweny-list" style="">';
			$resultHlml .= '<div class="mobile-ajax-loading" style="width: 100%; position: relative; display: none;">';
				$resultHlml .= '<div class="loading" >';
					$resultHlml .= '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/base/default/dsearch/image/ajax-loading.gif" width="66" height="66" style="display:inline" />';
				$resultHlml .= '</div>';
			$resultHlml .= '</div>';
			
			$resultHlml .= '<div class="mobile-results-table row">';
				$resultHlml .= '<table class="table">';
				$resultHlml .= '<tbody>';
				
				foreach ( $stones as $stone) {
					$color = $stone['color'];
					if($is_fancy) $color = $stone['fancycolor']." ".$stone['fancy_intensity'];
					
					$eedata = "{'category': 'Loose Diamonds', 'name': '".$stone['carat']." Carat ".$stone['shape']." Diamond', 'price': '".$stone['totalprice']."', 'dimension14': '".$stone['cut']."', 'dimension15': '".$stone['clarity']."', 'dimension16': '".$stone['shape']."', 'id': '".$stone['id']."', 'dimension12': '".$stone['carat']."', 'dimension13': '".$stone['polish']."'}";
					$resultHlml .= '<tr data-ee-data="'.$eedata.'" class="ee-diamond" onclick="setLocation(\''.Mage::getUrl("diamond-search/index/view", array("id"=>$stone['id'])).'\')">';
					$resultHlml .= '<th rowspan="2" scope="row">';
					$resultHlml .= '<a href="'.Mage::getUrl("diamond-search/index/view", array("id"=>$stone['id'])).'">';
					$resultHlml .= '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/base/default/dsearch/shapes/'.strtolower($stone['shape']).'_pic.jpg" width="60" alt="" />';
					$resultHlml .= '</a>';
					$resultHlml .= '<br/>';
					$resultHlml .= $stone['shape'];
					$resultHlml .= '</th>';
					$resultHlml .= '<td class="compact-b"><span class="fs-14">'.round($stone['carat'],2).'</span><br>CARAT</td>';
					$resultHlml .= '<td class="compact-b"><span class="fs-14">'.$color.'</span><br>COLOR</td>';
					$cfp_data = $this->getCallForPriceData();
					if($cfp_data["is_cfp"])
						$resultHlml .= '<td rowspan="2"><span class="fs-14">CALL</span></td>';
					else
						$resultHlml .= '<td rowspan="2"><span class="fs-14">$'.round((float)$stone['totalprice']).'</span></td>';
					$resultHlml .= '<td rowspan="2"><a href="'.Mage::getUrl("diamond-search/index/view", array("id"=>$stone['id'])).'" class="glyphicon glyphicon-play"></a></td>';
					$resultHlml .= '</tr>';
					$resultHlml .= '<tr onclick="setLocation(\''.Mage::getUrl("diamond-search/index/view", array("id"=>$stone['id'])).'\')">';
					$resultHlml .= '<td class="compact-t"><span class="fs-14">'.$stone['cut'].'</span><br>CUT</td>';
					$resultHlml .= '<td class="compact-t"><span class="fs-14">'.$stone['clarity'].'</span><br>CLARITY</td>';
					$resultHlml .= '</tr>';
					
				} 
				
				$resultHlml .= '</tbody>';
				$resultHlml .= '</table>';
			$resultHlml .= '</div>';
		
			$resultHlml .= '<div class="loading_icon" style="text-align: center; display: none; margin-top:20px;">';
				$resultHlml .= '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/base/default/dsearch/image/ajax-loading.gif" width="66" height="66" style="display:inline" />';
			$resultHlml .= '</div>';
		
		//$resultHlml .= '</div>';
		//$resultHlml .= '<input class="freshLastOnPage hiddenData" type="hidden" value="10" />';
		//$resultHlml .= '<input class="freshTotalOnPage hiddenData" type="hidden" value="38387" />';
				
		return $resultHlml;
	}
	function getColumnOrder($columnName, $value)
	{
		if($columnName == "color")
		{
			$colors = array("", "D", "E", "F", "G", "H", "I", "J", "K", "L-Z");
			return (in_array(strtoupper($value), $colors)) ? array_search(strtoupper($value), $colors) : 0;
		}
		else if($columnName == "cut")
		{
			$cuts = array("", 'EX', 'VG', 'G', 'F');
			return (in_array(strtoupper($value), $cuts)) ? array_search(strtoupper($value), $cuts) : 0;
		}
		else if($columnName == "clarity")
		{
			$clarities = array("", "FL", "IF", "VVS1", "VVS2", "VS1", "VS2", "SI1", "SI2", "SI3", "I1");
			return (in_array(strtoupper($value), $clarities)) ? array_search(strtoupper($value), $clarities) : 0;
		}
		else if($columnName == "fluorescence")
		{
			$fluorescences = array("", "VS", "S", "M", "F", "N");
			return (in_array(strtoupper($value), $fluorescences)) ? array_search(strtoupper($value), $fluorescences) : 0;
		}
		else if($columnName == "certificate")
		{
			$certificates = array("", 'GIA', 'EGL', 'EGL - USA', 'HRD', 'IGI', 'AGS', 'Non-Certified');
			return (in_array(strtoupper($value), $certificates)) ? array_search(strtoupper($value), $certificates) : 0;
		}
		else{return 0;}
	}
	/*function getColumnAbbreviations($columnName, $fullArr)
	{
		$newAbbr = array();
		if($columnName == "cut") {
			$base = array("EX" => "EXCELLENT", "VG" => "VERY GOOD", "G" => "GOOD", "F" => "FAIR");
			foreach($fullArr as $cut)
			{
				$newAbbr[] = (in_array(strtoupper($cut), $base)) ? array_search(strtoupper($cut), $base) : $cut;
				//if(in_array(strtoupper($cut), $base))
				//	$newCuts[] = array_search (strtoupper($cut), $base);
				//else
				//	$newCuts[] = $cut;
			}
		}
		else if($columnName == "fluorescence") {
			$base = array("VS" => "VERY STRONG", "S" => "STRONG", "M" => "MEDIUM", "F" => "FAINT", "N" => "NONE");
			foreach($fullArr as $fluorescence)
			{
				$newAbbr[] = (in_array(strtoupper($fluorescence), $base)) ? array_search(strtoupper($fluorescence), $base) : $fluorescence;
			}
		}
		return $newAbbr;
	}*/
	function getShortCodes($columnName, $fullArr)
	{
		$newAbbr = array();

		$sliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/".$columnName."_slider"));
		$baseArray = array();
		foreach ($sliderConfig as $_item):
			$baseArray[strtoupper($_item["label"])] = $_item["code"];
		endforeach;
		foreach($fullArr as $code)
		{
			$codesArr = explode(",",$baseArray[strtoupper($code)]);
			for($c=0;$c<count($codesArr);$c++){
				$newAbbr[] = $codesArr[$c];
			}
		}
		return $newAbbr;
	}
	
	function getInitSearchPanelDataJson()
	{
		$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();
		
		/*
		$shapeConfig = unserialize(Mage::getStoreConfig("diamondsearch/shape_settings/shape_available"));
		$shapesLabelArray = array();
		foreach ($shapeConfig as $_item):
		$shapesArray[] = "'".$_item["label"]."'";
		endforeach;
		$shape=implode(",",$shapesArray);
		
		$colorSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/color_slider"));
		//usort($colorSliderConfig, 'sortByOrder');
		$colorsArray = array();
		foreach ($colorSliderConfig as $_item):
		$colorsArray[] = "'".$_item["label"]."'";
		endforeach;
		$color=implode(",",$colorsArray);
		
		$claritySliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/clarity_slider"));
		$claritiesArray = array();
		foreach ($claritySliderConfig as $_item):
		$claritiesArray[] = "'".$_item["label"]."'";
		endforeach;
		$clariti=implode(",",$claritiesArray);
		
		$certificateSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/certificate_slider"));
		$certificatesArray = array();
		foreach ($certificateSliderConfig as $_item):
		$certificatesArray[] = "'".$_item["label"]."'";
		endforeach;
		$certificate=implode(",",$certificatesArray);
		*/
		$diamondsCollection->getSelect()
		->reset(Zend_Db_Select::COLUMNS)
		->columns('min(`carat`) AS min_carat, max(`carat`) AS max_carat, min(`totalprice`) AS min_totalprice, max(`totalprice`) AS max_totalprice, min(`ratio`) AS min_ratio, max(`ratio`) AS max_ratio')
		//->where("(shape in ($shape)) and (color in ($color)) and (clarity in ($clariti)) and (certificate in ($certificate))")
		->where("`carat` != 0 AND `totalprice` != 0")
		;
		//echo $diamondsCollection->getSelect();
		//echo "<pre>";print_r($diamondsCollection->getData());exit;
		$respArray = array();
		if($diamondsCollection->getSize()){
			$mainColl = $diamondsCollection->getData();
			$respArray["min_carat"] = round($mainColl[0]["min_carat"],2);
			$respArray["max_carat"] = round($mainColl[0]["max_carat"],2);
			$respArray["min_totalprice"] = round($mainColl[0]["min_totalprice"]);
			$respArray["max_totalprice"] = round($mainColl[0]["max_totalprice"]);
			$respArray["min_ratio"] = round($mainColl[0]["min_ratio"],2);
			$respArray["max_ratio"] = round($mainColl[0]["max_ratio"],2);
		}
		
		return $respArray;
	}
		
	function getShapeRangesJson()
	{
		$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();
		/* FOR EAV
			->addFieldToSelect('shape')
			->addExpressionFieldToSelect('max_carat', 'MAX(carat)', 'min_carat', 'MIN(carat)');
			$diamondsCollection->getSelect()->group('shape');*/

		$diamondsCollection->getSelect()
			->reset(Zend_Db_Select::COLUMNS)
			->columns('`shape`, min(`carat`) AS min_carat, max(`carat`) AS max_carat, min(`totalprice`) AS min_totalprice, max(`totalprice`) AS max_totalprice')
			->where("`carat` != 0 AND `totalprice` != 0")
			->group('shape');
		$mainColl = $diamondsCollection->getData();
		//echo $diamondsCollection->getSelect();
		//echo "<pre>";
		
		//creating array for JSON response
		$respArray = array();

		$min_totalprice = array();
		$max_totalprice = array();
		$min_carat = array();
		$max_carat = array();
		foreach ($mainColl as $diam)
		{
			$min_totalprice[] = $diam["min_totalprice"];
			$max_totalprice[] = $diam["max_totalprice"];
			$min_carat[] = $diam["min_carat"];
			$max_carat[] = $diam["max_carat"];
			
			$respArray[ucfirst(strtolower($diam["shape"]))] = array(
				(float)$diam["min_totalprice"], 
				(float)$diam["max_totalprice"],
				(float)$diam["min_carat"], 
				(float)$diam["max_carat"]
			);
		}
		//For shape - ALL
		$respArray[ucfirst("All")] = array(
			(float)min($min_totalprice), (float)max($max_totalprice), (float)min($min_carat), (float)max($max_carat)
		);
		
		//For remaining shapes. Checking from admin
		$shapeConfig = unserialize(Mage::getStoreConfig("diamondsearch/shape_settings/shape_available"));
		foreach ($shapeConfig as $_item){
			$shp = str_replace(" ","_",ucfirst(strtolower($_item["label"])));
			if(!$respArray[$shp]){
				$respArray[$shp] = array(
					(float)min($min_totalprice), (float)max($max_totalprice), (float)min($min_carat), (float)max($max_carat)
				);
			}
		}
		return json_encode($respArray);
	}
	
	function setAsRecentlyViewed($diamondId)
	{
		try{
			$diamondIds = Mage::getSingleton('core/session')->getRecentlyViewed();
			
			if(count($diamondIds)>0)
				array_unshift($diamondIds, $diamondId);//always insert to 0 index
			else $diamondIds[] = $diamondId;
			//limit array to 20 ids. Removing last element
			$diamondIds = array_slice(array_unique(array_filter($diamondIds)),0,20);

			Mage::getSingleton('core/session')->setRecentlyViewed( $diamondIds );
			return true;
		}
		catch(Exception $ex){ return false;}
	}
	
	function filterSliderArray($array = array())
	{
		$arrVal = $array["value"];
		$arrDel = $array["delete"];
		/*for($i=0; $i<count($arrVal); $i++)
		{
			//if(empty(  $row['label']) || ) unset($array[$key]);
		}*/
		
		foreach($arrVal as $key => $row) {
			//echo $key. " - ".$arrDel[$key]."<br>" ;
		   if(empty($row['label']) || $arrDel[$key] == 1 ) unset($arrVal[$key]);
		}
		return $arrVal;
	}
	
	function getCallForPriceData()
	{
		$cfp_data = array("is_cfp" => 0, "cfp_msg" => "");
		try{
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
			$table2 = Mage::getSingleton('core/resource')->getTableName('uploadtool_settings');
			$query2 = "SELECT * FROM `$table2`";
			$result2 = @mysql_db_query($mdb_name, $query2) or die("Failed Query of ".$query2);
			
			while($row = mysql_fetch_array($result2))
			{
				if($row['field'] == 'diamond_cfp_enabled') {
					$cfp_data["is_cfp"] = $row['value'];
				}
				if($row['field'] == 'diamond_cfp_message') {
					$cfp_data["cfp_msg"] = $row['value'];
				}
			}
		}
		catch(Exception $ex){ }
		return $cfp_data;
	}
	function getTemplatePath()
	{
		$skin = "diamondsearch/diamondsearch-new.phtml";
		if(Mage::getStoreConfig("diamondsearch/general_settings/ds_skin") == "Old") $skin = "diamondsearch/diamondsearch-old.phtml";
		return $skin;
	}
	
	function isMobile()
	{
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		{
			return true;
		}
		else {
			return false;
		}
	}
	
	public function resizeImage($imageName, $width=NULL, $height=NULL, $imagePath=NULL)
	{
		$imagePath = str_replace("/", DS, $imagePath);
		$imagePathFull = Mage::getBaseDir('media') . DS . $imagePath . DS . $imageName;
	
		if($width == NULL && $height == NULL) {
			$width = 100;
			$height = 100;
		}
		$resizePath = $width . 'x' . $height;
		$resizePathFull = Mage::getBaseDir('media') . DS . $imagePath . DS . $resizePath . DS . $imageName;
			
		if (file_exists($imagePathFull) && !file_exists($resizePathFull)) {
			$imageObj = new Varien_Image($imagePathFull);
			$imageObj->constrainOnly(TRUE);
			$imageObj->keepAspectRatio(TRUE);
			$imageObj->backgroundColor(array(242,242,242));
			$imageObj->resize($width,$height);
			$imageObj->save($resizePathFull);
		}
			
		$imagePath=str_replace(DS, "/", $imagePath);
		return Mage::getBaseUrl("media") . $imagePath . "/" . $resizePath . "/" . $imageName;
	}
	
	function getSpecialshapeAbbr($value)
	{ 
		$arrayFF = array (
			"ascendancy_heart_arrows" =>  "H&A",
			"platinum_select_round"=>"Plat Ideal",
			"the_solasfera_diamond"=>"Solas RD",
			"the_star_129"=>"Star129",
			"the_octavia_asscher"=>"Sig Asch",
			"the_solasfera_princess"=>"Solas PR",
			"ideal2_hearts_arrows"=>"Ideal2",
			"august_vintage_cushion"=>"AVC",
			"platinum_select_vintage"=>"Plat Vint",   
			"platinum_select_princess"=>" Plat PR",
			"august_vintage_european"=>"AVR",
			"august_vintage_star"=>"AVC*",
			"platinum_select_modern"=>"Plat Mod",
			"the_solasfera_princess"=>"Solas PR",
			"brellia_cushion_hearts"=>"CU H&A",
			) ;
		if($arrayFF[$value]){
			return $arrayFF[$value];
		}else{return $value;
		}	
	}
	function getSpecialAbbrnew($value)
	{ 
	    
		$arrayFF = array (
			"ascendancy_heart_arrows" =>  "Ascendancy Hearts & Arrows Round Cut",
			"platinum_select_round"=>"Platinum Select Round Brilliant",
			"the_solasfera_diamond"=>"Solasfera Diamond",
			"the_star_129"=>"Star129",
			"the_octavia_asscher"=>"SIGNATURE ASSCHER",
			"the_solasfera_princess"=>"The Solasfera Princess Cut",
			"ideal2_hearts_arrows"=>"Ideal2 Hearts & Arrows Radiant",
			"august_vintage_cushion"=>"August Vintage® Cushion",
			"platinum_select_vintage"=>"Platinum Select Vintage Cushion",   
			"platinum_select_princess"=>"Platinum select princess cut",
			"august_vintage_european"=>"August Vintage® European Cuts",
			"august_vintage_star"=>"August Vintage® Cushion",
			"platinum_select_modern"=>"Platinum Select Modern Cushion",
			"brellia_cushion_hearts"=>"CUSHION HEARTS & ARROWS",
			) ;
		
		if($arrayFF[$value]){
			return $arrayFF[$value];
		}else{return $value;
		}	
	
	}
}
