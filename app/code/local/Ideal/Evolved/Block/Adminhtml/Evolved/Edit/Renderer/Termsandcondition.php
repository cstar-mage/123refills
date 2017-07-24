<script>
var jq = jQuery.noConflict();
jq(window).load(function(){
	jq("#addnewtermsandcondition").click(function(){
		//alert(jq(".termscondition_cls .cms_form" ).length);
		var lenght = jq(".termscondition_cls .cms_form" ).length + 1;
		//alert(lenght);
		var str1 ='<table cellspacing="0" class="form-list cms_form" id="termsandcondition_form_' + lenght + '"><tbody><tr>';		
		str1 += '<td class="label"><input type="hidden" class=" input-text" value="'+ lenght + '" name="evolved_homepage_termsandcondition[termsandcondition_form_' + lenght + '_id]" id="termsandcondition_form_' + lenght + '_id"><label for="termsandcondition_form_' + lenght + '_sort_order_label" style="margin-bottom: 10px; width: 110px;">Sort Order</label>';
		str1 += '<input type="text" class=" input-text" value="" name="evolved_homepage_termsandcondition[termsandcondition_form_' + lenght + '_sort_order]" id="termsandcondition_form_' + lenght + '_sort_order">';
		str1 += '</td>';
		str1 += '<td class="value">';
		str1 += '<label for="termsandcondition_form_' + lenght + '_title_label" style="margin-bottom: 10px; width: 110px; display: block;">Title</label>';
		str1 += '<input type="text" class=" input-text" value="" name="evolved_homepage_termsandcondition[termsandcondition_form_' + lenght + '_title]" id="termsandcondition_form_' + lenght + '_title">';
		str1 += '</td>';
		str1 += '<td class="label">';
		//str1 += '<input type="button" value="Delete" name="termsandcondition_form_' + lenght + '_delete" id="termsandcondition_form_' + lenght + '_delete" class="termsandcondition_delete" onclick=javascript:delete_fn("termsandcondition_form_' + lenght + '")>';
		str1 += '<button class="scalable delete termsandcondition_delete" type="button" name="evolved_homepage_termsandcondition[termsandcondition_form_' + lenght + '_delete]" title="Delete" id="termsandcondition_form_' + lenght + '_delete" onclick=javascript:delete_fn("termsandcondition_form_' + lenght + '")><span><span><span>Delete</span></span></span></button>';
		str1 += '</td>';
		str1 += '</tr>';
		str1 += '<tr>';
		str1 += '<td class="label" colspan="3"><label for="termsandcondition_form_' + lenght + '_description_label" style="margin-bottom: 10px; width: 110px;">Description</label>';
		str1 += '<textarea class=" textarea" cols="15" rows="2" name="evolved_homepage_termsandcondition[termsandcondition_form_' + lenght + '_description]" id="termsandcondition_form_' + lenght + '_description" style="height: 150px; width: 560px; "></textarea>';
		str1 += '</td>';
		str1 += '</tr>';
		str1 += '</tbody>';
		str1 += '</table>';

		//alert(str1);
		//var n = str1;
		//alert(jq("#termsandcondition_form_1" ).length;
		jq(".termscondition_cls").append(str1);
	});
	
});
function delete_fn(formid) {
    //alert(str);
    jq( "#" + formid ).remove();
}
</script>
<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Termsandcondition extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
    	$model = Mage::getModel('evolved/evolved');
    	$collection = $model->getCollection();
    	$collection->addFieldToFilter('field', array('like' => 'termsandcondition_form_%'));
    	//echo "<pre>";
    	//print_r($collection->getData());
    	$theme = array();
    	foreach($collection as $row)
    	{
    		$lastrow = $row->getData('field');
    		$theme[$row->getData('field')] = $row->getData('value');
    	}
    	$lastrow = explode("_",$lastrow);
    	//echo $lastrow[2];
    	/*echo "<pre>";
    	print_r($theme);
    	echo "</pre>";*/
    	//exit;
        // Get the default HTML for this option
        //$html = parent::getHtml();
        
    	$html .= '<table cellspacing="0" class="form-list cms_form_new" id="termsandcondition_form_new">';
    	$html .= '<tbody>';
    	$html .= '<tr>';
    	$html .= '<td>';
    	$html .= '<input type="hidden" name="evolved_homepage_termsandcondition[termsandcondition_hidden]" value="1">';
    	//$html .= '<input type="button" name="addnewtermsandcondition" id="addnewtermsandcondition" value="Add New" />';
    	$html .= '<button style="" onclick="" class="scalable add" type="button" name="evolved_homepage_termsandcondition[addnewtermsandcondition]" title="Add New Terms and Conditions" id="addnewtermsandcondition"><span><span><span>Add New</span></span></span></button>';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '</tbody>';
    	$html .= '</table>';
    	
    	$html .= '<div class="termscondition_cls">';
    	
    	for($count = 1; $count <= $lastrow[2]; $count++)
    	{
    		$termsandcondition_form_id = $theme['termsandcondition_form_'.$count.'_id'];
    		$termsandcondition_form_sort_order = $theme['termsandcondition_form_'.$count.'_sort_order'];
    		$termsandcondition_form_title = $theme['termsandcondition_form_'.$count.'_title'];
    		$termsandcondition_form_description = $theme['termsandcondition_form_'.$count.'_description'];
    		if(($termsandcondition_form_id == "") && ($termsandcondition_form_sort_order == "") && ($termsandcondition_form_title == "") && ($termsandcondition_form_description == ""))
    		{
    			continue;
    		}
    		
    		$html .= '<table cellspacing="0" class="form-list cms_form" id="termsandcondition_form_'.$count.'"><tbody><tr>';
    		$html .= '<td class="label"><input type="hidden" class=" input-text" value="'.$termsandcondition_form_id.'" name="evolved_homepage_termsandcondition[termsandcondition_form_'.$count.'_id]" id="termsandcondition_form_'.$count.'_id"><label for="termsandcondition_form_'.$count.'_sort_order_label" style="margin-bottom: 10px; width: 110px;">Sort Order</label>';
    		$html .= '<input type="text" class=" input-text" value="'.$termsandcondition_form_sort_order.'" name="evolved_homepage_termsandcondition[termsandcondition_form_'.$count.'_sort_order]" id="termsandcondition_form_'.$count.'_sort_order">';
    		$html .= '</td>';
    		$html .= '<td class="value">';
    		$html .= '<label for="termsandcondition_form_'.$count.'_title_label" style="margin-bottom: 10px; width: 110px; display: block;">Title</label>';
    		$html .= '<input type="text" class=" input-text" value="'.$termsandcondition_form_title.'" name="evolved_homepage_termsandcondition[termsandcondition_form_'.$count.'_title]" id="termsandcondition_form_'.$count.'_title">';
    		$html .= '</td>';
    		$html .= '<td class="label">';
    		//$html .= '<input type="button" value="Delete" name="termsandcondition_form_'.$count.'_delete" id="termsandcondition_form_'.$count.'_delete" class="termsandcondition_delete" onclick=javascript:delete_fn("termsandcondition_form_'.$count.'")>';
    		$html .= '<button class="scalable delete termsandcondition_delete" type="button" name="evolved_homepage_termsandcondition[termsandcondition_form_'.$count.'_delete]" title="Delete" id="termsandcondition_form_'.$count.'_delete" onclick=javascript:delete_fn("termsandcondition_form_'.$count.'")><span><span><span>Delete</span></span></span></button>';
    		$html .= '</td>';
    		$html .= '</tr>';
    		$html .= '<tr>';
    		$html .= '<td class="label" colspan="3"><label for="termsandcondition_form_'.$count.'_description_label" style="margin-bottom: 10px; width: 110px;">Description</label>';
    		$html .= '<textarea class=" textarea" cols="15" rows="2" name="evolved_homepage_termsandcondition[termsandcondition_form_'.$count.'_description]" id="termsandcondition_form_'.$count.'_description" style="height: 150px; width: 560px; ">'.$termsandcondition_form_description.'</textarea>';
    		$html .= '</td>';
    		$html .= '</tr>';
    		$html .= '</tbody>';
    		$html .= '</table>';
    		
    	}
    	/*
    	$html .= '<table cellspacing="0" class="form-list cms_form" id="termsandcondition_form_1" style="display: table-cell;">';
    	$html .= '<tbody>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><input type="hidden" class=" input-text" value="" name="termsandcondition_form_1_id" id="termsandcondition_form_1_id"><label for="termsandcondition_form_1_sort_order_label" style="margin-bottom: 10px; width: 110px;">Sort Order</label>';
    	$html .= '<input type="text" class=" input-text" value="" name="termsandcondition_form_1_sort_order" id="termsandcondition_form_1_sort_order"></td>';
    	$html .= '<td class="value">';
    	$html .= '<label for="termsandcondition_form_1_title_label" style="margin-bottom: 10px; width: 110px; display: block;">Title</label>';
    	$html .= '<input type="text" class=" input-text" value="" name="termsandcondition_form_1_title" id="termsandcondition_form_1_title">';
    	$html .= '</td>';
    	$html .= '<td class="label">';
    	$html .= '<input type="button"  value="Delete" name="termsandcondition_form_1_delete" id="termsandcondition_form_1_delete">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label" colspan="3"><label for="termsandcondition_form_1_description_label" style="margin-bottom: 10px; width: 110px;">Description</label>';
    	$html .= '<textarea class=" textarea" cols="15" rows="2" name="termsandcondition_form_1_description" id="termsandcondition_form_1_description" style="height: 150px;
    width: 560px; "></textarea>';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '</tbody>';
    	$html .= '</table>';
    	*/
    	$html .= '</div>';
    	
    	return $html;
        
    }
}