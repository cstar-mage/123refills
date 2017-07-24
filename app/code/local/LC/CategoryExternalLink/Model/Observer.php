<?php

class LC_CategoryExternalLink_Model_Observer
{
    public function CategoryExternalLink($observer)
    {
        $category = $observer->getCategory();
        if( !$category || !$category->getId() ) {
            return $this;
        }
        
        if( $category->getData('lc_categoryexternallink_yes') && $category->getData('lc_categoryexternallink') ) {
            $observer->getControllerAction()->getResponse()->setRedirect($category->getData('lc_categoryexternallink'));
        }
        return $this;
    }
}