<?php
class Ideal_Diamondsearch_ImageController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		try{
	    	$shp = $this->getRequest()->getParam("shp");
	    	$dim = $this->getRequest()->getParam("dim");
	    	
	    	$findme   = '-';
	    	$dash_dim = strpos($dim, $findme);
	    	
	    	if ($dash_dim == true)
	    	{
	    		$dim_h_w_d = explode("x", $dim);
	    	
	    		$dim_h_w = trim($dim_h_w_d[0]);
	    		$depth = trim($dim_h_w_d[1]);
	    	
	    		$remove_dash = explode("-", $dim_h_w);
	    	
	    		$height = trim($remove_dash[0]);
	    		$width = trim($remove_dash[1]);
	    	}
	    	else
	    	{
	    		$dim_h_w_d = explode("x", $dim);
	    	
	    		$height=trim($dim_h_w_d[0]);
	    		$width=trim($dim_h_w_d[1]);
	    		$depth = trim($dim_h_w_d[2]);
	    	}
	    	
	    	//header('Content-Type: png');
	    	$this->getResponse()->setHeader('Content-type', 'png');
	    	$string1=$width;
			$string2=$height;
	    	//$surl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/base/default/dsearch/shapes/".strtolower($shp)."_out.jpg";
			$surl = Mage::getBaseDir()."/skin/frontend/base/default/dsearch/shapes/".strtolower($shp)."_out.jpg";
	    	echo $this->writeover($surl,$string1,$string2);
		}
		catch (Exception $ex){ return false;}
	    exit;
    }
    

    function writeover($img,$txt1,$txt2)
    {
    	$txt1=$txt1."mm";
    	$txt2=$txt2."mm";
    	// Path to our ttf font file

    	$font_file = Mage::getBaseDir()."/skin/frontend/base/default/dsearch/css/fonts/Arialnb.ttf";
    	$im_base = imagecreatefromjpeg($img);
    
    	//initialize black sqare to write into
    	$im1 = imagecreate(52, 25);
    	$background_color = imagecolorallocate($im1, 255, 255, 255);
    	$text_color = imagecolorallocate($im1, 0, 0, 0);
    
    	//another method to write text
    	//imagestring($im2, 5, 5, 5,  "width:", $text_color);
    
    	// Draw the text using font size 10
    	imagefttext($im1, 10, 0, 2, 10, $text_color,$font_file, 'width:');
    	imagefttext($im1, 10, 0, 2, 23, $text_color,$font_file, $txt1);
    
    	//initialize black square to write into
    	$im2 = imagecreate(52, 25);
    	$background_color = imagecolorallocate($im2, 255, 255, 255);
    	$text_color = imagecolorallocate($im2, 0, 0, 0);
    
    	// Draw the text using font size 10
    	imagefttext($im2, 10, 0, 2, 10, $text_color,$font_file, 'length:');
    	imagefttext($im2, 10, 0, 2, 23, $text_color,$font_file, $txt2);
    
    	//copy each square over the baseimage
    	imagecopy($im_base,$im1, 95,115, 0, 0, 52, 25);
    	imagecopy($im_base,$im2, 130,75, 0, 0, 52, 25);
    
    	//destroy image handlers
    	imagepng($im_base);
    	imagedestroy($im_base);
    	imagedestroy($im1);
    	imagedestroy($im2);
    
    	return $im_base;
    }
    
    
}