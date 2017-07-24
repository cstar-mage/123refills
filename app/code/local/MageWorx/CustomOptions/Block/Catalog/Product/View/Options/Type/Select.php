<?php

class MageWorx_CustomOptions_Block_Catalog_Product_View_Options_Type_Select extends Mage_Catalog_Block_Product_View_Options_Type_Select {

    static $isFirstOption = true;

    public function getValuesHtml() {
        $_option = $this->getOption();
        $displayQty = Mage::helper('customoptions')->canDisplayQtyForOptions();
        $hideOutOfStockOptions = Mage::helper('customoptions')->canHideOutOfStockOptions();
        $enabledInventory = Mage::helper('customoptions')->isInventoryEnabled();
        $enabledDependent = Mage::helper('customoptions')->isDependentEnabled();
        
        if (version_compare(Mage::getVersion(), '1.5.0', '>=') && version_compare(Mage::getVersion(), '1.9.0', '<')) {
            $configValue = $this->getProduct()->getPreconfiguredValues()->getData('options/' . $_option->getId());                                                    
        } else {
            $configValue= false;
        }
                

        if ($_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN || $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE) {            
            
            $require = '';
            if ($_option->getIsRequire()) {                
                if ($_option->getIsDependent()) $require = ' required-dependent'; else $require = ' required-entry';
            }
            
            $extraParams = ($enabledDependent && $_option->getIsDependent()?' disabled="disabled"':'');
            $select = $this->getLayout()->createBlock('core/html_select')
                    ->setData(array(
                        'id' => 'select_' . $_option->getId(),
                        'class' => $require . ' product-custom-option'
                    ));
            if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN) {
                $select->setName('options[' . $_option->getid() . ']')
                        ->addOption('', $this->__('-- Please Select --'));
            } else {
                $select->setName('options[' . $_option->getid() . '][]');
                $select->setClass('multiselect' . $require . ' product-custom-option');
            }
            $imagesHtml = '';
            $imagesJs = '';
            $dependentJs = '';
            $defaultFlag = false;
            
            $itemValueCount = count($_option->getValues());
            
            
            foreach ($_option->getValues() as $_value) {                
                $qty = '';

                if ($enabledInventory && $hideOutOfStockOptions && $_value->getCustomoptionsQty() === '0') {
                    continue;
                }

                $selectOptions = array();
                if ($enabledInventory && $_value->getCustomoptionsQty()==='0') {
                    $selectOptions['disabled'] = 'disabled';
                }
                if ($_value->getDefault() == 1 && !isset($selectOptions['disabled']) && !$configValue) {
                    $selectOptions['selected'] = 'selected';
                    if ($enabledDependent) $dependentJs .= 'dependentDefault["select_' . $_option->getId().'"] = '.$_value->getOptionTypeId().';';
                    $defaultFlag = true;
                }

                if ($enabledInventory && $displayQty && $_value->getCustomoptionsQty() !== '') {
                    $qty = ' (' . ($_value->getCustomoptionsQty() > 0 ? $_value->getCustomoptionsQty() : 'Out of stock') . ')';
                }
                
                
                // if more than 50 IMGs
                if ($itemValueCount>50 && $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN) {                
                    if (!$imagesHtml) {
                        $imagesHtml = Mage::helper('customoptions')->getImgHtml($_value->getImagePath(), $_option->getId(), $_value->getOptionTypeId(), true);
                        $imagesJs = 'optionsImagesData['.$_option->getId().'] = [];';
                    }    
                    $arr = Mage::helper('customoptions')->getImgHtml($_value->getImagePath(), $_option->getId(), $_value->getOptionTypeId(), true, true);
                    $imagesJs .= 'optionsImagesData['.$_option->getId().']['.$_value->getOptionTypeId().']=["'.$arr['url'].'", "'.$arr['big_img_url'].'"];';
                } else {
                    $imagesHtml .= Mage::helper('customoptions')->getImgHtml($_value->getImagePath(), $_option->getId(), $_value->getOptionTypeId());
                }    

                $priceStr = $this->_formatPrice(array(
                            'is_percent' => ($_value->getPriceType() == 'percent') ? true : false,
                            'pricing_value' => $_value->getPrice(true)
                                ), false);
                
                if ($enabledDependent) {
                    if ($_value->getDependentIds()) {                    
                        $dependentJs .= 'dependentData['.$_value->getOptionTypeId().'] = ['.$_value->getDependentIds().']; ';
                    }                
                    if ($_value->getInGroupId()) {
                        $dependentJs .= 'inGroupIdData['.$_value->getInGroupId().'] = {"disabled":'.($_option->getIsDependent()?'true':'false').', "select_'.$_option->getId().'":['.$_value->getOptionTypeId().', "'.$this->htmlEscape($_value->getTitle().' '.$priceStr.$qty).'", '.(($enabledInventory && $_value->getCustomoptionsQty()==='0')?'0':'1').']}; ';
                    }
                } 
                
                $select->addOption($_value->getOptionTypeId(), $_value->getTitle() . ' ' . $priceStr . $qty, $selectOptions);
            }
            if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE) {
                $extraParams .= ' multiple="multiple"';
            }
            
