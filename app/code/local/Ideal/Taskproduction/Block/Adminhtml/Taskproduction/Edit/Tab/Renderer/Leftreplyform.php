<style>
#taskproduction_form .form-list td.label label {  width: 100px; }
.form-list td.label { width: 100px; }
table.grid{ width: 100%; }
table.grid td { border: 1px solid #dadfe0; }
.grid#taskproduction_comment_Grid_table th{ padding: 5px 10px; } 
#taskproduction_comment_Grid_table.grid td { padding: 5px 10px; }
#taskproduction_comment_Grid_table.grid #id_comments_btn { float: left; margin: 10px 0 5px; }
#taskproduction_comment_Grid_table.grid #comments_box { float: left; margin: 10px 0 5px; padding: 7px; }
</style>
<?php
class Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit_Tab_Renderer_Leftreplyform extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {    	
    	//echo "<pre>"; print_r(json_decode($result, true)); echo "</pre>";
    	$ch = curl_init();
    	// Disable SSL verification
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	// Will return the response, if false it print the response
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/task_status_list.php');
    	// Execute
    	$result=curl_exec($ch);
    	// Closing
    	curl_close($ch);
    	//echo "<pre>"; print_r(json_decode($result, true)); exit;
    	
    	//$str = '<div class="mainleftcolumn_replay">';
    	//$str .= '<div class="entry-edit" style="width: 350px;"><div class="entry-edit-head"><h4 class="icon-head head-edit-form">Reply 123</h4></div></div>';
    	$str .= '<table cellspacing="0" id="taskproduction_comment_Grid_table_left_replyform" class="">';
    	/* $str .=	'<thead>';
    	 $str .=	'<tr class="headings">';
    	 $str .= ' <th colspan="2"><span class="nobr"><a class="not-sort" title="asc" name="task_id" href="#"><span class="sort-title">Comments List</span></a></span></th>';
    	 $str .=	'</tr>';
    	 $str .=	'</thead>'; */
    	$str .=	'<tbody>';
    	$str .= '<tr title="title" class="pointer">';
    	$str .= '<td class="a-left" colspan="2">';
    	//$str .= '<form id="comment_form" enctype="multipart/form-data" action="'.Mage::getUrl('taskproduction/adminhtml_taskproduction/insertClientReply').'"  mathod="POST">';
    	$str .= '<input type="hidden" name="task_id" value="'.$id.'" /><textarea width="100%;" name="comments_box" id="comments_box" placeholder="Enter Comment" style="width: 310px; height:245px; "></textarea>';
    	/* $str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />';
    	 $str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />';
    	 $str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />';
    	 $str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />'; */
    	//$str .= '<br /><input type="file" name="comment_img_box" multiple="multiple">';
    	//$str .= '<br /><button style="" class="scalable" type="submit" title="Submit Comments" id="id_comments_btn"><span><span><span>Reply</span></span></span></button>';
    	//$str .= '</form>';
    	$str .= '</td>';
    	$str .= '</tr>';
    	$str .= '<tr title="title" class="pointer statusoption_row">';
	    		$str .= '<td class="a-left" colspan="2">';
	    			$str .= '<label for="statuslabel">Status: </label>';
					$str .= '<select id="status_option">';
						$str .= '<option value="">Please Select</option>';
						foreach(json_decode($result, true) as $statuskey => $statusvalue)
    							{
    							$str .= '<option value='.$statuskey.'>'.$statusvalue.'</option>';
    	}
    	$str .= '</select>';
    			$str .= '</td>';
    	$str .= '</tr>';
    			$str .= '<tr title="title" class="pointer">';
    			$str .= '<td class="a-left" colspan="2">';
    					$str .= '<lable for="attachments">Attachments: </label>';
    			$str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />';
	    		$str .= '</td>';
    		$str .= '</tr>';
    		$str .= '<tr title="title" class="pointer">';
    			$str .= '<td class="a-left" colspan="2">';
	    			$str .= '<button style="" class="scalable" type="submit" title="Submit Comments" id="id_comments_btn"><span><span><span>Add Reply</span></span></span></button>';
	    		$str .= '</td>';
	    	$str .= '</tr>';
    		//echo "<pre>"; print_r(json_decode($result, true)); echo "</pre>"; exit;
    			$str .=	'</tbody>';
    			$str .= '</table>';
    	//$str .= '</div>';
    	return $str;
    }
}