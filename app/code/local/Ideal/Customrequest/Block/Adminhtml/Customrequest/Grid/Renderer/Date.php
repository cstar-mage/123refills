<?php 
class Ideal_Diamondrequest_Block_Adminhtml_Diamondrequest_Grid_Renderer_Date extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
 
    public function render(Varien_Object $row) {
            if ($row->getData('day') != NULL && $row->getData('month') != NULL && $row->getData('year') != NULL) {
				$day = $row->getData('day');
		        $month = $row->getData('month');
		        $year = $row->getData('year');
				return $day . '/' . $month .'/' . $year;
	        } else {
        		return Mage::helper('diamondrequest')->__('');
	        }
    }
}
?>