<script>
function managingcategories_displaydata(strid)
{
	jQuery(".knowledgebase_content").css("display","none");
	jQuery("#" + strid).css("display","block");
	jQuery('html, body').animate({
        scrollTop: jQuery("#" + strid).offset().top
    }, 1000);
}
</script>
<?php
class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Renderer_Managingcategories extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
    	//if(!$_GET['managingcategories'])
    	{
    		$str = '<ul class="managingcategories">';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingcategories_displaydata(\'managing_categories\'); ">';
    			//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?managingcategories=image_to_product">';
    				$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
    				$str .= '<span>Managing Categories</span>';
    				//$str .= '<span class="ex_name">(Image to Product)</span>';
    			$str .= '</a>';
    		$str .= '</li>';
    		$str .= '</ul>';
    	}
		
		//if($_GET['managingcategories']=="image_to_product")
		{
			$str .= '<div id="managing_categories" class="knowledgebase_content" ><div id="article-section" class="artical_section">
								<h2 class="title">
									Managing Categories
								</h2>
								<div class="help-text">
									By <b> John Dorsey</b>, Mon, Apr 13 at 11:09 PM		
									<span class="label">Permanent</span>
								</div> 
								  <div class="solution_title">
										<div class="tag_list"> 
											<div class="item">			
												  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254468/articles/5000607639-managing-categories/tag_uses/5000247066-categories"><i class="icon-close"></i></a>
												categories
											</div>
											<div class="item">			
												  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254468/articles/5000607639-managing-categories/tag_uses/5000247067-menu"><i class="icon-close"></i></a>
												menu
											</div>
										</div>
								 </div>
								 <span class="seperator"></span>
								 <div class="solutions_text clearfix">
									<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Go to Catalog &gt; Manage Categories.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">On the left of the Manage Categories page are all the existing categories. All the categories in black are active and can be seen on the front-end, while grayed-out ones are inactive and are not visible on the front end.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="930" height="473" data-height="473" style="cursor: default; width: 859px; height: 473px;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-21.png" alt="Image 2" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-21.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Clicking on an existing category, whether it is active or inactive, loads all the existing details of the category on the right side of the page where it may be edited. Remember to click on "Save Category" once all changes are made to complete the changes.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To create a new&nbsp;category, fill in the blank text fields and areas on the right side of the page. Take note of the red * mark beside some of the text fields, indicating that these need to be filled out or the new category won\'t be saved.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="960" height="497" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-32.png" alt="Image 3" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-32.png">&nbsp;<img width="960" height="497" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-41.png" alt="Image 4" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-41.png">&nbsp;<img width="960" height="397" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-5.png" alt="Image 5" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-5.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Required fields include "Name" "Is Active" and "Include in Navigation Menu". To make sure a category will be visible on the front end menu, "Is Active" should be set to "YES". Should you need to have a category but don\'t want it to be included in the menu, changing "Include in Navigation Menu" to "NO" would make an active category that would not be shown on the main menu in the front end.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Other fields like&nbsp;"Description"and "Bottom Description" are where blurbs or descriptive Categories can be included.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Alternatively, if you need to have link in the main menu that isn\'t a category, but rather another page in the website or an external link, set "Enable External Link" at the bottom of the manage categories page to "Yes", add the external link in the field below and choose whether or not the target is the same window (Self) or another tab (Blank).</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To reorganize the position of the categories, simply drag and drop the names of the categories on the left to your desired position. A category may fall under a sub-category or even a sub-sub-category, just drag the category name into an existing sub or sub-sub category.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-28.png" alt="Image 28" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-28.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-44.png" alt="Image 44" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-44.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">A line will assist in indicating where the category\'s new position will be. After placing the category in a new position, a "saving" icon will appear on screen. Once this goes away, your new category is now in its new position on the front end.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To delete a category, on the left side of the page, click on the category you wish to delete. The category\'s details will load and on the upper right side of the page, a "Delete Category"&nbsp;<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-45.png" alt="Image 45" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-45.png">&nbsp;button will appear. Click on this and the category should be deleted.</p>
								 </div>
									<ul class="attachment_list">
									</ul>	
								 <span class="seperator"></span> 
								 <div id="article_voting">
									<i class="ficon-like "></i> 0 <b>Likes</b>, 
							<i class="ficon-dislike "></i> 0 <b>Dislikes</b>
								 </div>
							</div></div>';
		}
		
		
    	return $str;

    }
}