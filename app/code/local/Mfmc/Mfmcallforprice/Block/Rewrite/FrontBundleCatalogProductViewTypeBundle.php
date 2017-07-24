<?php

class Mfmc_mfmcallforprice_Block_Rewrite_FrontBundleCatalogProductViewTypeBundle extends Mage_Bundle_Block_Catalog_Product_View_Type_Bundle
{
    // mfmc rewrite getPriceHtml for displaying 'call for price' string
    public function getPriceHtml($product, $displayMinimalPrice = false, $idSuffix='')
    {
		$_product = Mage::getModel('catalog/product')->load($product->getId());
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
