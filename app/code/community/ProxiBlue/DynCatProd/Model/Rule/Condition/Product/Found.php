<?php

/**
 * Product promo rule
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Rule_Condition_Product_Found
    extends ProxiBlue_DynCatProd_Model_Rule_Condition_Product_Combine
{

    protected $_orderCount = 0;

    public function __construct($args)
    {
        parent::__construct($args);
        $this->setType('dyncatprod/rule_condition_product_found')
            ->setAggregator('all')
            ->setValue(true)
            ->setCombiner('AND');
        $this->loadCombinerOptions();
        if ($options = $this->getCombinerOptions()) {
            foreach ($options as $combiner => $dummy) {
                $this->setCombiner($combiner);
                break;
            }
        }
    }

    public function loadCombinerOptions()
    {
        $this->setCombinerOption(
            array(
                'AND'   => Mage::helper('rule')->__('AND'),
                'OR'    => Mage::helper('rule')->__('OR'),
                'SUB'   => Mage::helper('rule')->__('SUB RESULT'),
//                'UNION' => Mage::helper('rule')->__('UNION'),
            )
        );

        return $this;
    }

    public function asHtml()
    {
        $html = $this->getTypeElement()->getHtml();

        $html .= Mage::helper('dyncatprod')->__(
            "%s If a product is in the catalog with %s of these conditions %s:",
            $this->getCombinerElement()->getHtml(),
            $this->getAggregatorElement()->getHtml(),
            $this->getValueElement()->getHtml()
        );

        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    public function getCombinerElement()
    {
        if (is_null($this->getCombiner())) {
            foreach ($this->getCombinerOption() as $k => $v) {
                $this->setCombiner($k);
                break;
            }
        }

        return $this->getForm()->addField(
            $this->getPrefix() . '__' . $this->getId() . '__combiner', 'select',
            array(
                'name'       =>
                    'rule[' . $this->getPrefix() . '][' . $this->getId()
                    . '][combiner]',
                'values'     => $this->getCombinerSelectOptions(),
                'value'      => $this->getCombiner(),
                'value_name' => $this->getCombinerName(),
            )
        )->setRenderer(Mage::getBlockSingleton('rule/editable'));
    }

    /**
     * Make sure combiner value is set to AND if null.
     * Placed for backwards compatibility to pre v3.
     *
     * @return boolean
     */
    public function getCombiner()
    {
        if (is_null($this->getData('combiner'))) {
            $this->setCombiner('AND');
        }

        return strtoupper($this->getData('combiner'));
    }

    public function getCombinerSelectOptions()
    {
        $opt = array();
        foreach ($this->getCombinerOption() as $k => $v) {
            $opt[] = array('value' => $k, 'label' => $v);
        }

        return $opt;
    }

    public function getCombinerName()
    {
        return $this->getCombinerOption($this->getCombiner());
    }

    public function asString($format = '')
    {
        $str = Mage::helper('dyncatprod')->__(
            "If a product is in the catalog with %s of these conditions %s:",
            $this->getAggregatorName(),
            $this->getValueName()
        );

        return $str;
    }

    public function validate(Varien_Object $object)
    {
        if (!$this->getConditions()) {
            return false;
        }

        $all = $this->getAggregator() === 'all';
        $true = (bool)$this->getValue();

        foreach ($this->getConditions() as $cond) {
            // attach $this to the object, which will
            // allow us to test the bool state in sql build
            // solves BUG SUPP-7358659305144 where setting FALSE
            // on a rule should invert the sql result.
            $object->setConditionObject($this);
            $validated = $cond->validate($object);
        }
        $select = $object->getCollection()->getSelect();
        // is this a UNION?
        if ($this->getCombiner() == 'UNION') {
            $unionCollector = $object->getUnionCollector();
            $unionCollector[$this->getId()] = $select;
            $object->setUnionCollector($unionCollector);
        } else {
            // group the WHERE for this subset into one group

            $wherePart = $select->getPart(Zend_Db_Select::WHERE);
            $whereCollector = $object->getWhereCollector();
            $whereCollector[$this->getId()] = $wherePart;
            $object->setWhereCollector($whereCollector);

            $columnPart = $select->getPart(Zend_Db_Select::COLUMNS);
            $colCollector = $object->getColCollector();
            $colCollector[$this->getId()] = $columnPart;
            $object->setColCollector($colCollector);

            $fromPart = $select->getPart(Zend_Db_Select::FROM);
            $fromCollector = $object->getFromCollector();
            $fromCollector[$this->getId()] = $fromPart;
            $object->setFromCollector($fromCollector);
            // reset the collection where part so we can start fresh
            $select->reset(Zend_Db_Select::WHERE);
        }

        return $validated;
    }

    /**
     * Make sure value is set to TRUE if null.
     * Placed for backwards compatibility to pre v3.
     *
     * @return boolean
     */
    public function getValue()
    {
        $value = parent::getValue();
        if (is_null($value)) {
            $this->setValue(true);
        }

        return $this->getData('value');
    }

}
