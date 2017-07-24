<?php
/* $collection->getSelect()->joinLeft('catalog_product_entity_varchar', 'catalog_product_entity_varchar.entity_id = e.entity_id',array('catalog_product_entity_varchar.attribute_id','catalog_product_entity_varchar.value'));
$collection->getSelect()->where('(catalog_product_entity_varchar.attribute_id = 148) and (catalog_product_entity_varchar.value IS NULL)');
$collection->getSelect()->group('e.entity_id'); */

/**
 * @author     Aurélien Millet
 * @link       https://github.com/aurmil/
 */

/* class Aurmil_CustomizePriceFilter_Model_Catalog_Resource_Layer_Filter_Price
extends Mage_Catalog_Model_Resource_Layer_Filter_Price */
class Aurmil_CustomizePriceFilter_Model_Catalog_Resource_Layer_Filter_Price
extends Mage_Core_Model_Mysql4_Abstract
{   
    /**
     * Initialize connection and define main table name
     *
     */
    protected function _construct()
    {
        $this->_init('catalog/product_index_price', 'entity_id');
    }

    /**
     * Retrieve joined price index table alias
     *
     * @return string
     */
    protected function _getIndexTableAlias()
    {
        return 'price_index';
    }

    /**
     * Prepare response object and dispatch prepare price event
     *
     * Return response object
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @param Varien_Db_Select $select
     * @return Varien_Object
     */
    protected function _dispatchPreparePriceEvent($filter, $select)
    {
        // prepare response object for event
        $response = new Varien_Object();
        $response->setAdditionalCalculations(array());

        // prepare event arguments
        $eventArgs = array(
            'select'          => $select,
            'table'           => $this->_getIndexTableAlias(),
            'store_id'        => $filter->getStoreId(),
            'response_object' => $response
        );

        /**
         * @deprecated since 1.3.2.2
         */
        Mage::dispatchEvent('catalogindex_prepare_price_select', $eventArgs);

        /**
         * @since 1.4
         */
        Mage::dispatchEvent('catalog_prepare_price_select', $eventArgs);

        return $response;
    }
	
	/**
     * Retrieve minimal price for attribute
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @return float
     */
    public function getMinPrice($filter)
    {
        $select     = $this->_getSelect($filter);
        $connection = $this->_getReadAdapter();
        $response   = $this->_dispatchPreparePriceEvent($filter, $select);

        $table = $this->_getIndexTableAlias();

        $additional     = join('', $response->getAdditionalCalculations());
        $minPriceExpr   = new Zend_Db_Expr("MIN({$table}.min_price {$additional})");

        $select->columns(array($minPriceExpr));

        return $connection->fetchOne($select) * $filter->getCurrencyRate();
    }
	
    /**
     * Retrieve maximal price for attribute
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @return float
     */
    public function getMaxPrice($filter)
    {
        $select     = $this->_getSelect($filter);
        $connection = $this->_getReadAdapter();
        $response   = $this->_dispatchPreparePriceEvent($filter, $select);

        $table = $this->_getIndexTableAlias();

        $additional     = join('', $response->getAdditionalCalculations());
        $maxPriceExpr   = new Zend_Db_Expr("MAX({$table}.min_price {$additional})");

        $select->columns(array($maxPriceExpr));

        return $connection->fetchOne($select) * $filter->getCurrencyRate();
    }
    
    protected function _getSelect($filter)
    {
    	$base_select = $filter->getLayer()->getBaseSelect();
    	
    	if(isset($base_select['price'])){
        	
        	$select = $base_select['price'];
        
        }else{
        	
        	$collection = $filter->getLayer()->getProductCollection();
        	//$collection->AddAttributeToFilter ('price', array ('neq' => 0));
        	$collection->addPriceData($filter->getCustomerGroupId(), $filter->getWebsiteId());
        	$select = clone $collection->getSelect();
        	
        }
        /* $select->joinLeft('catalog_product_entity_varchar', 'catalog_product_entity_varchar.entity_id = e.entity_id',array('catalog_product_entity_varchar.attribute_id','catalog_product_entity_varchar.value'));
        $select->where('(catalog_product_entity_varchar.attribute_id = 148) and (catalog_product_entity_varchar.value IS NULL)');
        $select->group('e.entity_id'); */
        
        //Mage::log($select, null, 'mylogfile.log');
        // reset columns, order and limitation conditions
        $select->reset(Zend_Db_Select::COLUMNS);
        $select->reset(Zend_Db_Select::ORDER);
        $select->reset(Zend_Db_Select::LIMIT_COUNT);
        $select->reset(Zend_Db_Select::LIMIT_OFFSET);
		$select->reset(Zend_Db_Select::GROUP);		
		
        return $select;
    }
	
    /**
     * Retrieve array with products counts per price range
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @param int $range
     * @return array
     */
    public function getCount($filter, $range)
    {
    	
        $select     = $this->_getSelect($filter);
        $connection = $this->_getReadAdapter();
        $response   = $this->_dispatchPreparePriceEvent($filter, $select);

        $table = $this->_getIndexTableAlias();

        $additional = join('', $response->getAdditionalCalculations());
        $rate       = $filter->getCurrencyRate();
        $countExpr  = new Zend_Db_Expr("COUNT(DISTINCT e.entity_id)");
        $rangeExpr  = new Zend_Db_Expr("FLOOR((({$table}.min_price {$additional}) * {$rate}) / {$range}) + 1");

        $select->columns(array(
            'range' => $rangeExpr,
            'count' => $countExpr
        ));
        $select->where("{$table}.min_price > 0");
        $select->group('range');
        
        return $connection->fetchPairs($select);
    }
	
	public function prepareSelect($filter, $value, $select){
		
        $response   = $this->_dispatchPreparePriceEvent($filter, $select);

        $table      = $this->_getIndexTableAlias();
        $additional = join('', $response->getAdditionalCalculations());
        $rate       = $filter->getCurrencyRate();
        $priceExpr  = new Zend_Db_Expr("(({$table}.min_price {$additional}) * {$rate})");
		
		$where = array();
		
		switch($filter->getAttributeModel()->getFilterType()):
		
		case (GoMage_Navigation_Model_Layer::FILTER_TYPE_INPUT):
    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_SLIDER):
    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_SLIDER_INPUT):
    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_INPUT_SLIDER):    
    		
    		
    		
    		$from	= isset($value['from']) ? intval($value['from']) : 0;
    		$to		= isset($value['to']) ? intval($value['to']) : 0;
    		
    		$where[] = sprintf($priceExpr . ' >= %s', $from) . ($to > 0 ? ' AND ' . sprintf($priceExpr . ' <= %d', $to) : '');
    		
    	break;
		
		default:
		
			foreach((array)$value as $_value){
				
				$where[] = sprintf($priceExpr . ' >= %s', ($_value['range'] * ($_value['index'] - 1))) . ' AND ' . sprintf($priceExpr . ' < %d', ($_value['range'] * $_value['index']));
				
			}
		
		break;
		
		endswitch;
		
        $select->where(implode(' OR ', $where));
        
	}
	
    /**
     * Apply attribute filter to product collection
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @param int $range
     * @param int $index    the range factor
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Layer_Filter_Attribute
     */
	public function applyFilterToCollection($filter, $from, $to)
	{
		if (method_exists($filter, 'usePriceRanges') && $filter->usePriceRanges()) {
			if (('' === $from) && ('' === $to)) {
				return $this;
			}

			$collection = $filter->getLayer()->getProductCollection();
			$collection->addPriceData($filter->getCustomerGroupId(), $filter->getWebsiteId());

			
			$select     = $collection->getSelect();
			$response   = $this->_dispatchPreparePriceEvent($filter, $select);

			$table      = $this->_getIndexTableAlias();
			$additional = implode('', $response->getAdditionalCalculations());
			$rate       = $filter->getCurrencyRate();
			$priceExpr  = new Zend_Db_Expr("(({$table}.min_price {$additional}) * {$rate})");

			if ('' !== $to) {
				$to = (int) $to;
				if ($from == $to) {
					$to += 1;
				}
			}

			if ('' !== $from) {
				$select->where($priceExpr . ' >= ?', $from);
			}
			if ('' !== $to) {
				if (Mage::getStoreConfigFlag('catalog/layered_navigation/price_subtraction')) {
					$select->where($priceExpr . ' < ?', $to);
				} else {
					$select->where($priceExpr . ' <= ?', $to);
				}
			}
		} else {

			$range = $from;
			$index = $to;

			/* Mage::log("==============", null, 'mylogfile.log');
			Mage::log($range, null, 'mylogfile.log');
			Mage::log("==============", null, 'mylogfile.log');
			Mage::log($index, null, 'mylogfile.log'); */
			$collection = $filter->getLayer()->getProductCollection();
			//$collection->reset(Zend_Db_Select::COLUMNS)->columns('mfm_cfp');
			//$collection->addAttributeToSelect('mfm_cfp');
			//$collection->addAttributeToSelect('*');
			$collection->AddAttributeToFilter ('price', array ('neq' => 0));
			
			/* $collection->getSelect()->joinLeft('catalog_product_entity_varchar', 'catalog_product_entity_varchar.entity_id = e.entity_id',array('catalog_product_entity_varchar.attribute_id','catalog_product_entity_varchar.value'));
			$collection->getSelect()->where('(catalog_product_entity_varchar.attribute_id = 148) and (catalog_product_entity_varchar.value IS NULL)');
			$collection->getSelect()->group('e.entity_id'); */
			$collection->addPriceData($filter->getCustomerGroupId(), $filter->getWebsiteId());

			$select     = $collection->getSelect();
			$response   = $this->_dispatchPreparePriceEvent($filter, $select);

			$table      = $this->_getIndexTableAlias();
			$additional = implode('', $response->getAdditionalCalculations());
			$rate       = $filter->getCurrencyRate();
			$priceExpr  = new Zend_Db_Expr("(({$table}.min_price {$additional}) * {$rate})");
				
			for($range_i = 0; $range_i < count($range); $range_i++)
			{
				if($range_i == 0)
				{
					$select->where($priceExpr . ' >= ?', ($range[$range_i]['range'] * ($range[$range_i]['index'] - 1)));
		
					if (Mage::getStoreConfigFlag('catalog/layered_navigation/price_subtraction')) {
						//Mage::log("if", null, 'mylogfile.log');
						$select->where($priceExpr . ' < ?', ($range[$range_i]['range'] * $range[$range_i]['index']));
					} else {
						//Mage::log("else", null, 'mylogfile.log');
						$select->where($priceExpr . ' <= ?', ($range[$range_i]['range'] * $range[$range_i]['index']));
					}
				}
				else 
				{
					$select->orWhere($priceExpr . ' >= ?', ($range[$range_i]['range'] * ($range[$range_i]['index'] - 1)));
					
					if (Mage::getStoreConfigFlag('catalog/layered_navigation/price_subtraction')) {
						//Mage::log("if", null, 'mylogfile.log');
						$select->orWhere($priceExpr . ' < ?', ($range[$range_i]['range'] * $range[$range_i]['index']));
					} else {
						//Mage::log("else", null, 'mylogfile.log');
						$select->Where($priceExpr . ' <= ?', ($range[$range_i]['range'] * $range[$range_i]['index']));
					}
				}
			}
			//Mage::log($select, null, 'mylogfile.log');
		}

		//Mage::log($collection->getData(), null, 'mylogfile.log');
		return $this;
	}
    
    public function applyPriceRange($filter)
    {
    	$interval = $filter->getInterval();
    	if (!$interval) {
    		return $this;
    	}
    
    	list($from, $to) = $interval;
    	if ($from === '' && $to === '') {
    		return $this;
    	}
    	$select = $filter->getLayer()->getProductCollection()->getSelect();
    	$priceExpr = $this->_getPriceExpression($filter, $select, false);
    
    	if ($to !== '') {
    		$to = (float) $to;
    		if ($from == $to) {
    			$to += self::MIN_POSSIBLE_PRICE;
    		}
    	}
    
    	if ($from !== '') {
    		$select->where($priceExpr . ' >= ' . $this->_getComparingValue($from, $filter));
    	}
    	if ($to !== '') {
    		if (Mage::getStoreConfigFlag('catalog/layered_navigation/price_subtraction')) {
    			$select->where($priceExpr . ' < ' . $this->_getComparingValue($to, $filter));
    		} else {
    			$select->where($priceExpr . ' <= ' . $to);
    		}
    	}
    
    	return $this;
    }
}