<?php
/**
 * Rules Controller
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
require_once "Mage/Adminhtml/controllers/Promo/QuoteController.php";

class ProxiBlue_DynCatProd_Promo_RulesController
    extends Mage_Adminhtml_Promo_QuoteController
{

    public function newCustomConditionHtmlAction()
    {
        $id = $this->getRequest()->getParam('id');
        $typeArr = explode(
            '|', str_replace('-', '/', $this->getRequest()->getParam('type'))
        );
        $type = $typeArr[0];
        $prefix = ($this->getRequest()->getParam('prefix')) ? $this->getRequest()->getParam('prefix') : 'conditions';

        $model = Mage::getModel($type, array('prefix' => $prefix))
            ->setId($id)
            ->setType($type)
            ->setRule(Mage::getModel('salesrule/rule'))
            ->setPrefix($prefix);
        if (!empty($typeArr[1])) {
            $model->setAttribute($typeArr[1]);
        }

        if ($model instanceof Mage_Rule_Model_Condition_Abstract) {
            //$model->setConditions($model->getData('conditions'));
            $model->setJsFormObject($this->getRequest()->getParam('form'));
            $html = $model->asHtmlRecursive();
        } else {
            $html = '';
        }
        $this->getResponse()->setBody($html);
    }

    /**
     * Returns result of current user permission check on resource and privilege
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed(
            'catalog/categories'
        );
    }

    public function copyrulesAction()
    {
        $params['_current'] = true;
        $category = mage::getModel('catalog/category')->load($this->getRequest()->getParam('currentCat'));

        if (!$category->getId()) {
            return;
        }

        $copyFrom = mage::getModel('catalog/category')->load($this->getRequest()->getParam('copyFrom'));
        $category->setDynamicAttributes($copyFrom->getDynamicAttributes());
        $category->save();



    }


}
