<?php
class Ideal_Stud_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
    public function addtocartAction()
    {


    	 
    	if($_REQUEST['sizestyle'] == "4-Prong Basket"){
    		$sstyle = "4BP";
    	}else if($_REQUEST['sizestyle'] == "3-Prong Martini"){
    		$sstyle = "3PM";
    	}else if($_REQUEST['sizestyle'] == "4-Prong Crown"){
    		$sstyle = "4PC";
    	}else if($_REQUEST['sizestyle'] == "Bezel"){
    		$sstyle = "Bez";
    	}else if($_REQUEST['sizestyle'] == "Lever Back"){
    		$sstyle = "LVB";
    	}else if($_REQUEST['sizestyle'] == "Halo"){
    		$sstyle = "Halo";
    	}else{
    		$sstyle = "";
    	}
    
    	if($_REQUEST['size-s'] == "Push-Back"){
    		$ssize = "PB";
    	}else if($_REQUEST['size-s'] == "Screw Back"){
    		$ssize = "SB";
    	}else{
    		$ssize = "";
    	}
    	 
    	if($_REQUEST['cutvalue'] == "Very Good Cut"){
    		$cutval = "VGT";
    	}else if($_REQUEST['cutvalue'] == "Ideal-Excellent Cut"){
    		$cutval = "IEC";
    	}else{
    		$cutval = "";
    	}
    	 
    	$description = "This is Description of Stud";    	
    	$itemNum = $_REQUEST['shapevalue'].substr($_REQUEST['caratvalue'],2,2).$_REQUEST['colorvalue'].$_REQUEST['clarityvalue'].$cutval.$_REQUEST['metalstyle'].$sstyle.$ssize;
    
    	if($_REQUEST['metalstyle'] == "14k_white_gold"){
    		$_REQUEST['metalstyle'] = "14k White Gold";
    	}else if($_REQUEST['metalstyle'] == "14k_yellow_gold"){
    		$_REQUEST['metalstyle'] = "14k Yellow Gold";
    	}else if($_REQUEST['metalstyle'] == "14k_rose_gold"){
    		$_REQUEST['metalstyle'] = "14k Rose Gold";
    	}else if($_REQUEST['metalstyle'] == "18k_white_gold"){
    		$_REQUEST['metalstyle'] = "18k White Gold";
    	}else if($_REQUEST['metalstyle'] == "18k_yellow_gold"){
    		$_REQUEST['metalstyle'] = "18k yellow gold";
    	} 
    	
    	$title = $_REQUEST['shapevalue'] . " - Stud product - carat -".$_REQUEST['caratvalue']."-". $_REQUEST['metalstyle']."-".$_REQUEST['colorvalue']."-".$_REQUEST['clarityvalue']."-".$_REQUEST['cutvalue']. " With Setting style -". $_REQUEST['sizestyle'] . "And Back Type -".$_REQUEST['size-s'];

    	$price = $_REQUEST['eternity_price'];
    	$shapevalue = $this->attributeval(Mage::getModel('eav/entity_attribute')->load($this->setattributeid('stud_shape')),$_REQUEST['shapevalue']);
    	$caratvalue = $this->attributeval(Mage::getModel('eav/entity_attribute')->load($this->setattributeid('stud_carat')),$_REQUEST['caratvalue']);    	
    	$metalvalue = $this->attributeval(Mage::getModel('eav/entity_attribute')->load($this->setattributeid('stud_metal')),$_REQUEST['metalstyle']);
    	$setting_type = $this->attributeval(Mage::getModel('eav/entity_attribute')->load($this->setattributeid('stud_setting_style')),$_REQUEST['sizestyle']);
    	$backing_type = $this->attributeval(Mage::getModel('eav/entity_attribute')->load($this->setattributeid('stud_backing_type')),$_REQUEST['size-s']);    	 
    	$colorvalue = $this->attributeval(Mage::getModel('eav/entity_attribute')->load($this->setattributeid('stud_color')),$_REQUEST['colorvalue']);
    	$clarityvalue = $this->attributeval(Mage::getModel('eav/entity_attribute')->load($this->setattributeid('stud_clarity')),$_REQUEST['clarityvalue']);
    	$cutvalue = $this->attributeval(Mage::getModel('eav/entity_attribute')->load($this->setattributeid('stud_cut')),$_REQUEST['cutvalue']);    	 
    		
    		
    	$storeId = Mage::app()->getStore()->getId();    	
    	$product_id = Mage::getModel("catalog/product")->getIdBySku($itemNum);
    	
    	
    	if (!$product_id) {
    		$product = Mage::getModel('catalog/product');
    		$product->setTypeId('simple');  //
    		$product->setTaxClassId(0); //none
    		$product->setWebsiteIds(array(1));  // store id
    		$product->setAttributeSetId(4); //Videos Attribute Set Id
    		
    		$product->setSku($itemNum);
    		$product->setName($title);
    		$product->setDescription($description);
    		$product->setPrice($price);
    		$product->setShortDescription(ereg_replace("\n","",$description));
    		$product->setWeight(0);
    		$product->setStatus(1); //enabled
    		$product->setVisibilty(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH); //catalog and search
    		$product->setMetaDescription(ereg_replace("\n","",$description));
    		$product->setMetaTitle($title);
    		$product->setData('stud_carat',$caratvalue);    		
    		$product->setData('stud_metal',$metalvalue);    		
    		$product->setData('stud_shape',$shapevalue);
    		$product->setData('stud_clarity',$clarityvalue);
    		$product->setData('stud_cut',$cutvalue);
    		$product->setData('stud_color',$colorvalue);
    		$product->setData('stud_setting_style',$setting_type);
    		$product->setData('stud_backing_type',$backing_type);
    
    		$gallery_img = '/studshape/'.$_REQUEST['shapevalue'].'.jpg';
    		$product->addImageToMediaGallery('media/import/'.$gallery_img, array('small_image','thumbnail','image'), false,true);
    									 
    		$product->save();
    
    	}
    	
    	$product_id = Mage::getModel("catalog/product")->getIdBySku($itemNum);
    	
    	  $stockItem = Mage::getModel('cataloginventory/stock_item');
    	  $stockItem->loadByProduct($product_id);
       	if(! $stockItem->getId()){
        	$stockItem->setProductId($product_id)->setStockId(1);
        }
            
   		$stockItem->setData('is_in_stock',1);
    	$stockItem->save();    
    	$stockItem->loadByProduct($product_id);
    	$stockItem->setData('qty', 10);
    	$stockItem->save();
    
    	
    	$product = Mage::getModel('catalog/product')->load($product_id);
    	$params = array(
    		'product' => $product_id,
    		'qty' => 1);
    
    	if($_REQUEST['process'] == "whishlist")
    	{
    		$this->_redirect("wishlist/index/add/", array('product'=>$product_id));
    		return;
    	}  
    	else
	    {
	    	$my_product = Mage::getModel('catalog/product')->load($product_id);
	    	$cart = Mage::getModel('checkout/cart');
	    	$cart->init();
	    	$cart->addProduct($my_product,$params);
	    	$cart->save();
	    	$this->_redirect("checkout/cart/");
	    	return;
	    }
	    			 
	}
   
	
	
	function attributeval($attribute,$requestval)
	{
		foreach($attribute->getSource()->getAllOptions(true,true) as $option){
			if($option['label'] == $requestval)
			{
				$attrvalue = $option['value'];
			}
		}
	
		return $attrvalue;
	}
	
	function getOption($optionname,$optionval,$sku)
	{
		return array(
				array(
						'title' => $optionname,
						'price' =>0,
						'price_type' => 'fixed',
						'sku' => $optionval."-".$sku,
						'sort_order' => '0'
				)
		);
	}
	
	public function setattributeid($code){
		$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', $code);
		return $attributeId;
	}
	
	public function priceupdateAction(){
		
		$price = 0;
		$data = $this->getRequest()->getParams();
		//echo "<pre>";
	//	print_r($data);
	//	echo "</pre>";
		//exit;
		if($data['shape'] == "")
		{
			$shape = "";
		}
		else
		{
			$shape = $data['shape'];
		}
		if($data['carat'] == "")
		{
			$carat = "";
		}
		else
		{
			$carat = $data['carat'];
		}		
		
		if($data['metal_type'] == "")
		{
			$metal_type = "";
		}
		else
		{
			$metal_type = $data['metal_type'];
		}
		
		if($data['cut'] == "")
		{
			$cut = "";
		}
		else
		{
			$cut = $data['cut'];
		}
		
		if($data['clarity'] != "" && $data['color'] != "")
		{
			$type = $data['color']."-".$data['clarity'];
			//echo $type;
            //exit;			
		}
		else
		{
			$type = "";
		}
		
		if($data['shape'] != "" && $data['carat'] != "" && $data['clarity'] != "" &&  $data['color'] != "")
		{
			$collection = Mage::getModel('stud/stud')->getCollection()
			->addFieldToFilter('shape',$shape)
			->addFieldToFilter('carat',$carat);
			
			$collectiondata = $collection->getData();

			//echo $type;            
			/* echo "<pre>";
			print_r($collectiondata);
			echo "</pre>";   */



			$collcount =  count($collectiondata);
			$price = "";
			for($i=0;$i<=$collcount;$i++){
			
				//echo $type."--------------------------".$collectiondata[$i]['dbfield']."<br>";

				if($type == $collectiondata[$i]['dbfield']){
				
					$price = $collectiondata[$i]['price'];
					$mainprice = $collectiondata[$i]['price'];

					
					
				}
				
			}
			
		}		

		if($cut != "" && $price != "" && $cut == 'Ideal-Excellent Cut'){

			if($mainprice == ""){
				$mainprice = 0;
			}



			if($price == ""){
					$price = 0;
			}		
			$addprice = ($price*8)/100;
			$price = $price + $addprice;			
			echo $price."|"."otherprice"."|".$mainprice;
		}
		else if($data['shape'] != "" && $data['carat'] != "" && $data['clarity'] != "" &&  $data['color'] != "" && $data['metal_type'] != "")
		{	

			//echo "---".$data['metal_type']."---";
		
			$metal_price =  Mage::getStoreConfig('stud/general_settings/'."d".$data['metal_type']);
			
		//	echo $metal_price;
			if($mainprice == ""){
				$mainprice = 0;
			}
					
			$price = $price + $metal_price;	
			echo $price."|"."metalprice"."|".$mainprice;

			
		}
		else{
		//print_r($data);
			if($mainprice == ""){
				$mainprice = 0;
			}

			echo $price."|"."baseprice"."|".$mainprice;		
			
		
		//exit;
		}
	}
	 
	
}