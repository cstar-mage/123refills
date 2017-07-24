<?php

		$resource = Mage::getSingleton('core/resource');
    	$read= $resource->getConnection('core_read');
    	$table = $resource->getTableName('evolved');
    	$writeConnection = $resource->getConnection('core_write');
    		
    	$query = 'UPDATE '.$table.' SET value = "_self" WHERE field LIKE "%brand_manager_target%"';
    	
    	$writeConnection->query($query);