            $showImgFunc = '';
            if ($imagesHtml) {
                if ($imagesJs) {
                    $showImgFunc = 'optionsImages.setImage('.$_option->getId().');';
                } else {
                    $showImgFunc = 'optionsImages.showImage('.$_option->getId().');';
                }    
            }    
            
            $select->setExtraParams('onchange="'.(($enabledDependent)?'dependentOptions.select(this);':'')
                .((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();')
                .$showImgFunc.'"'.$extraParams);
            
            if ($configValue) {
                $select->setValue($configValue);
                if ($enabledDependent) $dependentJs .= 'dependentDefault["select_' . $_option->getId().'"] = '.$configValue.';';
            }
            
            if ((count($select->getOptions())>1 && $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN) || (count($select->getOptions())>0 && $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE)) {
                $outHTML = $select->getHtml();
                if ($imagesHtml) {
                    $imagesHtml .= '<script type="text/javascript">'.$imagesJs.'</script>';                    
                    if (Mage::helper('customoptions')->isImagesAboveOptions()) $outHTML = $imagesHtml.$outHTML; else $outHTML .= $imagesHtml;
                }    
                if ($defaultFlag) $outHTML.='<script type="text/javascript">'.$showImgFunc.'</script>';
                if ($dependentJs) $outHTML.='<script type="text/javascript">'.$dependentJs.'</script>';
                return $outHTML;
            }    
        
            
        } elseif ($_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO || $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX) {
            $selectHtml = '';
            $dependentJs = '';
                        
            $require = '';
            if ($_option->getIsRequire()) {                
                if ($_option->getIsDependent()) $require = ' required-dependent'; else $require = ' validate-one-required-by-name';
            }
            
            $arraySign = '';
            switch ($_option->getType()) {
                case Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO:
                    $type = 'radio';
                    $class = 'radio';
                    break;
                case Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX:
                    $type = 'checkbox';
                    $class = 'checkbox';
                    $arraySign = '[]';
                    break;
            }
            $count = 1;
            foreach ($_option->getValues() as $_value) {
                $count++;
                $priceStr = $this->_formatPrice(array(
                            'is_percent' => ($_value->getPriceType() == 'percent') ? true : false,
                            'pricing_value' => $_value->getPrice(true)
                        ));
                $qty = '';
                if ($enabledInventory && $hideOutOfStockOptions && $_value->getCustomoptionsQty() === '0') {
                    continue;
                }
                
                $disabled = ($enabledInventory && $_value->getCustomoptionsQty()==='0') || ($enabledDependent && $_option->getIsDependent()) ? 'disabled="disabled"' : '';

                if ($enabledInventory && $displayQty && $_value->getCustomoptionsQty() !== '') {
                    $qty = ' (' . ($_value->getCustomoptionsQty() > 0 ? $_value->getCustomoptionsQty() : 'Out of stock') . ')';
                }
                                
                if ($disabled && Mage::helper('customoptions')->hideDependentOption()) $selectHtml .= '<li style="display: none;">'; else $selectHtml .= '<li>';
                                
                $selectHtml .= Mage::helper('customoptions')->getImgHtml($_value->getImagePath(), $_option->getId());
                
                if ($configValue) {
                    $htmlValue = $_value->getOptionTypeId();
                    if ($arraySign) {
                        $checked = (is_array($configValue) && in_array($htmlValue, $configValue)) ? 'checked' : '';                        
                    } else {
                        $checked = ($configValue == $htmlValue ? 'checked' : '');
                    }
                } else {
                    $checked = ($_value->getDefault()==1 && !$disabled) ? 'checked' : '';
                }    
                
                if ($enabledDependent) {
                    if ($_value->getDependentIds()) {                    
                        $dependentJs .= 'dependentData['.$_value->getOptionTypeId().'] = ['.$_value->getDependentIds().']; ';
                    }                
                    if ($_value->getInGroupId() && !($enabledInventory && $_value->getCustomoptionsQty()==='0')) {
                        $dependentJs .= 'inGroupIdData['.$_value->getInGroupId().'] = {"disabled":'.($_option->getIsDependent()?'true':'false').', "options_'.$_option->getId().'_'.$count.'":1}; ';
                    }
                    if ($checked) $dependentJs .= 'dependentDefault["options_' . $_option->getId() . '_' . $count . '"] = 1;';
                }                
                if (Mage::helper('customoptions')->isQntyInputEnabled() && $_option->getQntyInput() && $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX) {
                    $selectHtml .=
                        '<input ' . $disabled . ' ' . $checked . ' type="' . $type . '" class="' . $class . ' ' . $require . ' product-custom-option" onclick="$(\'options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty\').disabled=!this.checked; if ($(\'options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty\').value<=0) $(\'options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty\').value=1; '.(($enabledDependent)?'dependentOptions.select(this);':'').((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();').'" name="options[' . $_option->getId() . ']' . $arraySign . '" id="options_' . $_option->getId() . '_' . $count . '" value="' . $_value->getOptionTypeId() . '" />' .
                        '<span class="label">
                            <label for="options_' . $_option->getId() . '_' . $count . '">' . $_value->getTitle() . ' ' . $priceStr . $qty . '</label>
                            &nbsp;&nbsp;&nbsp;
                            <label><b>'.Mage::helper('sales')->__('Qty').':</b> <input type="text" class="input-text qty validate-greater-than-zero" title="'.Mage::helper('sales')->__('Qty').'" value="1" maxlength="12" id="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" name="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" onchange="'.((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();').'" '.($checked?$disabled:'disabled').'></label>
                         </span>';
                } else {
                    $selectHtml .=
                        '<input ' . $disabled . ' ' . $checked . ' type="' . $type . '" class="' . $class . ' ' . $require . ' product-custom-option" onclick="'.(($enabledDependent)?'dependentOptions.select(this);':'').((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();').'" name="options[' . $_option->getId() . ']' . $arraySign . '" id="options_' . $_option->getId() . '_' . $count . '" value="' . $_value->getOptionTypeId() . '" />' .
                        '<span class="label"><label for="options_' . $_option->getId() . '_' . $count . '">' . $_value->getTitle() . ' ' . $priceStr . $qty . '</label></span>';
                }
                                                
                if ($_option->getIsRequire()) {
                    $selectHtml .= '<script type="text/javascript">' .
                            '$(\'options_' . $_option->getId() . '_' . $count . '\').advaiceContainer = \'options-' . $_option->getId() . '-container\';' .
                            '$(\'options_' . $_option->getId() . '_' . $count . '\').callbackFunction = \'validateOptionsCallback\';' .
                            '</script>';
                }
                $selectHtml .= '</li>';
            }
            
            if ($selectHtml) $selectHtml = '<ul id="options-' . $_option->getId() . '-list" class="options-list">'.$selectHtml.'</ul>';
            self::$isFirstOption = false;
            
            if ($dependentJs) $selectHtml.='<script type="text/javascript">'.$dependentJs.'</script>';
            
            return $selectHtml;
        }
    }

}
