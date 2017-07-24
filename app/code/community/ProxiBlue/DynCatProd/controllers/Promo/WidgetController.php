<?php
/**
 * Widget Controller - Makes the Chooser work
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
require_once "Mage/Adminhtml/controllers/Promo/WidgetController.php";

class ProxiBlue_DynCatProd_Promo_WidgetController
    extends Mage_Adminhtml_Promo_WidgetController
{

    /**
     * Prepare block for chooser
     *
     * @return void
     */
    public function chooserAction()
    {
        $request = $this->getRequest();

        switch ($request->getParam('attribute')) {

            case 'category_child':
                $ids = $request->getParam('selected', array());
                if (is_array($ids)) {
                    foreach ($ids as $key => &$id) {
                        $id = (int)$id;
                        if ($id <= 0) {
                            unset($ids[$key]);
                        }
                    }

                    $ids = array_unique($ids);
                } else {
                    $ids = array();
                }

                $block = $this->getLayout()->createBlock(
                    'adminhtml/catalog_category_checkboxes_tree',
                    'promo_widget_chooser_category_ids',
                    array('js_form_object' => $request->getParam('form'))
                )
                    ->setCategoryIds($ids);
                break;
            case 'applied_catalog_rule_id':
                $block = $this->getLayout()->createBlock(
                    'dyncatprod/adminhtml_promo_widget_chooser_rules',
                    'promo_widget_chooser_rules',
                    array('js_form_object' => $request->getParam('form'),
                    )
                );
                break;
            default:
                $block = false;
                parent::chooserAction();
                break;
        }

        if ($block) {
            $this->getResponse()->setBody($block->toHtml());
        }
    }
}
