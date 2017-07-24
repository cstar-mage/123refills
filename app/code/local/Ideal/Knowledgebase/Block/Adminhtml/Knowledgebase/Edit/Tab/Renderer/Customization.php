<script>
function customization_displaydata(strid)
{
	jQuery(".knowledgebase_content").css("display","none");
	jQuery("#" + strid).css("display","block");
	jQuery('html, body').animate({
        scrollTop: jQuery("#" + strid).offset().top
    }, 1000);
}
</script>
<?php
class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Renderer_Customization extends Varien_Data_Form_Element_Text
{
	public function getHtml()
	{
		//if(!$_GET['customization'])
		{
			$str = '<ul class="customization">';
			$str .= '<li>';
			$str .= '<a href="javascript:" onClick="customization_displaydata(\'homepage_working_with_banners\'); ">';
			$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
			$str .= '<span>Homepage Working with Banners</span>';
			//$str .= '<span class="ex_name">(Image to Product)</span>';
			$str .= '</a>';
			$str .= '</li>';
			$str .= '<li>';
			$str .= '<a href="javascript:" onClick="customization_displaydata(\'store_locator\'); ">';
			//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?customization=exporting_newsletter_subscribers">';
			$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
			$str .= '<span>Store Locator</span>';
			//$str .= '<span class="ex_name">(Image to Product)</span>';
			$str .= '</a>';
			$str .= '</li>';
			$str .= '<li>';
			$str .= '<a href="javascript:" onClick="customization_displaydata(\'using_the_brand_manager\'); ">';
			//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?customization=common_discount_code_and_promotion_rules">';
			$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
			$str .= '<span>Using the Brand Manager</span>';
			//$str .= '<span class="ex_name">(Image to Product)</span>';
			$str .= '</a>';
			$str .= '</li>';
			$str .= '<li>';
			$str .= '<a href="javascript:" onClick="customization_displaydata(\'working_with_the_gallery\'); ">';
			//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?customization=discount_codes">';
			$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
			$str .= '<span>Working with the Gallery</span>';
			//$str .= '<span class="ex_name">(Image to Product)</span>';
			$str .= '</a>';
			$str .= '</li>';
			$str .= '</ul>';
		}
		
		//if($_GET['general']=="homepage_working_with_banners")
		{
			$str .= '<div id="homepage_working_with_banners" class="knowledgebase_content" ><div id="article-section" class="artical_section">		
						<h2 class="title">
							Homepage Working with Banners
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 10:09 PM	
							<span class="label">Permanent</span>
						</div> 
					  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254463/articles/5000607589-homepage-working-with-banners/tag_uses/5000246994-banners"><i class="icon-close"></i></a>
										banners
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254463/articles/5000607589-homepage-working-with-banners/tag_uses/5000246995-home-page"><i class="icon-close"></i></a>
										home page
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254463/articles/5000607589-homepage-working-with-banners/tag_uses/5000246996-evolved"><i class="icon-close"></i></a>
										evolved
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">To change the banners on the homepage, go to Theme &gt; Evolved Settings &gt; Home Page</span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img data-height="551" style="cursor: default; width: 307px; height: 551px;" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-10.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">A new page will load containing all the existing Home Page elements. This particular article covers the controls for&nbsp;displayed images or banners in the front page of your website.</span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">Each section is grouped into Page Elements and numbered from 1 to 8. There are 8 total controllable sections&nbsp;in the home page. The Element number corresponds to where they will be situated in the page. 1 is the first and then 2.</span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;"><br></span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 7" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-7.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;"><br>Each element allows multiple ways several banners may be presented and also allows other kinds of elements.<br><br></span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-11.png"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">The choices for banner placement types are as follow<span>s:</span></p>
					<ul style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">
					<li>Single Banner Narrow</li>
					<li>Single Banner Tall</li>
					<li>Three Boxes Featured Right
					<ul>
					<li>Two smaller images on top of each other, one big image to the right</li>
					</ul>
					</li>
					<li>Three Boxes Featured Left
					<ul>
					<li>Two smaller images on top of each other, one big image to the left</li>
					</ul>
					</li>
					<li>Three Boxes
					<ul>
					<li>Three images across</li>
					</ul>
					</li>
					<li>Four Boxes
					<ul>
					<li>Four images across</li>
					</ul>
					</li>
					<li>Promo Single Banner</li>
					<li>Two Boxes Narrow</li>
					<li>Two Boxes Tall</li>
					<li>Three Boxes Narrow</li>
					<li>Three Boxes Square</li>
					<li>Three Boxes Featured Left</li>
					<li>Four Boxes Across</li>
					<li>Four Boxes Featured Slides</li>
					<li>Four Boxes Featured Middle</li>
					<li>Main Banner
					<ul>
					<li>Usually best found at the top of the page in Element 1</li>
					</ul>
					</li>
					</ul>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Each kind of banner placement have specific banner sizes that would ensure these banners are presented on the screen properly and fit the layout. Each size of banner may be referenced in the settings page itself. To see what sizes you need, go to the settings page, choose which banner placement you wish to use and take note of the sizes shown in the image placement field.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-14.png" alt="Image 14" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-14.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: medium;"><br>After getting the sizing and ensuring your banners conform to the proper sizes, upload the banners to the site.</span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: medium;">Click on "Insert Image"&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-15.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-15.png"><img style="cursor: default;" alt="Image 15" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-15.png"></a>&nbsp; A new window will popup where you can upload all the images you need. You can create folders using the "Create Folder" button or search for existing file by clicking on the folders shown to the left.<br><br></span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 17" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-17.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>Click on "Browse Files"&nbsp;<img style="cursor: default;" alt="Image 18" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-18.png">&nbsp;and select the desired image to upload. Several images may be uploaded at once to save time. When you have successfully selected all your images, click on "Upload Files"&nbsp;<img style="cursor: default;" alt="Image 19" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-19.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">When the images successfully upload, click on the desired image to set into the particular field and click on&nbsp;<img style="cursor: default;" alt="Image 21" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-21.png">&nbsp;an HTML code should appear on the text field with the file name of the image you have chosen.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 22" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-22.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Choosing images must be done individually per each banner.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Click on "Save Settings"&nbsp;<img style="cursor: default;" alt="Image 23" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-23.png">&nbsp;on the upper -right hand corner&nbsp;when you are finished to retain all changes.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Don\'t forget&nbsp;check&nbsp;the front page of your home page to see if everything is in order.</p>
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
		//if($_GET['general']=="homepage_working_with_banners")
		{
			$str .= '<div id="store_locator" class="knowledgebase_content" ><div id="article-section" class="artical_section">		
						<h2 class="title">
							Store Locator
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 10:10 PM<span class="label">Permanent</span>
						</div>   <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254463/articles/5000607600-store-locator/tag_uses/5000247011-store-locator"><i class="icon-close"></i></a>
										store locator
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">Store Locators are special pages where customers on your website can find branches of your store or retailers.</span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">To add locations to a previously prepared store locator page, go to CMS &gt; Store Locator</span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><img style="cursor: default;" alt="Image 16" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-162.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">&nbsp;<br></span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">Click on "Add New Location"&nbsp;<img style="cursor: default;" alt="Image 17" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-173.png">&nbsp;to create a new location.</span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">A new page will load. Fill in all necessary information. Note, at the "Geo Location" section, fill in a complete address. There is no need to fill in longitude and latitude data.</span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><img style="cursor: default;" alt="Image 15" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-153.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">&nbsp;<br></span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">When finished, click on "Save Location"&nbsp;<img data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-202.png" alt="Image 20" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-202.png">&nbsp;button.</span></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><img style="cursor: default;" alt="Image 18" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-182.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif;"><span style="font-size: large;">To edit a location, simply click on the row of the location you wish to be edited.</span></p>
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
		//if($_GET['general']=="homepage_working_with_banners")
		{
			$str .= '<div id="using_the_brand_manager" class="knowledgebase_content" ><div id="article-section" class="artical_section">
							<h2 class="title">
								Using the Brand Manager
							</h2>
							<div class="help-text">
								By <b> John Dorsey</b>, Mon, Apr 13 at 10:12 PM	
								<span class="label">Permanent</span>
							</div> 
						  <div class="solution_title">
									<div class="tag_list"> 
									</div>
							 </div>
							 <span class="seperator"></span>
							 <div class="solutions_text clearfix">
								<p><br></p>
						To access the Brand Manager, go to CMS &gt; Brand Manager
						<img width="986" height="257" style="cursor: default;" alt="Image 17" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-172.png" class="alignnone &nbsp;wp-image-6134">
						&nbsp;
						The Brand Manager page should load, showing this.
						<img width="1149" height="363" style="cursor: default;" alt="Image 25" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-252.png" class="alignnone &nbsp;wp-image-6140">
						To add a new brand, click on "Add Brand" <img style="cursor: default;" alt="Image 18" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-181.png" class="alignnone size-full wp-image-6135"> on the upper right corner.
						A new page will load. Fill in the title and add an image, their position sort number and the brand\'s website.
						<img style="cursor: default;" alt="Image 19" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-191.png" class="alignnone size-full wp-image-6136">
						When finished, click on "Save Brand" <img style="cursor: default;" alt="Image 20" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-201.png" class="alignnone size-full wp-image-6137"> on the upper right to save changes.
						To edit an existing brand, go to the Brand Manager main page and click on "Edit" to the right of the brand name.<a href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-233.png"><img style="cursor: default;" alt="Image 23" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-233.png" class="alignnone size-full wp-image-6138"></a>A new page should appear, bearing all the existing information. Edit the information as necessary and then save. </div>
								<ul class="attachment_list">
								</ul>		
							 <span class="seperator"></span> 
							 <div id="article_voting">
								<i class="ficon-like "></i> 0 <b>Likes</b>, 
						<i class="ficon-dislike "></i> 0 <b>Dislikes</b>
						 </div>
						</div></div>';
		}
		//if($_GET['general']=="homepage_working_with_banners")
		{
			$str .= '<div id="working_with_the_gallery" class="knowledgebase_content" ><div id="article-section" class="artical_section">
						<h2 class="title">
							Working with the Gallery
						</h2>
						<div class="help-text">
							By <b> Paulina</b>, Tue, Apr 14 at  2:50 AM	
							<span class="label">Permanent</span>
						</div> 
					  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254463/articles/5000607718-working-with-the-gallery/tag_uses/5000247224-gallery"><i class="icon-close"></i></a>
										gallery
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p>If a gallery or multiple galleries are enabled on your website, you can manage them from CMS &gt; Gallery &gt; Manage Items</p>
					<p><br></p>
					<p></p>
					<p><img alt="path" style="cursor: default; float: none; margin: 0px;" data-id="5013401883" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5013401883/original/Image_7.png?1429002520"></p>
					<p><br></p>
					<p>A new page will load, listing all existing images on the right and a menu listing active images in their respective folders (which correspond to pages)</p>
					<p><br></p>
					<p></p>
					<p></p>
					<p></p>
					<p></p>
					<br><p></p>
					<p><img data-height="502" style="cursor: default; width: 1348px; height: 502px;" data-id="5013404124" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5013404124/original/Image_8.png?1429003860"></p>
					<br>To add a new image to a gallery, click on "Add Item" <img style="cursor: default;" data-id="5013404177" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5013404177/original/Image_10.png?1429003889">&nbsp;button<p><br></p>
					<p>A new page will load, fill in the necessary details like title, upload the specific picture in "Choose File" and make sure in "Parent" to choose the name of the gallery folder (in this case it was Jewelry). Do note that both files and folders appear on this dropdown.</p>
					<p><br></p>
					<p></p>
					<p><img data-height="316" style="cursor: default; height: 316px;" data-id="5013404797" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5013404797/original/Image_11.png?1429004266"></p>
					<p><br></p>
					<p>After making sure all the details are correct, click on "Save Item" <img style="cursor: default;" data-id="5013405376" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5013405376/original/Image_14.png?1429004569">&nbsp;button.</p>
					<p><br></p>
					<br><p>To edit an existing image, click on the "Edit" link beside the name of the file you need to edit main Gallery admin page</p>
					<p><br></p>
					<p></p>
					<p><img style="cursor: default;" data-id="5013405563" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5013405563/original/Image_15.png?1429004658"></p>To enable/disable several items all at once, click on the checkboxes beside the name of the items you wish to change and click "Submit"<p><br></p>
					<p></p>
					<p><img style="cursor: default;" data-id="5013406082" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5013406082/original/Image_16.png?1429004966"></p>
					<br><p><br></p>
					<p>To delete several items at once, click on the checkboxes of the items you wish to delete and &nbsp;change Actions dropdown to "Delete" and then click "Submit"</p>
					<p><br></p>
					<p></p>
					<p><img style="cursor: default;" data-id="5013406156" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5013406156/original/Image_17.png?1429005013"></p>
					<br><p><br></p>
					<p><br></p>
					<p><br></p>
					<p><br></p>
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