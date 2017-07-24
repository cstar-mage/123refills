<?php

class Ideal_Coupon_Block_Coupons_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('salesrule/rule')
            ->getResourceCollection();
        $collection->getSelect()->joinLeft(array('rule_url' => 'ideal_sales_rule_url'), 'main_table.rule_id = rule_url.sales_rule_id',
            array('sales_rule_id' => 'rule_url.sales_rule_id', 'url' => 'rule_url.url'));
        $collection->addWebsitesToResult();
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('rule_id', array(
            'header'    => Mage::helper('IdealCoupon')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'rule_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('IdealCoupon')->__('Rule Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));

        $this->addColumn('coupon_code', array(
            'header'    => Mage::helper('IdealCoupon')->__('Coupon Code'),
            'align'     => 'left',
            'width'     => '150px',
            'index'     => 'code',
        ));

        $this->addColumn('from_date', array(
            'header'    => Mage::helper('IdealCoupon')->__('Date Start'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'index'     => 'from_date',
        ));

        $this->addColumn('to_date', array(
            'header'    => Mage::helper('IdealCoupon')->__('Date Expire'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'to_date',
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('IdealCoupon')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));

        $this->addColumn('url', array(
            'header'    => Mage::helper('IdealCoupon')->__('Url'),
            'align'     => 'left',
            'width'     => '160px',
            'type'      => 'text',
            'default'   => '--',
            'index'     => 'url',
        ));

        parent::_prepareColumns();
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getRuleId()));
    }
}