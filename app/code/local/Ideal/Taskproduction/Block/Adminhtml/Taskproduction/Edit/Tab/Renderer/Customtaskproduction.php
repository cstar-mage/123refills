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
class Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit_Tab_Renderer_Customtaskproduction extends Varien_Data_Form_Element_Text
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
    	$ch = curl_init();
    	// Disable SSL verification
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	// Will return the response, if false it print the response
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	// Set the parameter
    	curl_setopt($ch, CURLOPT_POSTFIELDS, 'task_id='.$id."&siteurl=".str_replace("www.","",$_SERVER['HTTP_HOST']));
    	// Set the url
    	curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/taskcomment.php');
    	// Execute
    	$result=curl_exec($ch);
    	// Closing
    	curl_close($ch);
    	//echo "<pre>"; print_r(json_decode($result, true)); echo "</pre>";
    		
    	$str = '<table cellspacing="0" id="taskproduction_comment_Grid_table" class="data grid">';
    		$str .=	'<thead>';
	    		$str .=	'<tr class="headings">';
	    			$str .= ' <th colspan="2"><span class="nobr"><a class="not-sort" title="asc" name="task_id" href="#"><span class="sort-title">Comments List</span></a></span></th>';
	    		$str .=	'</tr>';
    		$str .=	'</thead>';
    		$str .=	'<tbody>';
    		$str .= '<tr title="title" class="pointer">';
    			$str .= '<td class="a-left" colspan="2">';
    				//$str .= '<form id="comment_form" enctype="multipart/form-data" action="'.Mage::getUrl('taskproduction/adminhtml_taskproduction/insertClientReply').'"  mathod="POST">';
    					$str .= '<input type="hidden" name="task_id" value="'.$id.'" /><textarea width="100%;" name="comments_box" id="comments_box" placeholder="Enter Comment" style="width: 98.5%; "></textarea>';
     					$str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />';
    					$str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />';
    					$str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />';
    					$str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />';
    					$str .= '<br /><input type="file" name="comment_img_box[]" id="comment_img_box[]" />';
    					//$str .= '<br /><input type="file" name="comment_img_box" multiple="multiple">';
    					$str .= '<br /><button style="" class="scalable" type="submit" title="Submit Comments" id="id_comments_btn"><span><span><span>Reply</span></span></span></button>';
    				//$str .= '</form>';
    			$str .= '</td>';
    		$str .= '</tr>';
    		//echo "<pre>"; print_r(json_decode($result, true)); echo "</pre>"; exit;
    		
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/userlist.php');
    		$resultuser=curl_exec($ch);
    		curl_close($ch);    		
    		$userlistarr = json_decode($resultuser, true);
    		
    		
    		$chcomntmnger = curl_init();
    		curl_setopt($chcomntmnger, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($chcomntmnger, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, 'siteurl='.str_replace("www.","",$_SERVER['HTTP_HOST']));
    		curl_setopt($chcomntmnger, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/comment_mng_list.php');
    		$resultcomntmnger=curl_exec($chcomntmnger);
    		curl_close($chcomntmnger);
    		$resultcomntmngerdata = json_decode($resultcomntmnger, true);
    		$managername = ($resultcomntmngerdata[0]['default_manager']) ? ($resultcomntmngerdata[0]['default_manager']) : 'Jigar'; 
    		//echo $managername; exit;
    		//echo $resultcomntmngerdata[0]['default_manager']; exit;
    		//echo "<pre>"; print_r($resultcomntmngerdata); exit;
    		
    		//
    		//echo "<pre>"; echo str_replace('www.','',$_SERVER['HTTP_HOST']); exit;
    		$userlistarr[0] = Mage::getStoreConfig('general/store_information/name');
    		//echo "<pre>"; print_r($userlistarr); echo "</pre>";
    		$str .=	'<tr class="headings">';
    		$str .= ' <th style="width: 120px; "><span class="nobr"><a class="not-sort" title="asc" name="task_id" href="#"><span class="sort-title">User</span></a></span></th>';
    		$str .= ' <th><span class="nobr"><a class="not-sort" title="asc" name="task_id" href="#"><span class="sort-title">Comments</span></a></span></th>';
    		$str .=	'</tr>';
    		$i=1;
    		//echo "<pre>"; print_r(json_decode($result, true)); exit;
    		foreach(json_decode($result, true) as $resultkey => $resultvalue)
    		{
    			//echo "<pre>"; print_r(unserialize($resultvalue['note_image'])); echo "</pre>";
    			//if($resultvalue['notes'])
    			if(($resultvalue['notes']) || (unserialize($resultvalue['note_image'])))
    			{
    				//$str .= '<tr title="title '.$i.'" class="pointer">'; $i++;
    				//if($resultvalue['user_author']==0)
    				{
    					if(($resultvalue['askto'] == 0) && (($resultvalue['asktoclient'] != null) || ($resultvalue['asktoclient'] != 0)))
	    				{ 
	    					$str .= '<tr title="title '.$i.'" class="pointer">'; $i++;
	    					$str .= '<td class="a-left " style="width: 120px; ">'.$managername.'</td>'; 
	    					$str .= '<td class="a-left ">';
	    					$str .= $resultvalue['notes'];
	    					if($resultvalue['note_image']) {
	    						foreach(unserialize($resultvalue['note_image']) as $note_image_all)
	    						{
	    							$str .= '<br /><a href="http://production.idealbrandmarketing.com/uploads/task_notes/'.$id.'/'.$note_image_all.'" target="_blank"><img src="http://production.idealbrandmarketing.com/uploads/task_notes/'.$id.'/'.$note_image_all.'" style="max-width:250px; " /></a>';
	    						}
	    					}
	    					$str .= '</td>';
	    					$str .= '</tr>';
	    				}
    				}
    				/* else 
    				{ 
    					$str .= '<td class="a-left " style="width: 120px; "></td>'; 
    				} */
/*     				$str .= '<td class="a-left ">';
    				$str .= $resultvalue['notes'];
    				if($resultvalue['note_image']) {
    					foreach(unserialize($resultvalue['note_image']) as $note_image_all)
    					{
    						$str .= '<br /><a href="http://production.idealbrandmarketing.com/uploads/task_notes/'.$id.'/'.$note_image_all.'" target="_blank"><img src="http://production.idealbrandmarketing.com/uploads/task_notes/'.$id.'/'.$note_image_all.'" style="max-width:250px; " /></a>';
    					}
    				}
    				$str .= '</td>';
    				$str .= '</tr>'; */
    			}
    		}
    		$str .=	'</tbody>';
    	$str .= '</table>';
    	return $str;
    }
}