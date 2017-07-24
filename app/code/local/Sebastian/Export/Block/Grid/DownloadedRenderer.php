<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_Block_Grid_DownloadedRenderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract 
{
    public function render(Varien_Object $row)
    {
        return $this->_getEvaluationElement($row);
    }
    
    protected function _getEvaluationElement($row){
        if ($row->getDownloaded() == 0) {
          return $this->__('No');
        } else if ($row->getDownloaded() == 1) {
          return $this->__('Yes');
        }
    }
} 