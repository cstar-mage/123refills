<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Testimonialscurrentimage extends Varien_Data_Form_Element_Text
{
	public function getHtml()
	{

		$testimonialselementmodeldata = Mage::getModel('evolved/evolved');
		$testimonialselementcollectiondata = $testimonialselementmodeldata->getCollection();
		$testimonialselementcollectiondata->addFieldToFilter('field', array('like' => 'testimonials_page_upload_banner'));
		foreach ($testimonialselementcollectiondata as $testimonialselementcollectiondata1)
		{
			//    		echo $collection_arr['field']."   value: ".$collection_arr['value']."<br />";
			$collectiondata[$testimonialselementcollectiondata1['field']] = $testimonialselementcollectiondata1['value'];
		}
		//return $selectElement;
		if($collectiondata['testimonials_page_upload_banner'])
		{
			$str = '<tr>';
			$str .= '<td class="label"><label for="testimonials_page_current_banner">Current Banner:</label></td>';
			$str .= '<td class="value">';
			$str .= '<img width="300px" height="100px" id="testimonials_page_current_banner" name="testimonials_page_current_banner" src="/media/'.$collectiondata['testimonials_page_upload_banner'].'">';
			$str .= '</td>';
			$str .= '</tr>';
			return $str;
		}
	}
}