<?php 

require_once('../app/Mage.php');
umask(0);
Mage::app();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$categories = Mage::getModel('catalog/category')->getCollection()
		->addAttributeToSelect('*')//or you can just add some attributes
		->addAttributeToFilter('level', 2)//2 is actually the first level
		->addAttributeToFilter('is_active', 1);

		$catelist=array();
		foreach($categories as $category)
		{
			if($category->getId()==15 or $category->getId()==16 ){ continue; }
			//echo "   <br> " . $category->getId().'---'.$category->getName();	
			$catelist[$category->getId()]=$category->getName();
		}


		$cat = Mage::getModel('catalog/category')->load(15);
		$subcats = $cat->getChildren();

		foreach(explode(',',$subcats) as $subCatid)
		{
			$_category = Mage::getModel('catalog/category')->load($subCatid);
			if($_category->getIsActive()) 
			{
				//echo "   <br>bb " . $_category->getId().'---'.$_category->getName();	
				if($_category->getName())
				{	
					$catelist[$_category->getId()]=$_category->getName();
				}	
			}
		}
		asort($catelist);
	
		
$i=0;
foreach($catelist as $catelist_id => $catelists){
	
//	echo $catelist_id;
	$series = array();
	
	$category = Mage::getModel('catalog/category')->load($catelist_id);

	
	
		
		$products = Mage::getModel('catalog/product')
					->getCollection()
					->addAttributeToSelect('*')
					->addAttributeToFilter('printer_series', array('neq' => '' ))
					->addAttributeToFilter('type_id', array('eq' => 'grouped'))
					->addCategoryFilter($category);

  			
		/*echo $products->getselect();
		exit;*/ 
		
				
		foreach($products as $product)
		{
			$series[$product->getPrinterSeries()] = $product->getAttributeText('printer_series');
		}
	
		$series=array_unique($series);
		asort($series); 
		
		
		
	/*	echo "<pre>";
		print_r($series);
			 */
	
		
	//	$seriess[$catelist_id] = $series;
		
		
			
			
	//	$alldata[$catelist_id] = $series;
	
	foreach($series as $key => $series1){
					$keyvalue = $key."-".$series1;
				$model = array();
				
				 $category = Mage::getModel('catalog/category')->load($catelist_id);

		
					$products = Mage::getModel('catalog/product')
								->getCollection()
								->addAttributeToSelect('*')
								->addAttributeToFilter('type_id', array('eq' => 'grouped'))
								->addCategoryFilter($category)
								->addAttributeToFilter('printer_series', array('finset' => $key ));

					
					foreach($products as $product)
					{
						$model[$product->getPrinterModel()]=$product->getAttributeText('printer_model');
					}
					$models=array_unique($model);
					asort($models);
					
					 
					$allData[$catelist_id][$keyvalue] = $models;
					
//~ echo "<pre>";
		//~ print_r($allData);
		//~ exit;   
					
		}
		/* echo "<pre>";
		print_r($allData);
		exit;   */
	
	
	/*if($i==0){
		exit;
	} */
	$i++;	
	
}

/*print_r($allData);
exit;	*/	
		

$jsondata = json_encode($allData);




$myfile = fopen("search_json_data.txt", "w") or die("Unable to open file!");
if ($myfile !== false) {
    ftruncate($myfile, 0);	
}
fwrite($myfile ,$jsondata );
fclose($myfile);

echo "Done";




