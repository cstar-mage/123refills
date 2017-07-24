<?php
class Mage_Eternity_IndexController extends Mage_Core_Controller_Front_Action
{	

  const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'contacts/email/email_template';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';

    public function indexAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	public function postAction()
	{
		$data = $this->getRequest()->getPost();
		//echo "<pre>";print_r($data);exit;
		$c_url = $data['current_url'];
		if ($data) {
			
			$translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
			
			try {
                $postObject = new Varien_Object();
                $postObject->setData($data);
                $error = false;

                if (!Zend_Validate::is(trim($_POST['name']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($_POST['email']), 'EmailAddress')) {
                    $error = true;
                }
                
                if ($error) {
					throw new Exception();
                }

				/*$model = Mage::getSingleton('seeitperson/seeitperson')->setData($data);
                if(!$model->save()){
                	throw new Exception();
                }*/
                
                $mailTemplate = Mage::getModel('core/email_template');
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($_POST['email'])
					->sendTransactional(
							Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
							$_POST['email'],
						   Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
							$data['name'],
							array('data' => $postObject)
                    );
					
                
                if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }

                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('eternity')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                $this->_redirectUrl($c_url);

                return;
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('eternity')->__('Unable to submit your request. Please, try again later'));
                $this->_redirectUrl($c_url);
                return;
            }
        }else { Mage::getSingleton('customer/session')->addError(Mage::helper('eternity')->__('Please, try again later'));
            $this->_redirectUrl($c_url);
        }
    }
	public function addtocartAction()
    {		
		
		
		
		
		
		
    	$description = "This Product With ".$_REQUEST['shapevalue']." - ".$_REQUEST['caratvalue']." - ".$_REQUEST['qualityvalue']." - ".$_REQUEST['metalvalue']." - ".$_REQUEST['sizestyle']." - ".$_REQUEST['sizes'];
		$itemNum = $_REQUEST['shapevalue'].substr($_REQUEST['caratvalue'],2,2).substr($_REQUEST['qualityvalue'],0,1).substr($_REQUEST['metalvalue'],0,3).$_REQUEST['sizes'];		
		$title = "Eternity product - ".$_REQUEST['shapevalue']." - ".$_REQUEST['caratvalue']." - ".$_REQUEST['qualityvalue'];
		$price = $_REQUEST['eternity_price'];
		
		$shapevalue = attributeval(Mage::getModel('eav/entity_attribute')->load(setattributeid('eternity_shape')),$_REQUEST['shapevalue']);
		$caratvalue = attributeval(Mage::getModel('eav/entity_attribute')->load(setattributeid('eternity_carat')),$_REQUEST['caratvalue']);
		$qualityvalue = attributeval(Mage::getModel('eav/entity_attribute')->load(setattributeid('eternity_quality')),$_REQUEST['qualityvalue']);
		$metalvalue = attributeval(Mage::getModel('eav/entity_attribute')->load(setattributeid('eternity_metal')),$_REQUEST['metalvalue']);
		$stylevalue= attributeval(Mage::getModel('eav/entity_attribute')->load(setattributeid('eternity_setting_style')),$_REQUEST['sizestyle']);
		$sizes = attributeval(Mage::getModel('eav/entity_attribute')->load(setattributeid('eternity_ringsize')),$_REQUEST['sizes']);
		
		$storeId = Mage::app()->getStore()->getId();
		//$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $itemNum);
		
	
		
		
		//if (! $_product->getId()) {		
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
		$product->setData('eternity_carat',$caratvalue);
		$product->setData('eternity_ringsize',$sizes);
		$product->setData('eternity_metal',$metalvalue);
		$product->setData('eternity_quality',$qualityvalue);
		$product->setData('eternity_shape',$shapevalue);
		$product->setData('eternity_setting_style',$stylevalue);
		
		//$gallery_img = '/shape/'.strtolower($title).'.jpg';
		
		//$product->addImageToMediaGallery(Mage::getBaseDir('media') . DS . 'import' . $gallery_img, array('small_image','thumbnail','image'), false,true);
		
		$product->save(); 
		//exit;
	
		$stockItem = Mage::getModel('cataloginventory/stock_item');
		$stockItem->loadByProduct($product->getId());
		
		if (! $stockItem->getId()) {
			$stockItem->setProductId($product->getId())->setStockId(1);
		}
		
		$stockItem->setData('is_in_stock',1);
		$stockItem->save();

		$stockItem->loadByProduct($product->getId());				
		$stockItem->setData('qty', 1);
		$stockItem->save();
		
		$id = $product->getId();
			
//		Mage::getSingleton("catalog/session")->addSuccess($e->getMessage());
    	if($_REQUEST['process'] == "whishlist")
    	{
			
    		$this->_redirect("wishlist/index/add/", array('product'=>$id));
    		return;
    	}  
   		else
	    {
	    	$my_product = Mage::getModel('catalog/product')->load($id);
	    	$cart = Mage::getModel('checkout/cart');
	    	$cart->init();
	    	$cart->addProduct($my_product,$params);
	    	$cart->save();
	    	$this->_redirect("checkout/cart/");
	    	return;
	    }
	
	}
	
	public function priceupdateAction()
	{
		$price = 0;
		if($_REQUEST['shape'] == "")
		{
			$shape = "Round";
		}
		else
		{
			$shape = $_REQUEST['shape'];
		}
		
		if($_REQUEST['carat'] == "")
		{
			$carat = "0.05ct";
		}
		else
		{
			$carat = $_REQUEST['carat'];
		}
		
		if($_REQUEST['quality'] == "")
		{
			$quality = "F VS2";
		}
		else
		{
			$quality = $_REQUEST['quality'];
		}
		if($_REQUEST['ring_size'] == "")
		{
			$ring_size = 3.5;
		}
		else
		{
			$ring_size = $_REQUEST['ring_size'];
		}
		
		if($_REQUEST['metal_type'] == "")
		{
			$metal_type = "14k_gold";
		}
		else
		{
			$metal_type = $_REQUEST['metal_type'];
		}
		
		$dia_collection = Mage::getModel('eternity/diaprice')->getCollection()
		->addFieldToFilter('shape',$shape)
		->addFieldToFilter('carat',$carat);		
		$dia_data = $dia_collection->getData();
		
		if($quality == "F VS2")
		{
			$carat1 = floatval($carat);
			$price = $carat1 * $dia_data[0]['fvs2price'];
		}
		elseif($quality == "JKIND")
		{
			$carat1 = floatval($carat);
			$price = $carat1 * $dia_data[0]['jkind'];
		}
		else
		{
			$carat1 = floatval($carat);
			$price = $carat1 * $dia_data[0]['gs11price'];
		}
		
		switch ($carat) {
			case "0.05ct":
				$carat2 = "0_5ct";
				break;
			case "0.10ct":
				$carat2 = "0_10ct";
				break;
			case "0.15ct":
				$carat2 = "0_15ct";
				break;
			case "0.20ct":
				$carat2 = "0_20ct";
				break;
			case "0.25ct":
				$carat2 = "0_25ct";
				break;
			case "0.33ct":
				$carat2 = "0_33ct";
				break;
			case "0.40ct":
				$carat2 = "0_40ct";
				break;
			case "0.50ct":
				$carat2 = "0_50ct";
				break;
		}
		
		switch ($carat) {
			case "0.05ct":
				$caratweight = 0.05;
				break;
			case "0.10ct":
				$caratweight = 0.10;
				break;
			case "0.15ct":
				$caratweight = 0.15;
				break;
			case "0.20ct":
				$caratweight = 0.20;
				break;
			case "0.25ct":
				$caratweight = 0.25;
				break;
			case "0.33ct":
				$caratweight = 0.33;
				break;
			case "0.40ct":
				$caratweight = 0.40;
				break;
			case "0.50ct":
				$caratweight = 0.50;
				break;
		}
		
		
		$stoneqty_collection = Mage::getModel('eternity/stoneqty')->getCollection()
		->addFieldToFilter('shape',$shape)
		->addFieldToFilter('ring_size',$ring_size);		
		
		$stone_result = $stoneqty_collection->getData();
		
		$ringcosteqty_collection = Mage::getModel('eternity/ringcost')->getCollection()
		->addFieldToFilter('size',$ring_size);
		$metal_result = $ringcosteqty_collection->getData();
		
		if($stone_result[0][$carat2] > 0)
		{
			$price = ($price * $stone_result[0][$carat2]) + $metal_result[0][$metal_type];
			$noofstone = $stone_result[0][$carat2];
		}
		else
		{
			$price = $price + $metal_result[0][$metal_type];
			$noofstone = 0;
		
		}
		
		$rule_collection = Mage::getModel('eternity/appliedrule')->getCollection()
		->addFieldToFilter('price_from', array('lteq' => $price))
		->addFieldToFilter('price_to', array('gteq' => $price));
		
		$percenatge_result = $rule_collection->getData();
		
		$percentageprice = ($price * $percenatge_result[0]['price_increase']) / 100;
		$price = $price + $percentageprice;
		$price = roundToNearest($price,50);
		$caratval = $caratweight * $noofstone;
		echo $price."|".$noofstone."|".$caratval;
		
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

function setattributeid($code){
	$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', $code);
	return $attributeId;
}

function roundToNearest($number,$nearest=50)
{
	$number = round($number);

	if($nearest>$number || $nearest <= 0)
		return $number;

	$x = ($number%$nearest);

	return ($x<($nearest/2))?$number-$x:$number+($nearest-$x);
}

