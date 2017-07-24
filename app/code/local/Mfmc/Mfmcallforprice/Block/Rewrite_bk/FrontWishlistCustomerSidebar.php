<?php

class Mfmc_mfmcallforprice_Block_Rewrite_FrontWishlistCustomerSidebar extends Mage_Wishlist_Block_Customer_Sidebar
{
    // mfmc rewrite getPriceHtml for displaying 'call for price' string
    public function getPriceHtml($product, $displayMinimalPrice = false, $idSuffix='')
    {
        $_product = Mage::getModel('catalog/product')->load($product->getId());
        if($html = $_product->getData('mfm_cfp'))
		{
			
			$product->setIsSalable(0);
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
