<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Testimonials extends Varien_Data_Form_Element_Text
{
	public function getHtml()
	{
    	$baseurl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$siteurl = str_replace("/index.php/","/",$baseurl);
		$elementonemodel = Mage::getModel('evolved/evolved');
		$elementtestimonialscollection = $elementonemodel->getCollection();
		$elementtestimonialscollection->addFieldToFilter('field', array('like' => 'testimonials_element_style'));
		foreach($elementtestimonialscollection as $elementtestimonialscollection1)
		{
			$selectElement = $elementtestimonialscollection1['value'];
			//$selectElement = $elementtestimonialscollection1['field'];
		}
		
		$testimonialselementmodeldata = Mage::getModel('evolved/evolved');
		$testimonialselementcollectiondata = $testimonialselementmodeldata->getCollection();
		$testimonialselementcollectiondata->addFieldToFilter('field', array('like' => 'testimonials_element_style_%'));
		foreach ($testimonialselementcollectiondata as $testimonialselementcollectiondata1)
		{
			//    		echo $collection_arr['field']."   value: ".$collection_arr['value']."<br />";
			$collectiondata[$testimonialselementcollectiondata1['field']] = $testimonialselementcollectiondata1['value'];
		}
		//echo "<pre>"; print_r($collectiondata); echo "</pre>";
		
		//return $selectElement;
		$str = '<tr>';
		$str .= '<td colspan="0">';
//		if($selectElement == "testimonials_element_style_one_one_column")
		{
			$str .= ($selectElement == "testimonials_element_style_one_one_column") ? '<table cellspacing="0" class="form-list testimonialsmaintable" id="testimonials_element_style_one_one_column" style="display: block;">' : '<table cellspacing="0" class="form-list testimonialsmaintable" id="testimonials_element_style_one_one_column" style="display: none;">';
			//$str = '<table cellspacing="0" class="form-list">';
				$str .= '<tbody>';
					$str .= '<tr>';
						$str .= '<td class="label"><label for="testimonials_element_style_one_page_title">Page Title:</label></td>';
						$str .= '<td class="value">';
						$str .= '<input type="text" id="testimonials_element_style_one_page_title" name="testimonials_element_style_one_page_title" value="'.$collectiondata['testimonials_element_style_one_page_title'].'" class=" input-text">';
						$str .= '</td>';
					$str .= '</tr>';
					$str .= '<tr>';
						$str .= '<td class="label"><label for="testimonials_element_style_one_page_sub_title">Page Sub-Title:</label></td>';
						$str .= '<td class="value">';
						$str .= '<input type="text" id="testimonials_element_style_one_page_sub_title" name="testimonials_element_style_one_page_sub_title" value="'.$collectiondata['testimonials_element_style_one_page_sub_title'].'" class=" input-text">';
						$str .= '</td>';
					$str .= '</tr>';
					$str .= '<tr>';
						$str .= '<td class="label"><label for="testimonials_element_style_one_upload_banner">Upload Banner:</label></td>';
						$str .= '<td class="value">';
						if($collectiondata['testimonials_element_style_one_upload_banner'])
						{
							$str .= '<a href="/media/'.$collectiondata['testimonials_element_style_one_upload_banner'].'" onclick="imagePreview(\'testimonials_element_style_one_upload_banner\'); return false;"><img width="22" height="22" src="/media/'.$collectiondata['testimonials_element_style_one_upload_banner'].'" id="testimonials_element_style_one_upload_banner" title="'.$collectiondata['testimonials_element_style_one_upload_banner'].'" alt="'.$collectiondata['testimonials_element_style_one_upload_banner'].'" class="small-image-preview v-middle"></a>';
						}
						$str .= '<input type="file" class="input-file" value="'.$collectiondata['testimonials_element_style_one_upload_banner'].'" name="testimonials_element_style_one_upload_banner" id="testimonials_element_style_one_upload_banner">';
						if($collectiondata['testimonials_element_style_one_upload_banner'])
						{
							$str .= '<span class="delete-image"><input type="checkbox" id="testimonials_element_style_one_upload_banner_delete" class="checkbox" value="1" name="testimonials_element_style_one_upload_banner[delete]"><label for="testimonials_element_style_one_upload_banner_delete"> Delete Image</label><input type="hidden" value="'.$collectiondata['testimonials_element_style_one_upload_banner'].'" name="testimonials_element_style_one_upload_banner[value]"></span>';
						}						
						$str .= '</td>';
					$str .= '</tr>';
					$str .= '<tr>';
						$str .= '<td class="label"><label for="testimonials_element_style_one_current_banner">Current Banner:</label></td>';
						$str .= '<td class="value">';
						$str .= '<img src="'."/media/".$collectiondata['testimonials_element_style_one_upload_banner'].'" name="testimonials_element_style_one_current_banner" id="testimonials_element_style_one_current_banner" width="300px" height="100px" />';
						$str .= '</td>';
					$str .= '</tr>';
				$str .= '</tbody>';
			$str .= '</table>';
		}
	//	elseif($selectElement == "testimonials_element_style_two_two_column_with_50_by_50")
		{
			$str .= ($selectElement == "testimonials_element_style_two_two_column_with_50_by_50") ? '<table cellspacing="0" class="form-list testimonialsmaintable" id="testimonials_element_style_two_two_column_with_50_by_50" style="display: block;">' : '<table cellspacing="0" class="form-list testimonialsmaintable" id="testimonials_element_style_two_two_column_with_50_by_50" style="display: none;">';
			//$str .= '<table cellspacing="0" class="form-list">';
				$str .= '<tbody>';
					$str .= '<tr>';
						$str .= '<td>';
							$str .= '<table cellspacing="0" class="form-list">';
								$str .= '<tbody>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="testimonials_element_style_two_page_title">Page Title:</label></td>';
										$str .= '<td class="value">';
										$str .= '<input type="text" id="testimonials_element_style_two_page_title" name="testimonials_element_style_two_page_title" value="'.$collectiondata['testimonials_element_style_two_page_title'].'" class=" input-text">';
										$str .= '</td>';
									$str .= '</tr>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="testimonials_element_style_two_page_sub_title">Page Sub-Title:</label></td>';
										$str .= '<td class="value">';
										$str .= '<input type="text" id="testimonials_element_style_two_page_sub_title" name="testimonials_element_style_two_page_sub_title" value="'.$collectiondata['testimonials_element_style_two_page_sub_title'].'" class=" input-text">';
										$str .= '</td>';
									$str .= '</tr>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="testimonials_element_style_two_upload_banner">Upload Banner:</label></td>';
										$str .= '<td class="value">';
										if($collectiondata['testimonials_element_style_two_upload_banner'])
										{
											$str .= '<a href="/media/'.$collectiondata['testimonials_element_style_two_upload_banner'].'" onclick="imagePreview(\'testimonials_element_style_two_upload_banner\'); return false;"><img width="22" height="22" src="/media/'.$collectiondata['testimonials_element_style_two_upload_banner'].'" id="testimonials_element_style_two_upload_banner" title="'.$collectiondata['testimonials_element_style_two_upload_banner'].'" alt="'.$collectiondata['testimonials_element_style_two_upload_banner'].'" class="small-image-preview v-middle"></a>';
										}
										$str .= '<input type="file" class="input-file" value="'.$collectiondata['testimonials_element_style_two_upload_banner'].'" name="testimonials_element_style_two_upload_banner" id="testimonials_element_style_two_upload_banner">';
										if($collectiondata['testimonials_element_style_two_upload_banner'])
										{
											$str .= '<span class="delete-image"><input type="checkbox" id="testimonials_element_style_two_upload_banner_delete" class="checkbox" value="1" name="testimonials_element_style_two_upload_banner[delete]"><label for="testimonials_element_style_two_upload_banner_delete"> Delete Image</label><input type="hidden" value="'.$collectiondata['testimonials_element_style_two_upload_banner'].'" name="testimonials_element_style_two_upload_banner[value]"></span>';
										}
										$str .= '</td>';
										$str .= '</td>';
									$str .= '</tr>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="testimonials_element_style_two_current_banner">Current Banner:</label></td>';
										$str .= '<td class="value">';
										$str .= '<img src="'."/media/".$collectiondata['testimonials_element_style_two_upload_banner'].'" name="testimonials_element_style_two_current_banner" id="testimonials_element_style_two_current_banner" width="300px" height="100px" />';
										$str .= '</td>';
									$str .= '</tr>';
								$str .= '</tbody>';
							$str .= '</table>';
						$str .= '</td>';
					$str .= '</tr>';
				$str .= '</tbody>';
			$str .= '</table>';		
		}
		$str .= '</td>';
		$str .= '</tr>';
		return $str;
	}
}