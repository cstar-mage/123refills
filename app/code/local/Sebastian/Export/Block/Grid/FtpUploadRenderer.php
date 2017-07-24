<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_Block_Grid_FtpUploadRenderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract 
{
    public function render(Varien_Object $row)
    {
        return $this->_getEvaluationElement($row);
    }
    
    protected function _getEvaluationElement($row){
        if ($row->getFtpupload() == 0) {
          return $this->__('No');
        } else if ($row->getFtpupload() == 1) {
          return "<font color=\"#00FF00\">".$this->__('Done')."</font>";
        } else if ($row->getFtpupload() == 2) {
          return "<font color=\"#FF0000\">".$this->__('Failed')."</font>";
        }
    }
} 