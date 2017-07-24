<script>
function troubleshooting_displaydata(strid)
{
	jQuery(".knowledgebase_content").css("display","none");
	jQuery("#" + strid).css("display","block");
	jQuery('html, body').animate({
        scrollTop: jQuery("#" + strid).offset().top
    }, 1000);
}
</script>
<?php
class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Renderer_Troubleshooting extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
    	//if(!$_GET['troubleshooting'])
    	{
    		$str = '<ul class="troubleshooting">';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="troubleshooting_displaydata(\'filters_are_not_showing\'); ">';
    			//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?troubleshooting=image_to_product">';
    				$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
    				$str .= '<span>I made a new category, but the filters are not showing?</span>';
    				//$str .= '<span class="ex_name">(Image to Product)</span>';
    			$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="troubleshooting_displaydata(\'i_cant_login_to_the_admin\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?troubleshooting=batch_processing">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>I can\'t login to the admin</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="troubleshooting_displaydata(\'update_product_doesnt_work\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?troubleshooting=product_image_preparation">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Update Product doesn\'t work</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="troubleshooting_displaydata(\'why_are_my_filters_not_showing\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?troubleshooting=changing_your_password">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Why are my filters not showing?</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="troubleshooting_displaydata(\'why_are_my_products_not_displaying\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?troubleshooting=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Why are my products not displaying?</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '</ul>';
    	}
		
		//if($_GET['troubleshooting']=="image_to_product")
		{
			$str .= '<div id="filters_are_not_showing" class="knowledgebase_content" ><div id="article-section" class="artical_section">
						<h2 class="title">
							I made a new category, but the filters are not showing?
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 11:01 PM		
							<span class="label">Permanent</span>
						</div> 
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254470/articles/5000607634-i-made-a-new-category-but-the-filters-are-not-showing-/tag_uses/5000247033-filters"><i class="icon-close"></i></a>
										filters
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If your filters are not showing after creating a new category, go to Catalog &gt; Manage Categories</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Click on the newly created category and go to "Display Settings" tab</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1085" height="520" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-232.png" alt="" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-232.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">On the option "Is Anchor" make sure it is set to "Yes"</p>
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
		//elseif($_GET['troubleshooting']=="batch_processing")
		{
			$str .= '<div id="i_cant_login_to_the_admin" class="knowledgebase_content" ><div id="article-section" class="artical_section">		
						<h2 class="title">
							I can\'t login to the admin
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 11:02 PM		
							<span class="label">Permanent</span>
						</div> 
						   <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254470/articles/5000607635-i-can-t-login-to-the-admin/tag_uses/5000247022-login"><i class="icon-close"></i></a>
										login
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Sometimes there is an issue with the login page after typing in correct credentials and after clicking on the login button, the same page is shown.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-310.png" alt="Image 3" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-310.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If page still appears after logging in and not the same login page with the warning "Invalid User Name and Password", then an issue with cookies is present on your website.<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-42.png" alt="Image 4" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-42.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Clearing cookies varies from browser to browser. This article covers how to clear cookies from Google Chrome Browser.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">On the upper right hand corner, click on the three rows of lines to bring up the menu, and then click on "Settings"</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-73.png" alt="Image 7" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-73.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">On the upper right of the new page search the term "Cookies" and click on content settings</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="904" height="588" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-94.png" alt="" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-94.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Under content settings, click on "All cookies and site data"</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-109.png" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-109.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">A new window will be brought up again, search the name of your website and click on the x beside the name of your site. This should delete the cookies.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-116.png" alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-116.png"><br>You can now try logging into your website again.</p>
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
		//elseif($_GET['troubleshooting']=="product_image_preparation")
		{
			$str .= '<div id="update_product_doesnt_work" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
						<h2 class="title">
							Update Product doesn\'t work
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 11:03 PM	
							<span class="label">Permanent</span>
						</div> 
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254470/articles/5000607636-update-product-doesn-t-work/tag_uses/5000247061-csv"><i class="icon-close"></i></a>
										csv
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254470/articles/5000607636-update-product-doesn-t-work/tag_uses/5000247045-products"><i class="icon-close"></i></a>
										products
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254470/articles/5000607636-update-product-doesn-t-work/tag_uses/5000247043-update"><i class="icon-close"></i></a>
										update
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If you\'ve encountered problems while using the Update Product module, please verify the following:</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<ol style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">
					<li>Your datasheet is in csv format and has been properly made from a proper spreadsheet program such as MS Excel</li>
					<li>Your csv\'s filename contains no spaces, no special characters</li>
					<li>Your attribute codes are all correct, particularly "sku". Please verify that they are all spelled correctly and are in lowercase.</li>
					<li>Your csv file does not contain any "," anywhere</li>
					</ol>
					<div><font face="Georgia, Times New Roman, Bitstream Charter, Times, serif"><br></font></div>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If your update is taking too long, your csv may be too large for it to complete in a timely manner. We advise splitting the file into half or even multiple files.</p>
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
		//elseif($_GET['troubleshooting']=="changing_your_password")
		{
			$str .= '<div id="why_are_my_filters_not_showing" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
						<h2 class="title">
							Why are my filters not showing?
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 11:04 PM
							<span class="label">Permanent</span>
						</div> 
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254470/articles/5000607637-why-are-my-filters-not-showing-/tag_uses/5000247032-attributes"><i class="icon-close"></i></a>
										attributes
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254470/articles/5000607637-why-are-my-filters-not-showing-/tag_uses/5000247033-filters"><i class="icon-close"></i></a>
										filters
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<ol style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;">
					<li><span style="font-size: medium;">If there are no products in the category where the filters have more than one value in them, the filter will not show. For example, if your category is for engagement rings and all the products in the category are engagement rings, "Product Type" will not show as a filter because there is only one value for "Product Type" and that is "Engagement Ring" product type. If you have a category that is "Rings" however, and placed products with product type Fashion Rings and Engagement Rings in the category, the filters should appear.</span></li>
					<li><span style="font-size: medium;">Make sure the attribute has set "Use in Layered Navigation" option, to "Filterable (with results)".</span></li>
					<li><span style="font-size: medium;">Make sure there attribute values are assigned to the products in the category.</span></li>
					</ol>
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
		//elseif($_GET['troubleshooting']=="getting_into_admin_backend")
		{
			$str .= '<div id="why_are_my_products_not_displaying" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
						<h2 class="title">
							Why are my products not displaying?
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 11:06 PM		
							<span class="label">Permanent</span>
						</div> 
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254470/articles/5000607638-why-are-my-products-not-displaying-/tag_uses/5000247063-inventory"><i class="icon-close"></i></a>
										inventory
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254470/articles/5000607638-why-are-my-products-not-displaying-/tag_uses/5000247045-products"><i class="icon-close"></i></a>
										products
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If your products are not displaying please confirm the following:</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Product ‘Status” under Catalog &gt; Manage Product is set to “Enable”</p>
					<ol style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">
					<li>Please refer to “Mass Product Update” article to learn how to do this for multiple products quickly</li>
					<li>Products are not yet assigned to a category
					<ol>
					<li>Please confirm products are assigned in correct category.</li>
					<li>Refer to “Managing Categories” and “Adding Multiple Products in One Category”</li>
					</ol>
					</li>
					<li>The category is setup as a "Static Block Only" in the Display Settings tab instead of "Products Only" or "Products and Static Block"
					<ol>
					<li>Make sure the settings on "Display Mode" is "Products Only" or if there is a static block designed for that particular page "Products and Static Block" with the proper static block chosen under "CMS Block" option.<br><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-411.png" alt="Image 41" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-411.png">
					</li>
					</ol>
					</li>
					<li>If inventory option is set to manage "Yes", meaning you are manually managing inventory in your website, then
					<ol>
					<li>Quantity is set to 0 or the "Availability" is set to "Out of Stock"</li>
					<li>It must have more than 0 value of inventory and it must be "In Stock"</li>
					</ol>
					</li>
					<li>In manage product, the product must be set to "Search / Catalog".</li>
					</ol>
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