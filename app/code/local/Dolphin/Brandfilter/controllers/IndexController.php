<?php
class Dolphin_Brandfilter_IndexController extends Mage_Core_Controller_Front_Action 
{    
	public function IndexAction() {      
		//$this->loadLayout();		
		$data = $this->getRequest()->getPost();	
		$att_id =  $data['id'];
		$cat_id =  $data['cat_id'];
		//$this->renderLayout();		
		
		$category = Mage::getModel('catalog/category')->load($cat_id);
		
		
		$products = Mage::getModel('catalog/product')
					->getCollection()
					->addAttributeToSelect('*')
					->addAttributeToFilter('printer_series', array('finset' => $att_id ))
					->addAttributeToFilter('type_id', array('eq' => 'grouped'))
					->addCategoryFilter($category)
					->addAttributeToSort('name', 'asc');
					
		
		
		$count = 0 ;
		if(!$products->count()): 
			 echo 'There are no products matching the selection.';
		else: 
			$procount = count($products);
			
			foreach ($products as $product) :
			$count++; /*
				 if ($count > 0 && $count % 1 === 0): ?>
					</ul><ul>
				<?php endif ;*/
				//echo "<pre>"; print_r($product ); echo "</pre>";		
                $printerModel = Mage::helper('brandfilter')->getProductAttributeValue($product, 'printer_model');
				echo "<li><div><a href='".$product->getProductUrl()."'>".$printerModel."</a></div></li>";
				
			endforeach;
			
		endif;
    }
}
