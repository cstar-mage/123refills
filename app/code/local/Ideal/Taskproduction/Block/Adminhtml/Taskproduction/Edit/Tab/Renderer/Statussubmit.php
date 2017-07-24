<script>
function submitstatus_fn()
{
	//alert(document.getElementById("task_status").value);
	window.location.href = "<?php echo Mage::getUrl(); ?>taskproduction/adminhtml_taskproduction/submitStatus?statuscode="+document.getElementById("task_status").value+"&task_id="+document.getElementById("taskcode").value;
}
</script>
<style>
#taskproduction_status_Grid_table {
	background: #fafafa none repeat scroll 0 0;
    float: left;
    margin-left: 123px;
    width: 77px;
}
</style>
<?php
class Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit_Tab_Renderer_Statussubmit extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {    	
    	$id = Mage::app()->getRequest()->getParam('task_id');
    	//echo "<pre>"; print_r(json_decode($result, true)); echo "</pre>";
    	$str = '<table cellspacing="0" id="taskproduction_status_Grid_table" class="data grid form-list">';
    		//echo "<pre>"; print_r($userlistarr); echo "</pre>";
    		$str .=	'<tr class="">';
    		$str .= ' <th colspan="2"><input type="hidden" id="taskcode" value="'.Mage::app()->getRequest()->getParam('task_id').'" /><button id="id_submit_status" title="Submit Comments" type="button" class="scalable " style="" onClick="submitstatus_fn();"><span><span><span>Submit</span></span></span></button></th>';
    		$str .=	'</tr>';
    		$str .=	'</tbody>';
    	$str .= '</table>';
    	return $str;
    }
}