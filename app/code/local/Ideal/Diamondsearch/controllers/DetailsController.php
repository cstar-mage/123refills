<?php
class Ideal_Diamondsearch_DetailsController extends Mage_Core_Controller_Front_Action
{
    public function viewAction()
    {
		Mage::helper("diamondsearch")->setAsRecentlyViewed($this->getRequest()->getParam("id"));
    	$this->loadLayout();
    	$this->renderLayout();
    }
	public function indexAction()
    {
    	$this->loadLayout();
    	
    	$block = $this->getLayout()->getBlock('diamondsearch');
    	if ($block){//check if block actually exists
    		if(Mage::helper("diamondsearch")->isMobile()){
    			$block->setTemplate("diamondsearch/diamondsearch-mobile.phtml");
    		}
    		else {
    			$block->setTemplate(Mage::helper("diamondsearch")->getTemplatePath());
    		}
    	}
		$this->renderLayout();
    }
    public function certAction()
    {
    	$this->loadLayout(false);
    	
    	$diamond = Mage::getModel("diamondsearch/diamondsearch")->load($this->getRequest()->getParam('id'))->getData();
    	$certificate_image = $diamond['image'];
    	$certificate=$diamond['certificate'];
    	$is_cert_shown = false;
    	
    	
    	
    	if($certificate_image != ""):
	    	$cert_response = get_headers($certificate_image, 1); 
	    	if(strpos($cert_response[0], "404" ) != true): 
		    	$path = parse_url($certificate_image, PHP_URL_PATH);
		    	$ext = pathinfo($path, PATHINFO_EXTENSION);
		    	$is_cert_shown = true;
		    	if($ext == "pdf"){
		    		$this->getResponse()->setHeader('Content-Type','application/pdf');
		    		echo '<iframe width="100%" height="100%" frameborder="0" src="'.$certificate_image.'"></iframe>';
		    	}
		    	else{
		    		//$this->getResponse()->setHeader('Content-Type','image/'.$ext);
		    		echo "<style type='text/css'>.out{max-width:100%;cursor:zoom-in;}.in{cursor:zoom-out;}</style>";
		    		echo '<div style="text-align:center"><img src="'.$certificate_image.'" id="ctz" class="out" title="click to zoom in/zoom out" onclick="manageZoom();"/></div>';
		    		echo "<script>
function hasClass(el, className) {
  if (el.classList)
    return el.classList.contains(className);
  else
    return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'));
}

function addClass(el, className) {
  if (el.classList)
    el.classList.add(className);
  else if (!hasClass(el, className)) el.className += ' ' + className;
}

function removeClass(el, className) {
  if (el.classList)
    el.classList.remove(className);
  else if (hasClass(el, className)) {
    var reg = new RegExp('(\\s|^)' + className + '(\\s|$)');
    el.className=el.className.replace(reg, ' ');
  }
}
function manageZoom() {
	var el = document.getElementById('ctz');
	if(hasClass(el, 'out')) {
  		removeClass(el, 'out');
  		addClass(el, 'in');
	}
  	else{
  		removeClass(el, 'in');
  		addClass(el, 'out');
  	}
}
  		</script>";
		    	}
		    endif;
		    
		elseif($certificate_image == ""):
		
		$collection = unserialize(Mage::getStoreConfig("diamondsearch/slider_settings/certificate_slider"));
		foreach($collection as $item)
		{
			 
			if($certificate == $item['label'])
			{
				$diam_image=$item['image'];
			}
			 
		}

		$certimag="dsearch/".$diam_image;
		$filePath = Mage::getBaseDir("media") . DS . str_replace("/", DS, $certimag);
		// echo $filePath;
		if(is_file($filePath))
		{
			 
			echo '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."dsearch/".$diam_image.'" id="ctz" class="out" />';
		}
		else
		{
			echo "<h3>CERTIFICATE NOT AVILABLE </h3>";
		}
		    
		endif;
		
		//if(!$is_cert_shown && "GIA" == strtoupper($certificate)){echo 'GIA SAMPLE IMAGE';}
		//elseif(!$is_cert_shown) {echo "<p>No Certificate found.</p>";}
		/*
		if(!$is_cert_shown && "GIA" == strtoupper($certificate)){echo '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).Mage::getStoreConfig("diamondsearch/general_settings/certificate_sample").'" alt="Sample Certificate" />';}
		elseif(!$is_cert_shown) {echo '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).Mage::getStoreConfig("diamondsearch/general_settings/certificate_sample").'" alt="Sample Certificate" />';}
		*/
		$this->renderLayout();
    }
}