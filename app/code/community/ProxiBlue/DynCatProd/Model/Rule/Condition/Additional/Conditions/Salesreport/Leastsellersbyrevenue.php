<?php

/**
 * Customer Registration rule condition
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Salesreport_Leastsellersbyrevenue
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Salesreport_Abstract
{

    protected $_inputType = 'text';

    public function __construct()
    {
        parent::__construct();
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_salesreport_leastsellersbyrevenue'
        )
            ->setValue(null)
            ->setConditions(array())
            ->setActions(array());
    }

    /**
     * Render this as html
     *
     * @return string
     */
    public function asHtml()
    {
        $html = $this->getTypeElement()->getHtml() .
            Mage::helper('dyncatprod')->__(
                "Least Selling products by revenue"
            );
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    public function asString($format = '')
    {
        $str = Mage::helper('dyncatprod')->__(
            "Best Selling products by revenue"
        );

        return $str;
    }


    /**
     * validate
     *
     * @param  Varien_Object $object
     *
     * @return boolean
     */
    public function _validate(Varien_Object $object)
    {
        try {
            $customCollection = Mage::getModel('sales/order_item')->getCollection();
            $customCollection->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns(array('product_id' => 'product_id',
                                'total' => 'SUM(`price`) * `qty_ordered`'))
                ->group('product_id')
                ->order('total ASC');
            $select = $customCollection->getSelect();

            $collection = $object->getCollection();
            $fromPartBefore = $collection->getSelect()->getPart(Zend_Db_Select::FROM);

            $collection->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->reset(Zend_Db_Select::COLUMNS)
                ->reset(Zend_Db_Select::FROM)
                ->reset(Zend_Db_Select::GROUP)
                ->from($select, 'total') // Using from with Zend_Db_Select as name auto uses "t" as table alias
                ->join(
                    array('e' => $collection->getTable('catalog/product')),
                    '`t`.product_id = `e`.entity_id',
                    array('entity_id')
                );

            $fromPartAfter = $collection->getSelect()->getPart(Zend_Db_Select::FROM);
            if(array_key_exists('e', $fromPartBefore)) {
                unset($fromPartBefore['e']);
            }
            $fromCombined = array_merge($fromPartBefore, $fromPartAfter);

            $collection->getSelect()->setPart(
                Zend_Db_Select::FROM,
                $fromCombined
            );


            $this->getHelper()->debug(
                'LEAST SELLERS BY REVENUE SQL: ' . $collection->getSelect()
            );
            // replace the current collection with the sales one.
            $collection->setFlag('is_replaced', true);
            return true;

        } catch (Exception $e) {
            mage::logException($e);
        }

        return false;
    }
}
