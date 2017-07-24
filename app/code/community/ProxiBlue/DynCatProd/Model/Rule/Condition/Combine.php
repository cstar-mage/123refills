<?php

/**
 * Conditions combine for dynamic products
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Rule_Condition_Combine
    extends ProxiBlue_DynCatProd_Model_Rule_Condition_Backport
{

    private $_startProcessingorder = 10;


    public function __construct($args)
    {
        if (!empty($args['prefix'])) {
            $this->_prefix = $args['prefix'];
        }
        parent::__construct($args);
        $this->setType('dyncatprod/rule_condition_combine')
            ->setValue(true)
            ->setAggregator('all');

    }

    /**
     * Conditions child rules
     * Current supported:
     * Cart Subtotal
     *
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive(
            $conditions,
            array(
                array(
                    'value' => 'dyncatprod/rule_condition_product_found',
                    'label' => Mage::helper('dyncatprod')->__(
                        'Product Data Rules'
                    )),
                array(
                    'value' => 'dyncatprod/rule_condition_additional_conditions_limiter',
                    'label' => Mage::helper('dyncatprod')->__('Limit Results')),
                array(
                    'value' => 'dyncatprod/rule_condition_additional_conditions_transformations',
                    'label' => Mage::helper('dyncatprod')->__(
                        'Additional Result Filters'
                    )),
                array(
                    'value' => 'dyncatprod/rule_condition_additional_conditions_sorter',
                    'label' => Mage::helper('dyncatprod')->__('Sort Results')),
                array(
                    'value' => 'dyncatprod/rule_condition_category_control',
                    'label' => Mage::helper('dyncatprod')->__(
                        'Category Control Combination'
                    )),
                array(
                    'value' => 'dyncatprod/rule_condition_product_update',
                    'label' => Mage::helper('dyncatprod')->__(
                        'Product Attribute Updates'
                    )),
            )
        );

        return $conditions;
    }

    /**
     * Build the html rule selections for conditons
     *
     * @return string
     */
    public function asHtmlRecursive()
    {
        $html = $this->asHtml() . '<ul id="' . $this->getPrefix() . '__'
            . $this->getId()
            . '__children" class="rule-param-start">';
        foreach ($this->getConditions() as $cond) {
            $html .= '<li>' . $cond->asHtmlRecursive() . '</li>';
        }
        $html .= '<li>' . $this->getNewChildElement()->getHtml() . '</li></ul>';

        return $html;
    }

    /**
     * Render condions as html
     *
     * @return string
     */
    public function asHtml()
    {
        $html = $this->getTypeElement()->getHtml();
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    /**
     * Load the conditons into the required objects.
     *
     * From v3, this sorts the conritions as per set processing order
     *
     * @param  type $arr
     * @param  type $key
     *
     * @return \ProxiBlue_DynCatProd_Model_Rule_Condition_Product_Found
     */
    public function loadArray($arr, $key = 'conditions')
    {
        $this->setAggregator(
            isset($arr['aggregator'])
                ? $arr['aggregator']
                : (isset($arr['attribute'])
                ? $arr['attribute']
                : null)
        )
            ->setValue(
                isset($arr['value'])
                    ? $arr['value']
                    : (isset($arr['operator'])
                    ? $arr['operator']
                    : null)
            );
        if (!empty($arr[$key]) && is_array($arr[$key])) {
            foreach ($arr[$key] as $condArr) {
                try {
                    $cond = $this->_getNewConditionModelInstance(
                        $condArr['type']
                    );
                    if ($cond) {
                        $this->addCondition($cond);
                        $cond->loadArray(
                            $condArr,
                            $key
                        );
                    }
                } catch (Exception $e) {
                    Mage::logException($e);
                }
            }
        }
        $conditions = $this->getConditions();
        ksort(
            $conditions,
            SORT_NUMERIC
        );
        $this->setConditions($conditions);

        return $this;
    }

    /**
     * Build the condition array.
     *
     * From v3 this sets a processing order found form the class objects
     * This is set via a constant in the class named 'PROCESSING_ORDER';
     *
     * @param  type $condition
     *
     * @return \ProxiBlue_DynCatProd_Model_Rule_Condition_Product_Found
     */
    public function addCondition($condition)
    {
        $condition->setRule($this->getRule());
        $condition->setObject($this->getObject());
        $condition->setPrefix($this->getPrefix());

        $conditions = $this->getConditions();
        if ($condition->getProcessingOrder() == 'last') {
            $conditions[] = $condition;
        } else {
            if (array_key_exists(
                $this->getProcessingOrder($condition),
                $conditions
            )) {
                mage::helper('dyncatprod')
                    ->debug(
                        'Rule '
                        . get_class($condition)
                        . ' appear to have the same processing order than '
                        . 'another rule. '
                        . 'This can result in unexpected rules behaviour. '
                        . 'Contact sales@proxiblue.com.au to correct this.'
                    );
                $condition->setProcessingOrder(
                    $this->getProcessingOrder($condition) + rand(
                        200,
                        500
                    ) + rand(
                        200,
                        500
                    )
                );
            }
            $conditions[$this->getProcessingOrder($condition)] = $condition;
        }
        if (!$condition->getId()) {
            $condition->setId($this->getId() . '--' . sizeof($conditions));
        }
        $this->setData(
            $this->getPrefix(),
            $conditions
        );

        return $this;
    }

    protected function getProcessingOrder($condition)
    {
        if ($condition->getProcessingOrder() === false
            || is_null(
                $condition->getProcessingOrder()
            )
        ) {
            $this->_startProcessingorder = $this->_startProcessingorder + 1;
            $condition->setProcessingOrder($this->_startProcessingorder);
        }

        return $condition->getProcessingOrder();
    }

    public function validate(Varien_Object $object)
    {
        if (!$this->getConditions()) {
            return false;
        }

        $all = $this->getAggregator() === 'all';
        $true = (bool)$this->getValue();

        $object->setWhereCollector(array());
        $object->setColCollector(array());
        $object->setFromCollector(array());
        $object->setUnionCollector(array());

        foreach ($this->getConditions() as $cond) {
            $object->setWhereCollector(
                array_merge(
                    $object->getWhereCollector(),
                    array(
                        $cond->getId() => array())
                )
            );
            $object->setColCollector(
                array_merge(
                    $object->getColCollector(),
                    array(
                        $cond->getId() => array())
                )
            );
            $object->setFromCollector(
                array_merge(
                    $object->getFromCollector(),
                    array(
                        $cond->getId() => array())
                )
            );

            $validated = $cond->validate($object);

            if ($all && $validated !== $true) {
                return false;
            }
        }

        $whereCollector = $this->flattenWhereCollector($object);
        $this->mergeWhereCollector($whereCollector, $object);
        $this->mergeUnionCollector($object);

        return $validated;
    }

    /**
     * all rules must validate for results
     *
     * @return string
     */
    public function getAggregator()
    {
        if (!$this->getData('aggregator')) {
            return 'all';
        } else {
            return $this->getData('aggregator');
        }
    }

    /**
     * result must be true
     *
     * @return string
     */
    public function getValue()
    {
        if (!$this->getData('value')) {
            return true;
        } else {
            return $this->getData('value');
        }
    }

    private function flattenWhereCollector($object)
    {
        $select = $object->getCollection()->getSelect();
        $select->reset(Zend_Db_Select::WHERE);
        $whereCollector = array_reverse($object->getWhereCollector());
        // flatten the whereCollector condition parts
        $stripFirstLinker = false;
        foreach ($whereCollector as $key => $condWhereParts) {
            // merge any occurances of special date where clauses into one line
            $mergedClause = array();
            foreach ($condWhereParts as $whereKey => $clause) {
                if (strpos(
                        $clause,
                        'at_special_'
                    ) == true ||
                    strpos(
                        $clause,
                        '_table_special_'
                    ) == true
                ) {
                    $mergedClause[] = $clause;
                    unset($condWhereParts[$whereKey]);
                }
            }
            if (count($mergedClause) > 0) {
                $mergedClause = implode(" ", $mergedClause);
                $mergedClause = trim(
                    preg_replace(
                        '/^OR|^AND/',
                        '',
                        trim($mergedClause)
                    )
                );
                $condWhereParts[] = "AND ( " . $mergedClause . ")";
            }
            if (is_null($condWhereParts) || count($condWhereParts) == 0) {
                unset($whereCollector[$key]);
                continue;
            }
            // adjust the conditions where parts to OR if we are using ANY
            foreach ($this->getConditions() as $cond) {
                if ($cond->getId() == $key && $cond->getAggregator() == 'any') {
                    foreach ($condWhereParts as $partKey => $clause) {
                        $condWhereParts[$partKey] = trim(
                            preg_replace(
                                '/^AND/',
                                'OR',
                                trim($clause)
                            )
                        );
                    }
                    $fromPart = $select->getPart(Zend_Db_Select::FROM);
                    $select->reset(Zend_Db_Select::FROM);
                    foreach ($fromPart as $fromKey => $from) {
                        if (array_key_exists('joinType', $from)
                            && $from['joinType'] == 'inner join'
                        ) {
                            $fromPart[$fromKey]['joinType']
                                = 'left join';
                        }
                    }
                    $select->setPart(
                        Zend_Db_Select::FROM, $fromPart
                    );
                    mage::helper('dyncatprod')->debug(
                        'SQL CONVERTED TO OR FOR ANY + JOINS: ' . $select
                    );
                }
            }
            mage::helper('dyncatprod')->debug(
                'SQL CONVERTED: ' . $select
            );
            if ($stripFirstLinker) {
                reset($condWhereParts);
                $first = key($condWhereParts);
                $condWhereParts[$first] = trim(
                    preg_replace(
                        '/^OR|^AND/',
                        '',
                        trim($condWhereParts[$first])
                    )
                );
            }
            $whereCollector[$key] = "(" . implode(
                    " ",
                    $condWhereParts
                ) . ")";
            $stripFirstLinker = true;
        }

        return $whereCollector;
    }

    private function mergeWhereCollector(
        $whereCollector, $object
    ) {
        // now combine them into one where clause
        $isFirstCondition = true;
        $combined = false;
        $resetWhere = true;
        foreach ($this->getConditions() as $cond) {
            if (array_key_exists(
                $cond->getId(),
                $whereCollector
            )) {
                if (!$isFirstCondition) {
                    $combiner = ($cond->getCombiner())
                        ? $cond->getCombiner()
                        : 'AND';
                    switch ($combiner) {
                        case "AND":
                            break;
                        case "OR":
                            // ORS must be LEFT JOINED
                            // convert INNER TO LEFT
                            $fromPart = $object->getCollection()->getSelect()
                                ->getPart(Zend_Db_Select::FROM);
                            $object->getCollection()->getSelect()->reset(
                                Zend_Db_Select::FROM
                            );
                            foreach ($fromPart as $fromKey => $from) {
                                if (array_key_exists('joinType', $from)
                                    && $from['joinType'] == 'inner join'
                                ) {
                                    $fromPart[$fromKey]['joinType']
                                        = 'left join';
                                }
                            }
                            $object->getCollection()->getSelect()->setPart(
                                Zend_Db_Select::FROM, $fromPart
                            );
                            break;
                        case 'SUB':
                            // need to run the collection at this point, and get
                            // all the ids of the resulting items
                            // Use these as exclusions in the SUB collection.
                            mage::helper('dyncatprod')->debug(
                                'SUB: ' . $whereCollector[$cond->getId()], 5
                            );
                            // remove all columns, and only get the entity_id
                            $subSelect = clone $object->getCollection()
                                ->getSelect();
                            $subSelect->setPart(
                                Zend_Db_Select::WHERE,
                                (array)$combined
                            );
                            $subSelect->reset(Zend_Db_Select::COLUMNS);
                            $newColumns = array(
                                '0' => array(
                                    'e',
                                    'entity_id',
                                    null));
                            $subSelect->setPart(
                                Zend_Db_Select::COLUMNS,
                                $newColumns
                            );
                            $object->getCollection()->getSelect()->where(
                                'e.entity_id IN (?)',
                                new Zend_Db_Expr(
                                    $subSelect->__toString()
                                )
                            );
                            mage::helper('dyncatprod')->debug(
                                'QUERY BEFORE SUB: ' . $subSelect
                                , 5
                            );
                            $combined = '';
                            $combiner = '';
                            $resetWhere = false;
                            $isFirstCondition = false;
                            break;
                        default:
                            mage::throwException(
                                'Unhandled combiner ' . $combiner
                            );
                            break;
                    }
                    $combined .= " " . $combiner . " "
                        . $whereCollector[$cond->getId()];
                    // fix an issue that happens with special price rule when combined (only?)
                    // LVSTODO: INVESTIGATE THIS ISSUE, and remove workaround
                    $combined = str_replace('AND (AND (', 'AND ((', $combined);
                    $combined = str_replace('OR (AND (', 'OR ((', $combined);
                    $combined = str_replace('AND (OR (', 'AND ((', $combined);
                    $combined = str_replace('OR (OR (', 'OR ((', $combined);
                } else {
                    $combined = $whereCollector[$cond->getId()];
                    $isFirstCondition = false;
                }
            }
        }

        if ($combined !== false) {
            // fix an issue that happens with special price rule when combined (only?)
            // LVSTODO: INVESTIGATE THIS ISSUE, and remove workaround
            $combined = trim(
                preg_replace(
                    '/^\(OR|^\(AND/',
                    '(',
                    trim($combined)
                )
            );
            if ($resetWhere) {
                $object->getCollection()->getSelect()->setPart(
                    Zend_Db_Select::WHERE,
                    (array)$combined
                );
            } else {
                $wherePart = $object->getCollection()->getSelect()
                    ->getPart(Zend_Db_Select::WHERE);
                $wherePart[] = ' AND ' . $combined;
                $object->getCollection()->getSelect()->setPart(
                    Zend_Db_Select::WHERE,
                    $wherePart
                );
            }

            // if this is a replaced collection, then inject the colCollector elements
            // and where collector elements back into the collection parts
            if ($object->getCollection()->getFlag('is_replaced')) {
                foreach ($object->getColCollector() as $column) {
                    if (is_array($column)) {
                        foreach ($column as $columnParts) {
                            $isInCurrent = false;
                            $currentColumnParts = $object->getCollection()->getSelect()
                                ->getPart(Zend_Db_Select::COLUMNS);
                            foreach ($currentColumnParts as $currentPart) {
                                if ($currentPart[0] == $columnParts[0]) {
                                    $isInCurrent = true;
                                    break;
                                }
                            }
                            if ($isInCurrent == false) {
                                mage::helper('dyncatprod')->debug(
                                    'SQL COMBINED ADDING DROPPED COLUMN: ' . print_r($columnParts, true), 5
                                );
                                $currentColumnParts[] = $columnParts;
                                $object->getCollection()->getSelect()->setPart(
                                    Zend_Db_Select::COLUMNS,
                                    $currentColumnParts
                                );
                            }
                        }
                    }
                }

                // do the same for FROM
                foreach ($object->getFromCollector() as $from) {
                    if (is_array($from)) {
                        foreach ($from as $fromKey => $fromParts) {
                            $isInCurrent = false;
                            $currentFromParts = $object->getCollection()->getSelect()
                                ->getPart(Zend_Db_Select::FROM);
                            foreach ($currentFromParts as $currentPart) {
                                if ($currentPart['tableName'] == $fromParts['tableName']) {
                                    $isInCurrent = true;
                                    break;
                                }
                            }
                            if ($isInCurrent == false) {
                                mage::helper('dyncatprod')->debug(
                                    'SQL COMBINED ADDING DROPPED FROM: Using Key ' . $fromKey . ' '
                                    . print_r($fromParts, true), 5
                                );
                                $currentFromParts[$fromKey] = $fromParts;
                                $object->getCollection()->getSelect()->setPart(
                                    Zend_Db_Select::FROM,
                                    $currentFromParts
                                );
                            }
                        }
                    }
                }


            }

            mage::helper('dyncatprod')->debug(
                'SQL COMBINED: ' . $object->getCollection()->getSelect()
            );
        }

    }

    private function mergeUnionCollector(
        $object
    ) {
        if (count($object->getUnionCollector()) > 0) {
            $object->getCollection()->getSelect()->union($object->getUnionCollector());
            try {
                mage::helper('dyncatprod')->debug(
                    'SQL COMBINED: ' . $object->getCollection()->getSelect()
                );
            } catch (Exception $e) {
                mage::logException($e);
            }
        }
    }

}
