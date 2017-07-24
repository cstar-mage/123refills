<?php
class TF_Autocomplete_ResultController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
	{
		$limit = Mage::getStoreConfig('catalog/autocomplete/limit');
		$show_manufacturer = Mage::getStoreConfig('catalog/autocomplete/manufacturer');
		$show_price = Mage::getStoreConfig('catalog/autocomplete/price');
		
        $query = Mage::helper('catalogSearch')->getQuery();
        $query->setStoreId(Mage::app()->getStore()->getId());
        if ($query->getQueryText()) {
            $query->prepare();
			
			$collection = Mage::getSingleton('catalogsearch/layer')->getProductCollection()->addAttributeToSelect('manufacturer');
			if($limit>0){
				$collection->getSelect()->limit($limit);
			}
			foreach($collection as $p){
				# drop down list html
				echo '<div class="ac_product_row">';
				echo '<img src="'.Mage::helper('catalog/image')->init($p, 'small_image')->resize(50, 50).'" width="50" height="50" class="ac_product_image"/>';
				echo '<div class="ac_product_title">'.$p->getName().'</div>';
				if($show_manufacturer){
					echo '<div class="ac_product_manufacturer">'.$p->getAttributeText('manufacturer').'</div>';
				}
				if($show_price){
					$price = Mage::helper('core')->currency($p->getPrice());
					echo '<div class="ac_product_price">'.$price.'</div>';
				}
				echo '</div>';
				
				# display the product name when selected
				echo '|'.$p->getName();
				
				# product url to redirct to
				echo "|".$p->getProductUrl();
				echo "\n ";
			}
        }
        else {
            $this->_redirectReferer();
        }
    }
}