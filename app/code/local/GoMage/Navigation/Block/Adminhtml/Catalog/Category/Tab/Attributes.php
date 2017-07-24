<?php
 /**
 * GoMage Advanced Navigation Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2011 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 2.1
 * @since        Class available since Release 1.0
 */

class GoMage_Navigation_Block_Adminhtml_Catalog_Category_Tab_Attributes extends Mage_Adminhtml_Block_Catalog_Category_Tab_Attributes
{
    
    protected function _prepareForm() {
        
                        
        parent::_prepareForm();
        
        $hidde_elements = array();

        
        if ($category = $this->getCategory())
        {
           if ($category->getLevel() != 3)
           { 
              $hidde_elements[] = 'navigation_column';               
           }   
           if ($category->getLevel() == 2)
           {               
              $hidde_elements[] = 'navigation_column_side';
           } 
           if ($category->getLevel() != 2)
           { 
              $hidde_elements = array_merge($hidde_elements, 
                       array('navigation_pw_width',
                             'navigation_image',
                             'navigation_image_position',
                             'navigation_image_width',
                             'navigation_image_height'));
           }
           
           if (($category->getLevel() > 3) || (!$category->getLevel()))
           {
              $hidde_elements[] = 'navigation_label_menubar';               
           }   
           
        }   


        foreach ($hidde_elements as $value)
        { 
              if ($element = $this->getForm()->getElement($value))
              {
                  $element->setDisabled(true);
                  $element->setStyle('display:none;');
                  $element->setType('hidden');
              }
        }
        
        
        
    } 
       
}
