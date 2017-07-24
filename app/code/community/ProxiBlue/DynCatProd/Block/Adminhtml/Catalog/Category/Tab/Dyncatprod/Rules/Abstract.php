<?php

/**
 * Tab in admin category
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Block_Adminhtml_Catalog_Category_Tab_Dyncatprod_Rules_Abstract
    extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Prepare Layout
     *
     * Creates the form that will contain the rule sets
     *
     * @return void
     */
    public function _prepareLayout()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix($this->_htmlIdPrefix);
        $form->setCategory(Mage::registry('category'));
        $data = array(
            $this->_conditions => $form->getCategory()->getData(
                $this->_attribute_name
            ));
        $ruleModel = Mage::getModel(
            'dyncatprod/rule', array('prefix' => $this->_conditions)
        );
        $ruleModel->preLoadPost(
            $data,
            Mage::registry('category')
        );

        $renderer = Mage::getBlockSingleton(
            'adminhtml/widget_form_renderer_fieldset'
        )
            ->setTemplate('dyncatprod/' . $this->_render_template)
            ->setRawRuleData(
                $form->getCategory()->getData($this->_attribute_name)
            )
            ->setDebugMode(Mage::getStoreConfig('dyncatprod/debug/enabled'))
            ->setNewChildUrl(
                $this->getUrl(
                    '*/promo_rules/newCustomConditionHtml/form/rule_conditions_fieldset/prefix/'
                    . $this->_conditions
                )
            )->setCategoryListUrl(
                $this->getUrl(
                    '*/catalog_category/categoryList'
                )
            );

        $fieldSet = $form->addFieldset(
            $this->_conditions . '_fieldset',
            array(
                'legend' => Mage::helper('dyncatprod')
                    ->__(
                        $this->_fieldset_heading
                    )
            )
        )->setRenderer($renderer);

        $fieldSet->addField(
            $this->_conditions,
            'text',
            array(
                'name' => $this->_conditions,
                'label' => Mage::helper('dyncatprod')->__('Conditions'),
                'title' => Mage::helper('dyncatprod')->__('Conditions'),
            )
        )->setRule($ruleModel)->setRenderer(
            Mage::getBlockSingleton('rule/conditions')
        );

        $this->setForm($form);
    }
}
