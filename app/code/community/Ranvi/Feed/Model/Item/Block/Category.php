<?php

class Ranvi_Feed_Model_Item_Block_Category extends Ranvi_Feed_Model_Item_Block{

public function setVars($content = null, $dataObject=null, $remove_empty=false){

			

			$categories = $this->getFeed()->getCategoriesCollection();

			

			$contents = array();

			

			foreach($categories as $category){

				

				if($category->getLevel() > 1){

				

				$contents[] = parent::setVars($content, $category);

				

				}

				

			}

			

			return implode("\r\n", $contents);



		}

		

	}