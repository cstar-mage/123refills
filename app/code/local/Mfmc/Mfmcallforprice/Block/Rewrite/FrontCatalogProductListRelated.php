<?php

class Mfmc_mfmcallforprice_Block_Rewrite_FrontCatalogProductListRelated extends Mage_Catalog_Block_Product_List_Related
{
    // mfmc rewrite getPriceHtml for displaying 'call for price' string
    public function getPriceHtml($product, $displayMinimalPrice = false, $idSuffix='')
    {
        $_product = Mage::getModel('catalog/product')->load($product->getId());
        /*if($html = $_product->getData('mfm_cfp'))
		{
			
			$product->setIsSalable(0);
            return $html;
        }*/
        if(($html = $_product->getData('mfm_cfp')) || ($_product->getFinalPrice() == 0) || ($_product->getFinalPrice() == null) || ($_product->getFinalPrice() == ""))
        {
        	if(!$_product->getData('mfm_cfp'))
        	{
        		$callforprice = "call for price";
        	}
        	else
        	{
        		$callforprice = $_product->getData('mfm_cfp');
        	}
        	$product->setIsSalable(0);
        	$html = '<div class="out-of-stock">' .  $callforprice . '</div>';
        	return $html;
        }
        
        return $this->_getPriceBlock($product->getTypeId())
            ->setTemplate($this->_getPriceBlockTemplate($product->getTypeId()))
            ->setProduct($product)
            ->setDisplayMinimalPrice($displayMinimalPrice)
            ->setIdSuffix($idSuffix)
            ->toHtml();
    }

}
