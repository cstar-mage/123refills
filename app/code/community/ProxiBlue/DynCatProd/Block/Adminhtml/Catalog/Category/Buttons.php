<?php

class ProxiBlue_DynCatProd_Block_Adminhtml_Catalog_Category_Buttons
    extends Mage_Adminhtml_Block_Catalog_Category_Abstract
{

    /**
     * Add buttons on category edit page
     *
     * @return ProxiBlue_DynCatProd_Block_Adminhtml_Catalog_Category_Buttons
     */
    public function addButtons()
    {
        if ($this->getCategoryId()) {

            if (mage::getStoreConfig('dyncatprod/rebuild/flip_save_rebuild')) {
                $this->getParentBlock()->getChild('form')
                    ->addAdditionalButton(
                        'dyncatprod_save', array(
                            'label'   => $this->helper('dyncatprod')->__('Save, and rebuild dynamic rules'),
                            'class'   => 'save',
                            'title'   => 'Save the category, and rebuild dynamic rules',
                            'onclick' => "$('category_edit_form').insert(new Element('input',{name: 'force_build',value: 1, type: 'text'})); categorySubmit('"
                                . $this->getSaveUrl() . "',true)"
                        )
                    );
            } else {
                $this->getParentBlock()->getChild('form')
                    ->addAdditionalButton(
                        'dyncatprod_save', array(
                            'label'   => $this->helper('dyncatprod')->__('Save, skip dynamic rebuild'),
                            'class'   => 'save',
                            'title'   => 'Save the category, do not rebuild dynamic products',
                            'onclick' => "$('category_edit_form').insert(new Element('input',{name: 'skip_build',value: 1, type: 'text'})); categorySubmit('"
                                . $this->getSaveUrl() . "',true)"
                        )
                    );
            }
        }

        return $this;
    }
}
