<?php
class Ideal_Diamondsearch_AjaxController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();

			$diamondsCollection->addFieldToFilter('shape', array('in' => explode(",", $_REQUEST["shapes"])));
			$diamondsCollection->addFieldToFilter('id', array(
			'from' => 1200,
			'to' => 1203,
			));
			$diamondsCollection->setOrder("id", 'desc');
			//echo $diamondsCollection->getSelect();
			
			//echo "<pre>";
			//print_r($diamondsCollection->getData());
    }
    public function listAction()
    {
    	/*$colorSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/color_slider"));
    	//usort($colorSliderConfig, 'sortByOrder');
    	$colorsArray = array();
    	foreach ($colorSliderConfig as $_item):
    	$colorsArray[] = "".$_item["label"]."'";
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
    	$certificate=implode(",",$certificatesArray);*/
    	
		/***** fetching configs *****/
    	//shape
    	$shapeConfig = unserialize(Mage::getStoreConfig("diamondsearch/shape_settings/shape_available"));
    	//FOR PHP 5.3 usort($shapeConfig, function($a, $b) {return $a['sortorder'] - $b['sortorder'];});
    	$shapesLabelArray = array();
    	foreach ($shapeConfig as $_item):
    		$shapesArray[] = $_item["label"];
    	endforeach;
		
		if(Mage::getStoreConfig("diamondsearch/general_settings/spacial_diamond_avilability")){
			$specialshapeConfig = unserialize(Mage::getStoreConfig("diamondsearch/shape_settings/specialshape_available"));
			$specialshapesLabelArray = array();
			foreach ($specialshapeConfig as $_item):
			$shapesArray[] = $_item["text"];
			endforeach;
		}
    	$shape=implode(",",$shapesArray);
		
		//color
		$colorSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/color_slider"));
		//usort($colorSliderConfig, 'sortByOrder');
		$colorsArray = array();
		foreach ($colorSliderConfig as $_item):
			 $colorsArray[] = $_item["label"];
		endforeach;
		//fancycolor
		$fancycolorSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/fancycolor_slider"));
		$fancycolorsArray = array();
		foreach ($fancycolorSliderConfig as $_item):
			 $fancycolorsArray[] = $_item["label"];
		endforeach;
		//clarity
		$claritySliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/clarity_slider"));
		$claritiesArray = array();
		foreach ($claritySliderConfig as $_item):
			 $claritiesArray[] = $_item["label"];
		endforeach;
		//cut
		$cutSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/cut_slider"));
		$cutsArray = array();
		foreach ($cutSliderConfig as $_item):
			 $cutsArray[] = $_item["label"];
		endforeach;
		//fluorescence
		$fluorescenceSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/fluorescence_slider"));
		$fluorescencesArray = array();
		foreach ($fluorescenceSliderConfig as $_item):
			 $fluorescencesArray[] = $_item["label"];
		endforeach;
		//certificate
		$certificateSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/certificate_slider"));
		$certificatesArray = array();
		foreach ($certificateSliderConfig as $_item):
			 $certificatesArray[] = $_item["label"];
		endforeach;
		/***** fetching configs ENDS *****/

		$postedJSON = file_get_contents('php://input');
		$post= json_decode($postedJSON, TRUE); 
		/*echo $post["limit"];
		print_r($post);
		exit;
		*/
		
		$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();

		if(isset($post["shapes"]))
		{
			//print_r(explode(",", $post["shapes"]));
			if(!in_array("All", explode(",", $post["shapes"])))
				$diamondsCollection->addFieldToFilter('shape', array('in' => explode(",", $post["shapes"])));
			else
				$diamondsCollection->addFieldToFilter('shape', array('in' => $shapesArray));
		}
		/*
		elseif(isset($post["specialshapes"]) && $post["specialshapes"] != '' )
		{
			$spacialSearchPara=array();
			$searchlabel=array();
			$searchlabel=explode(",", $post["specialshapes"]);
			foreach($searchlabel as $search)
			{
				if(array_key_exists($search,$specialshapesLabelArray))
				{
					$spacialSearchPara[]=$specialshapesLabelArray[$search];
				}
			}
			$diamondsCollection->addFieldToFilter('spacialshape', array('in' => $spacialSearchPara));
		} 
		*/
		if(isset($post["min_carat"]) && isset($post["max_carat"]) )
		{
			$diamondsCollection->addFieldToFilter('carat', array(
				'from' => $post['min_carat'],
				'to' => $post['max_carat'],
			));
		}
		if(isset($post["min_price"]) && isset($post["max_price"]) )
		{
			$diamondsCollection->addFieldToFilter('totalprice', array(
				'from' => $post['min_price'],
				'to' => $post['max_price'],
			));
		}
		if(isset($post["colors"]) && $post["is_fancy"] == 0)
		{
			/*if($post["colors"] == "L-Z")
				$diamondsCollection->addFieldToFilter('color', array('nin' => array("D", "E", "F", "G", "H", "I", "J", "K")));
			else
				$diamondsCollection->addFieldToFilter('color', array('in' => explode(",", $post["colors"])));*/
			$colors = explode(",", $post["colors"]);
			$likeColors = array();
			for($i=0;$i<count($colors);$i++)
			{
				if (strpos($colors[$i],'-') !== false) { //check for range, eg. L-Z
					$clrs = explode("-", $colors[$i]);
					$clrs = range($clrs[0], $clrs[1]);
					for($r = 0; $r< count($clrs); $r++)
						//$likeColors[] = array('like' => $clrs[$r]."%");
						$likeColors[] = array('eq' => $clrs[$r]);
				}
				else{
					//$likeColors[] = array('like' => $colors[$i]."%");
					$likeColors[] = array('eq' => $colors[$i]);
				}
			}
			$diamondsCollection->addFieldToFilter('color', $likeColors);
		}
		elseif(isset($post["fancycolors"]) && $post["is_fancy"] == 1)
		{ 
			$diamondsCollection->addFieldToFilter('fancy_intensity', array('in' => Mage::helper("diamondsearch")->getShortCodes("fancycolor", explode(",", $post["fancycolors"])) ));
		}
		//if(isset($post["clarities"]) && count($claritiesArray) != count(explode(",", $post["clarities"]))) 
		if(isset($post["clarities"]))
		{
			$diamondsCollection->addFieldToFilter('clarity', array('in' => explode(",", $post["clarities"])));
		}
		/*
		//if(isset($post["cuts"]) && count($cutsArray) != count(explode(",", $post["cuts"])))
		if(isset($post["cuts"]))
		{
			$diamondsCollection->addFieldToFilter('trim(cut)', array('in' => Mage::helper("diamondsearch")->getShortCodes("cut", explode(",", $post["cuts"])) ));
		}
		*/
		if(isset($post["cuts"]) && count($cutsArray) != count(explode(",", $post["cuts"])))
		{
			$diamondsCollection->addFieldToFilter('cut', array('in' => Mage::helper("diamondsearch")->getShortCodes("cut", explode(",", $post["cuts"])) ));
		}
		/*
		//if(isset($post["fluorescences"]) && count($fluorescencesArray) != count(explode(",", $post["fluorescences"])))
		if(isset($post["fluorescences"]))
		{
			$diamondsCollection->addFieldToFilter('trim(fluorescence)', array('in' => Mage::helper("diamondsearch")->getShortCodes("fluorescence", explode(",", $post["fluorescences"])) ));
		}
		*/
		if(isset($post["fluorescences"]) && count($fluorescencesArray) != count(explode(",", $post["fluorescences"])))
		{
			$diamondsCollection->addFieldToFilter('fluorescence', array('in' => Mage::helper("diamondsearch")->getShortCodes("fluorescence", explode(",", $post["fluorescences"])) ));
		}
		/*if(isset($post["min_ratio"]) && isset($post["max_ratio"]) )
		{
			$where[] = " AND `ratio` BETWEEN '".$post['min_price']."' AND '".$post['max_price']."' ";
		}*/
		if(isset($post["min_ratio"]) && isset($post["max_ratio"]) )
		{
			$diamondsCollection->addFieldToFilter('ratio', array(
				'from' => $post['min_ratio'],
				'to' => $post['max_ratio'],
			));
		}
		
		//if(isset($post["certificates"]) && count($certificatesArray) != count(explode(",", $post["certificates"])))
		if(isset($post["certificates"]))
		{
			//if($post["certificates"] == "Non-Certified")
			//	$diamondsCollection->addFieldToFilter('certificate', array('eq' => ""));
			//else
			//	$diamondsCollection->addFieldToFilter('certificate', array('in' => explode(",", $post["certificates"])));
			$certificates = explode(",", $post["certificates"]);
			$likeCertificates = array();
			for($i=0;$i<count($certificates);$i++)
			{
				if($certificates[$i] == "Non-Certified")
				{
					$likeCertificates[] = array('like' => "NONE%");
					$likeCertificates[] = array('like' => "");
				}
				else
					$likeCertificates[] = array('like' => $certificates[$i]."%");
			}
			$diamondsCollection->addFieldToFilter('certificate', $likeCertificates);
		}
		else
		{
			$certificates = $certificatesArray;
			for($i=0;$i<count($certificates);$i++)
			{
				if($certificates[$i] == "Non-Certified")
				{
					$likeCertificates[] = array('like' => "NONE%");
					$likeCertificates[] = array('like' => "");
				}
				else
					$likeCertificates[] = array('like' => $certificates[$i]."%");
			}
			$diamondsCollection->addFieldToFilter('certificate', $likeCertificates);
		}
		
		if(isset($post["custom_certs"]))
		{
			 
			$custom_certificatearray = explode(",", $post["custom_certs"]);
			if (in_array("H&A", $custom_certificatearray)) 
			{
			   $spacialSearchPara=array();
			   $searchlabel=array('Ascendancy™ Hearts & Arrows Round Cut','Platinum Select Round Brilliant','Platinum Select Vintage Cushion','Platinum Select Modern Cushion','Platinum select princess cut');
			 
				foreach($searchlabel as $search)
				{
					if(array_key_exists($search,$specialshapesLabelArray))
					{
						$spacialSearchPara[]=$specialshapesLabelArray[$search];
					}
				}
			 
				$diamondsCollection->addFieldToFilter('spacialshape', array('in' => $spacialSearchPara));			
			}	
			if (in_array("AGS0", $custom_certificatearray)) 
			{
					$diamondsCollection->addFieldToFilter('cut', array('like' => "i"));
			}
			if (in_array("GIA3X", $custom_certificatearray)) 
			{
					$diamondsCollection->addFieldToFilter('cut', array('like' => "ex"));
			}		 
		}
		
		if(isset($post["custom_images"]))
		{
			$custom_imagesarray = explode(",", $post["custom_images"]);
			if (in_array("dimage", $custom_imagesarray))
			{
				$diamondsCollection->addFieldToFilter('diamond_image', array('neq' => '' ));
			//	echo $diamondsCollection->getSelect(); 
			}
			if (in_array("certimage", $custom_imagesarray))
			{
				$diamondsCollection->addFieldToFilter('image', array('neq' => '' ));
			}
			if (in_array("I&S Image", $custom_imagesarray))
			{
				
			}
			if (in_array("H&A Image", $custom_imagesarray))
			{
				
			}
			if (in_array("Sarin", $custom_imagesarray))
			{
				
			}
			if (in_array("3D Sarin", $custom_imagesarray))
			{
				
			} 
			if (in_array("GemAdvisor", $custom_imagesarray))
			{
				$diamondsCollection->addFieldToFilter('gem_advisor', array('neq' => '' ));
			}
			if (in_array("ASET Image", $custom_imagesarray))
			{
				
			}
			 
			
		}
		
		
		/*
		if(isset($post["certificates"]) && count($certificatesArray) != count(explode(",", $post["certificates"])))
		{
			$certificates = explode(",", $post["certificates"]);
			$likeCertificates = array();
			for($i=0;$i<count($certificates);$i++)
			{
				if($certificates[$i] == "Non-Certified")
				{
					$likeCertificates[] = array('like' => "NONE%");
					$likeCertificates[] = array('like' => "");
				}
				else
					$likeCertificates[] = array('like' => $certificates[$i]."%");
			}
			$diamondsCollection->addFieldToFilter('certificate', $likeCertificates);
		}
		*/
		            
		if(isset($post["stock_number"])) //shipping_day is STOCK_NUMBER here
		{
			$diamondsCollection->addFieldToFilter('lotno', array('like' => "%".$post["stock_number"]."%"));
		}
		//adding InHouse Column	
		
		/*Mage::getStoreConfig("diamondsearch/general_settings/inhousetextyes"))
				{
					 $InHouse=Mage::getStoreConfig("diamondsearch/general_settings/inhousetextyes");
				}
				else
				{
					 $InHouse="Yes";
				}
			
			}
			elseif(Mage::getStoreConfig("diamondsearch/general_settings/inhousetext"))
			*/
		
		$inHouseIfNo = "No";
		if(Mage::getStoreConfig("diamondsearch/general_settings/inhousetext"))
			$inHouseIfNo = Mage::getStoreConfig("diamondsearch/general_settings/inhousetext");
		$inHouseIfYes = "Yes";
		if(Mage::getStoreConfig("diamondsearch/general_settings/inhousetextyes"))
			$inHouseIfYes = Mage::getStoreConfig("diamondsearch/general_settings/inhousetextyes");
			
		$inHouseOwner = Mage::getStoreConfig("diamondsearch/general_settings/inhouse_vendor");
		$diamondsCollection->getSelect()->columns('if(owner="'.$inHouseOwner.'","'.$inHouseIfYes.'","'.$inHouseIfNo.'") as inhouse');
		
		/*if(isset($post["is_inhouse"])){
			$diamondsCollection->getSelect()->having("inhouse = 'Yes'");
		}*/
		
		$configOrder=Mage::getStoreConfig("diamondsearch/general_settings/deafault_filter_by");
		$orderby = $configOrder;		 
		//$orderby = "totalprice";

		if($post["sort"]) 
		{
			$orderby = $post["sort"];
			if($post["sort"] == "color" && $post["is_fancy"] == 1)
				$orderby = "fancycolor";
			if($post["sort"] == "shape" && $post["is_specialshape"] == 1)
				$orderby = "spacialshape"; //specialshape
		}
		
		$orderMethod = "ASC";
		if($post["order"])
		{
			$orderMethod = $post["order"];
		}
		
		//$diamondsCollection->setOrder($orderby, $orderMethod);
		$diamondsCollection->getSelect()->order($orderby." ".$orderMethod);
		
		//$coll1 = clone $diamondsCollection;
		$total_count = $diamondsCollection->getSize();

		//have to add HAVING clause at LAST
		if(isset($post["is_inhouse"]) && $post["is_inhouse"]==1){
			$diamondsCollection->getSelect()->having("inhouse = 'Yes'");
			$total_count = count($diamondsCollection);
		}

		$diamondsCollection->getSelect()->limit($post["limit"], (int)$post["offset"]);
		//$stones = $diamondsCollection->getData();
		//echo $selQuery = $diamondsCollection->getSelect()." CNT: ".count($stones);
		//echo $diamondsCollection->getSelect();
		//echo "CNT: ".count($stones);
		//echo "<pre>";
		//print_r($stones);
		//exit;
		 
		if($post["is_mobile"]){
			$diamondsCollection->getSelect()->limit($post["requestedDataSize"], (int)$post["row"]);
			$stones = $diamondsCollection->getData();
			$dHtml = '<div class="container top-tweny-list" style="">';
			$dHtml .= Mage::helper("diamondsearch")->getDiamondsHtml($stones, $post["is_fancy"]);
			$dHtml .= '</div>';
			$rw = ( ((int)$post["row"]) + 10);
			$rds = $post["requestedDataSize"];
			if($total_count - $rw > $post["requestedDataSize"])
				$rds = $post["requestedDataSize"];
			else 
				$rds = $total_count - $rw;
			$dHtml .= '<input class="freshLastOnPage hiddenData" type="hidden" value="'.$rw.'" />';
			$dHtml .= '<input class="freshTotalOnPage hiddenData" type="hidden" value="'.$total_count.'" />';
			$smd = "{'row': ".$rw.", 'requestedDataSize': ".$rds.", 'formerUrl': '?".htmlspecialchars($_SERVER['QUERY_STRING'])."','show_more': 'True'}";
			
			if($rw >= $total_count){
				$dHtml .= '<script type="text/javascript">
							window.onscroll = null
							</script>';
			}else{
				$dHtml .= '<script type="text/javascript">
						  var show = true;
						  window.onscroll = function() {
						    var window_height = jQuery(window).height();
						    var body_height = (jQuery(".wrapper").height())*0.80;
						    var scroll_top = jQuery(window).scrollTop();
							//console.log("window_height: " + window_height + "body_height: " + body_height + "scroll_top: " + scroll_top);
						    if (window_height + scroll_top > body_height && show) {
						      show = false
						      showMoreDiamonds('.$smd.');
						    }
						  }
						</script>';
			}
			echo $dHtml;
			exit;
			
		} //is_mobile ENDS
		else{
			
			$stones = $diamondsCollection->getData();
			//echo "<pre>";
			//print_r($stones);
			$diamonds = Mage::helper("diamondsearch")->getDiamondsArray($stones, $post["is_fancy"], $post["is_specialshape"]);

			$result = array("total"=>$total_count);
			$result["rows"] = $diamonds;
			echo json_encode($result);
			exit;
			
			/*if(isset($post["inhouse_products"]))
			{
			 	foreach ($diamonds as $subKey => $diam)
				{
					if(trim($diam['InHouse'])=='By Order') { unset( $diamonds[$subKey]);}
				}
			}*/	   
			
			$row=$post["requestedDataSize"]-1;	
			$diamonds = array_slice($diamonds, 0, $row); 
			$list = array(
				"cyo_shapes" => explode(",", $post["shapes"]),
				"sid" => "",
				"order" => $orderMethod,
				"direct" => "none",
				"scroll_show" => true,
				"colors" => $post["colors"],
				"cuts" => $post["cuts"],
				"path" => "?".$_SERVER['QUERY_STRING'],
				"row" => (int)$post["row"],
				"sort" => $orderby,
				"total_count" => $total_count,
				"collections" => array(),
				"diamonds" => $diamonds,
				"clarities" => $post["clarities"],
				"fluorescence" => $post["fluorescences"],
				"similar" => array(),
				"first" => ""
			);

		}
	}
	
	public function gridAction()
    {
    	/***** fetching configs *****/
    	//shape
    	$shapeConfig = unserialize(Mage::getStoreConfig("diamondsearch/shape_settings/shape_available"));
    	//FOR PHP 5.3 usort($shapeConfig, function($a, $b) {return $a['sortorder'] - $b['sortorder'];});
    	$shapesLabelArray = array();
    	foreach ($shapeConfig as $_item):
    		$shapesArray[] = $_item["label"];
    	endforeach;
		
		if(Mage::getStoreConfig("diamondsearch/general_settings/spacial_diamond_avilability")){
			$specialshapeConfig = unserialize(Mage::getStoreConfig("diamondsearch/shape_settings/specialshape_available"));
			$specialshapesLabelArray = array();
			foreach ($specialshapeConfig as $_item):
			$shapesArray[] = $_item["text"];
			endforeach;
		}
    	$shape=implode(",",$shapesArray);
		
		//color
		$colorSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/color_slider"));
		//usort($colorSliderConfig, 'sortByOrder');
		$colorsArray = array();
		foreach ($colorSliderConfig as $_item):
			 $colorsArray[] = $_item["label"];
		endforeach;
		//fancycolor
		$fancycolorSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/fancycolor_slider"));
		$fancycolorsArray = array();
		foreach ($fancycolorSliderConfig as $_item):
			 $fancycolorsArray[] = $_item["label"];
		endforeach;
		//clarity
		$claritySliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/clarity_slider"));
		$claritiesArray = array();
		foreach ($claritySliderConfig as $_item):
			 $claritiesArray[] = $_item["label"];
		endforeach;
		//cut
		$cutSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/cut_slider"));
		$cutsArray = array();
		foreach ($cutSliderConfig as $_item):
			 $cutsArray[] = $_item["label"];
		endforeach;
		//fluorescence
		$fluorescenceSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/fluorescence_slider"));
		$fluorescencesArray = array();
		foreach ($fluorescenceSliderConfig as $_item):
			 $fluorescencesArray[] = $_item["label"];
		endforeach;
		//certificate
		$certificateSliderConfig = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/certificate_slider"));
		$certificatesArray = array();
		foreach ($certificateSliderConfig as $_item):
			 $certificatesArray[] = $_item["label"];
		endforeach;
		/***** fetching configs ENDS *****/
		
		/*$postedJSON = file_get_contents('php://input');
		$post= json_decode($postedJSON, TRUE); 
		echo $post["limit"];
		print_r($post);
		exit;
		*/
		$post = $_POST;

		$post["limit"] = $post["limit_grid"]; 
	    $post["offset"] =$post["offset_grid"]; 
	    $post["order"] =$post["order_grid"];
	    $post["sort"] =$post["sort_grid"]; 
    	
		$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();

		if(isset($post["shapes"]))
		{
			//print_r(explode(",", $post["shapes"]));
			if(!in_array("All", explode(",", $post["shapes"])))
				$diamondsCollection->addFieldToFilter('shape', array('in' => explode(",", $post["shapes"])));
			else
				$diamondsCollection->addFieldToFilter('shape', array('in' => $shapesArray));
		}
		if(isset($post["min_carat"]) && isset($post["max_carat"]) )
		{
			$diamondsCollection->addFieldToFilter('carat', array(
				'from' => $post['min_carat'],
				'to' => $post['max_carat'],
			));
		}
		if(isset($post["min_price"]) && isset($post["max_price"]) )
		{
			$diamondsCollection->addFieldToFilter('totalprice', array(
				'from' => $post['min_price'],
				'to' => $post['max_price'],
			));
		}
		if(isset($post["colors"]) && $post["is_fancy"] == 0)
		{
			$colors = explode(",", $post["colors"]);
			$likeColors = array();
			for($i=0;$i<count($colors);$i++)
			{
				if (strpos($colors[$i],'-') !== false) { //check for range, eg. L-Z
					$clrs = explode("-", $colors[$i]);
					$clrs = range($clrs[0], $clrs[1]);
					for($r = 0; $r< count($clrs); $r++)
						$likeColors[] = array('eq' => $clrs[$r]);
				}
				else{
					$likeColors[] = array('eq' => $colors[$i]);
				}
			}
			$diamondsCollection->addFieldToFilter('color', $likeColors);
		}
		elseif(isset($post["fancycolors"]) && $post["is_fancy"] == 1)
		{
			$diamondsCollection->addFieldToFilter('fancy_intensity', array('in' => Mage::helper("diamondsearch")->getShortCodes("fancycolor", explode(",", $post["fancycolors"])) ));
			//$diamondsCollection->addFieldToFilter('fancycolor', array('in' => Mage::helper("diamondsearch")->getShortCodes("fancycolor", explode(",", $post["fancycolors"])) ));
		}
		if(isset($post["clarities"]))
		{
			$diamondsCollection->addFieldToFilter('clarity', array('in' => explode(",", $post["clarities"])));
		}
		if(isset($post["cuts"]) && count($cutsArray) != count(explode(",", $post["cuts"])))
		{
			$diamondsCollection->addFieldToFilter('cut', array('in' => Mage::helper("diamondsearch")->getShortCodes("cut", explode(",", $post["cuts"])) ));
		}
		if(isset($post["fluorescences"]) && count($fluorescencesArray) != count(explode(",", $post["fluorescences"])))
		{
			$diamondsCollection->addFieldToFilter('fluorescence', array('in' => Mage::helper("diamondsearch")->getShortCodes("fluorescence", explode(",", $post["fluorescences"])) ));
		}
		if(isset($post["min_ratio"]) && isset($post["max_ratio"]) )
		{
			$diamondsCollection->addFieldToFilter('ratio', array(
				'from' => $post['min_ratio'],
				'to' => $post['max_ratio'],
			));
		}
		
		if(isset($post["certificates"]))
		{
			$certificates = explode(",", $post["certificates"]);
			$likeCertificates = array();
			for($i=0;$i<count($certificates);$i++)
			{
				if($certificates[$i] == "Non-Certified")
				{
					$likeCertificates[] = array('like' => "NONE%");
					$likeCertificates[] = array('like' => "");
				}
				else
					$likeCertificates[] = array('like' => $certificates[$i]."%");
			}
			$diamondsCollection->addFieldToFilter('certificate', $likeCertificates);
		}
		else
		{
			$certificates = $certificatesArray;
			for($i=0;$i<count($certificates);$i++)
			{
				if($certificates[$i] == "Non-Certified")
				{
					$likeCertificates[] = array('like' => "NONE%");
					$likeCertificates[] = array('like' => "");
				}
				else
					$likeCertificates[] = array('like' => $certificates[$i]."%");
			}
			$diamondsCollection->addFieldToFilter('certificate', $likeCertificates);
		}
		
		if(isset($post["custom_certs"]))
		{
			$custom_certificatearray = explode(",", $post["custom_certs"]);
			if (in_array("H&A", $custom_certificatearray)) 
			{
			   $spacialSearchPara=array();
			   $searchlabel=array('Ascendancy™ Hearts & Arrows Round Cut','Platinum Select Round Brilliant','Platinum Select Vintage Cushion','Platinum Select Modern Cushion','Platinum select princess cut');
			 
				foreach($searchlabel as $search)
				{
					if(array_key_exists($search,$specialshapesLabelArray))
					{
						$spacialSearchPara[]=$specialshapesLabelArray[$search];
					}
				}
			 
				$diamondsCollection->addFieldToFilter('spacialshape', array('in' => $spacialSearchPara));			
			}	
			if (in_array("AGS0", $custom_certificatearray)) 
			{
					$diamondsCollection->addFieldToFilter('cut', array('like' => "i"));
			}
			if (in_array("GIA3X", $custom_certificatearray)) 
			{
					$diamondsCollection->addFieldToFilter('cut', array('like' => "ex"));
			}		 
		}
		
		if(isset($post["custom_images"]))
		{
			$custom_imagesarray = explode(",", $post["custom_images"]);
			if (in_array("dimage", $custom_imagesarray))
			{
				$diamondsCollection->addFieldToFilter('diamond_image', array('neq' => '' ));
			}
			if (in_array("certimage", $custom_imagesarray))
			{
				$diamondsCollection->addFieldToFilter('image', array('neq' => '' ));
			}
			if (in_array("I&S Image", $custom_imagesarray))
			{
				
			}
			if (in_array("H&A Image", $custom_imagesarray))
			{
				
			}
			if (in_array("Sarin", $custom_imagesarray))
			{
				
			}
			if (in_array("3D Sarin", $custom_imagesarray))
			{
				
			} 
			if (in_array("GemAdvisor", $custom_imagesarray))
			{
				$diamondsCollection->addFieldToFilter('gem_advisor', array('neq' => '' ));
			}
			if (in_array("ASET Image", $custom_imagesarray))
			{
				
			}
		}
		if(isset($post["stock_number"])) //shipping_day is STOCK_NUMBER here
		{
			$diamondsCollection->addFieldToFilter('lotno', array('like' => "%".$post["stock_number"]."%"));
		}

		$inHouseIfNo = "No";
		if(Mage::getStoreConfig("diamondsearch/general_settings/inhousetext"))
			$inHouseIfNo = Mage::getStoreConfig("diamondsearch/general_settings/inhousetext");
		$inHouseIfYes = "Yes";
		if(Mage::getStoreConfig("diamondsearch/general_settings/inhousetextyes"))
			$inHouseIfYes = Mage::getStoreConfig("diamondsearch/general_settings/inhousetextyes");
			
		$inHouseOwner = Mage::getStoreConfig("diamondsearch/general_settings/inhouse_vendor");
		$diamondsCollection->getSelect()->columns('if(owner="'.$inHouseOwner.'","'.$inHouseIfYes.'","'.$inHouseIfNo.'") as inhouse');
		
		$configOrder=Mage::getStoreConfig("diamondsearch/general_settings/deafault_filter_by");
		$orderby = $configOrder;		 
		//$orderby = "totalprice";

		if($post["sort"]) 
		{
			$orderby = $post["sort"];
			if($post["sort"] == "color" && $post["is_fancy"] == 1)
				$orderby = "fancycolor";
			if($post["sort"] == "shape" && $post["is_specialshape"] == 1)
				$orderby = "spacialshape"; //specialshape
		}
		
		$orderMethod = "ASC";
		if($post["order"])
		{
			$orderMethod = $post["order"];
		}
		
		//$diamondsCollection->setOrder($orderby, $orderMethod);
		$diamondsCollection->getSelect()->order($orderby." ".$orderMethod);
		
		//$coll1 = clone $diamondsCollection;
		$total_count = $diamondsCollection->getSize();

		//have to add HAVING clause at LAST
		if(isset($post["is_inhouse"]) && $post["is_inhouse"]==1){
			$diamondsCollection->getSelect()->having("inhouse = 'Yes'");
			$total_count = count($diamondsCollection);
		}

		$diamondsCollection->getSelect()->limit($post["limit"], (int)$post["offset"]);
		//$diamondsCollection->getSelect()->limit(20, 0);
		//$stones = $diamondsCollection->getData();
		//echo $selQuery = $diamondsCollection->getSelect()." CNT: ".count($stones);
		//echo $diamondsCollection->getSelect();
		//echo "CNT: ".count($stones);
		//echo "<pre>";
		//print_r($stones);
		//exit;
		
			
		$stones = $diamondsCollection->getData();
		//echo "<pre>";
		//print_r($stones);
		$diamonds = Mage::helper("diamondsearch")->getDiamondsArray($stones, $post["is_fancy"], $post["is_specialshape"]);
		$result = array("total"=>$total_count);
		$result["curr_page"] = ($post["offset"]/$post["limit"])+1;
		$result["total_pages"] = ceil($total_count/$post["limit"]);
		$result["rows"] = $diamonds;
		echo json_encode($result);
		exit;
	}
	public function sort_array_of_array(&$array, $subfield, $dir="asc")
	{
		$sortarray = array();
		foreach ($array as $key => $row)
		{
			$sortarray[$key] = $row[$subfield];
		}
		if($dir=="asc")
			array_multisort($sortarray, SORT_ASC, $array);
		else
			array_multisort($sortarray, SORT_DESC, $array);
	}
	 
	public function listrecentAction()
	{
		$post = $this->getRequest()->getParams();
		
		$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();
		$diamonds_id = Mage::getSingleton('core/session')->getRecentlyViewed();

		$diamondsCollection->addFieldToFilter('id', array('in' => $diamonds_id));
		
		$inHouseIfNo = Mage::getStoreConfig("diamondsearch/general_settings/inhouse_text_ifno");
		$inHouseOwner = Mage::getStoreConfig("diamondsearch/general_settings/inhouse_vendor");
		$diamondsCollection->getSelect()->columns('if(owner="'.$inHouseOwner.'","Yes","'.$inHouseIfNo.'") as inhouse');

		$configOrder=Mage::getStoreConfig("diamondsearch/general_settings/deafault_filter_by");
		$orderby = $configOrder;		 

		if($post["sort"]) 
		{
			$orderby = $post["sort"];
			if($post["sort"] == "color" && $post["is_fancy"] == 1)
				$orderby = "fancycolor";
			if($post["sort"] == "shape" && $post["is_specialshape"] == 1)
				$orderby = "spacialshape";
		}
		$orderMethod = "ASC";
		if($post["order"])
		{
			$orderMethod = $post["order"];
		}
		$diamondsCollection->getSelect()->order($orderby." ".$orderMethod);
		$diamondsCollection->getSelect()->limit(20, (int)$post["offset"]);
		$total_count = $diamondsCollection->getSize();

		//$diamondsCollection->getSelect()->limit($post["limit"], (int)$post["offset"]);
		
		$stones = $diamondsCollection->getData();
		$diamonds = Mage::helper("diamondsearch")->getDiamondsArray($stones, $post["is_fancy"], $post["is_specialshape"]);
		$total_count = count($diamonds);
		$list = array(
			"total" => $total_count,
			"diamonds_id" => $diamonds_id,
			"rows" => $diamonds,
		);
		
		echo json_encode($list);
	}
    public function listrequestAction()
    {
    	$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();
    
    	$diamonds_id = array();
    
    	if(isset($_REQUEST["request_diamonds"]))
    	{
    		$diamonds_id = explode("-", $_REQUEST["request_diamonds"]);
    		$diamondsCollection->addFieldToFilter('id', array('in' => $diamonds_id));
    	}
    
    	$stones = $diamondsCollection->getData();
    	$diamonds = Mage::helper("diamondsearch")->getDiamondsArray($stones, $_REQUEST["is_fancy"], $_REQUEST["is_specialshape"]);
    
    	array_map("intval", $diamonds);
    	//$total_count = (count($diamonds) > 20) ? 20 : count($diamonds);
    	$total_count = count($diamonds);
    	$list = array(
    			"total_count" => $total_count,
    			"diamonds_id" =>  array_map("intval", $diamonds_id),
    			"diamonds" => $diamonds,
    	);
    
    	echo json_encode($list);
    }
    public function listcompareAction()
    {
		$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();
		$diamonds_id = array();

		$compare_params = array();
		if(isset($_COOKIE["compare_params"])) {
			$diamonds_id = explode(",",$_COOKIE["compare_params"]);
		} 
		$diamondsCollection->addFieldToFilter('id', array('in' => $diamonds_id));
		
		$stones = $diamondsCollection->getData();
		$diamonds = Mage::helper("diamondsearch")->getDiamondsArray($stones, $_REQUEST["is_fancy"], $_REQUEST["is_specialshape"]);
		
		array_map("intval", $diamonds);
		//$total_count = (count($diamonds) > 20) ? 20 : count($diamonds);
		$total_count = count($diamonds);
		$list = array(
			"total" => $total_count,
			"rows" => $diamonds,
		);
		
		echo json_encode($list);
    }

    public function sortrcAction()
    {
		$post = $this->getRequest()->getPost();
		
		$orderby = $post["sort"];
		if($_REQUEST["sort"])
		{
			$orderby = $_REQUEST["sort"];
			if($_REQUEST["sort"] == "price")
				$orderby = "totalprice";
			else if($_REQUEST["sort"] == "report")
				$orderby = "certificate";
			else if($_REQUEST["sort"] == "inhouse")
				$orderby = "INHOUSE";
			else if($_REQUEST["sort"] == "l:w")
				$orderby = "dimensions";
			else if($_REQUEST["sort"] == "color" && $_REQUEST["is_fancy"] == 1)
				$orderby = "fancycolor";
			else if($_REQUEST["sort"] == "shape" && $_REQUEST["is_specialshape"] == 1)
				$orderby = "spacialshape";
		}
		
		/*if($post["sort"] == "price")
			$orderby = "totalprice";
		else if($post["sort"] == "report")
			$orderby = "certificate";*/

		//print_r($post);
		if($post["table_name"] == "search_recently_header_table")
		{
			$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();
			$diamonds_id = Mage::getSingleton('core/session')->getRecentlyViewed();
			$diamondsCollection->addFieldToFilter('id', array('in' => $diamonds_id));
			
			if($orderby != "INHOUSE")
				$diamondsCollection->setOrder($orderby, $post["order"]);

			//echo $diamondsCollection->getSelect();
			$stones = $diamondsCollection->getData();
			$diamonds = Mage::helper("diamondsearch")->getDiamondsArray($stones, $_REQUEST["is_fancy"], $_REQUEST["is_specialshape"]);
			if($orderby == "INHOUSE")
				$this->sort_array_of_array($diamonds, 'InHouse', strtolower($post["order"]));
				
			$list = array(
				"total_count" => count($diamonds),
				"diamonds_id" => $diamonds_id,
				"diamonds" => $diamonds,
			);
			
			echo json_encode($list);
		}
		else if($post["table_name"] == "search_comparison_header_table")
		{
			$diamondsCollection = Mage::getModel("diamondsearch/diamondsearch")->getCollection();
			$diamonds_id = array();
			//echo "FFF: <pre>";print_r($post["comparison_diamonds"]);

			if($post["comparison_diamonds"])
			{
				//$diamonds_id = explode("-", $post["comparison_diamonds"]);
				$diamonds_id = $post["comparison_diamonds"];
				$diamondsCollection->addFieldToFilter('id', array('in' => $diamonds_id));
			
			}
			//echo " IN ";print_r($diamonds_id);
			if($orderby != "INHOUSE")
				$diamondsCollection->setOrder($orderby, $post["order"]);
			
			$stones = $diamondsCollection->getData();
			$diamonds = Mage::helper("diamondsearch")->getDiamondsArray($stones, $_REQUEST["is_fancy"], $_REQUEST["is_specialshape"]);
			if($orderby == "INHOUSE")
				$this->sort_array_of_array($diamonds, 'InHouse', strtolower($post["order"]));

			array_map("intval", $diamonds);
			$list = array(
				"total_count" => count($diamonds),
				"diamonds_id" =>  array_map("intval", $diamonds_id),
				"diamonds" => $diamonds,
			);

			echo json_encode($list);
		}
	}
    
}
