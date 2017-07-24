<script>
function gettingstarted_displaydata(strid)
{
	jQuery(".knowledgebase_content").css("display","none");
	jQuery("#" + strid).css("display","block");
	jQuery('html, body').animate({
        scrollTop: jQuery("#" + strid).offset().top
    }, 1000);
}
</script>
<?php
class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Renderer_General extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
    	//if(!$_GET['general'])
    	{
    		$str = '<ul class="gettingstarted">';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="gettingstarted_displaydata(\'image_to_product\'); ">';
    			//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=image_to_product">';
    				$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/How-to-upload-multiple-products.jpg" />';
    				$str .= '<span>How to upload multiple products</span>';
    				$str .= '<span class="ex_name">(Image to Product)</span>';
    			$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="gettingstarted_displaydata(\'batch_processing\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=batch_processing">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/Batch-Processing-of-Images-in-Photoshop.jpg" />';
		    		$str .= '<span>Batch Processing of Images in Photoshop</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="gettingstarted_displaydata(\'product_image_preparation\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=product_image_preparation">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Product Image Preparation</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="gettingstarted_displaydata(\'changing_your_password\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=changing_your_password">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Changing Your Password</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="gettingstarted_displaydata(\'getting_into_admin_backend\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Getting into the admin backend</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '</ul>';
    	}
		
		//if($_GET['general']=="image_to_product")
		{
			$str .= '<div id="image_to_product" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
						<h2 class="title">
							How to upload multiple products (Image to Product)
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at  9:52 PM
					
							
							<span class="label">Permanent</span>
						</div> 
						 
						
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000060715/articles/5000607602-how-to-upload-multiple-products-image-to-product-/tag_uses/5000247013-image-to-product"><i class="icon-close"></i></a>
										image to product
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000060715/articles/5000607602-how-to-upload-multiple-products-image-to-product-/tag_uses/5000247014-updating-products"><i class="icon-close"></i></a>
										updating products
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000060715/articles/5000607602-how-to-upload-multiple-products-image-to-product-/tag_uses/5000247015-uploading-products"><i class="icon-close"></i></a>
										uploading products
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p><span style="line-height: 16px;">Go</span><span style="line-height: 16px;"> to Catalog &gt; Image to Product</span></p>
					<p><br></p>
					<p><span style="line-height: 16px;"></span><img style="line-height: 16px; cursor: default; width: 169.2px; height: 282px;" data-height="282" alt="Image 7" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-71.png" class="alignnone size-full wp-image-5980"><span style="line-height: 16px;">&nbsp; &nbsp; &nbsp;&nbsp;</span><br></p>
					<div>&nbsp;&nbsp;<div class="Mu SP" id=":xo.ma">
					<div>The Image to Product page will load.</div>
					<div></div>
					<div><img width="1071" height="246" style="cursor: default;" alt="Image 8" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-81.png" class="alignnone &nbsp;wp-image-5981"></div>
					<div>On the page, first click on "Remove Images" <img style="cursor: default;" alt="Image 9" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-9.png" class="alignnone size-full wp-image-5982"> &nbsp; &nbsp;button to remove any data that might still exist.<br><span><br>Click on "Choose File" button </span><img style="cursor: default;" alt="Image 13" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-131.png" class="alignnone size-full wp-image-5986"><span> to bring up a window where you can choose your zip file. Reminder: all zip files must not have special characters or spaces in the filen</span><span>ame or they will not upload properly.<br></span><span><br>When the proper zip file is chosen, click on the "Save" </span><img style="cursor: default;" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-101.png" class="alignnone size-full wp-image-5983"><span> button</span><span>.</span>
					</div>
					<div><br></div>
					<div></div>
					<div>Depending on the size of the zip and the speed of your internet, the upload may take awhile. Keep watch on the progress and make sure Image to Product window will not be accidentally closed.</div>
					<div></div>
					<div>When the process if finished, click on "Generate CSV" <img style="cursor: default;" alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-111.png" class="alignnone size-full wp-image-5984">button and when the process has reloaded the page, click on Update Products <img style="cursor: default;" alt="Image 12" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-121.png" class="alignnone size-full wp-image-5985"> button.</div>
					<div><br></div>
					<div></div>
					<div>Your products should now be seen in "Manage Products" page.</div>
					</div>
					<div class="Mu SP" id=":xn.ma"></div>
					</div>
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
		//elseif($_GET['general']=="batch_processing")
		{
			$str .= '<div id="batch_processing" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
							<h2 class="title">
								Batch Processing of Images in Photoshop
							</h2>
							<div class="help-text">
								By <b> John Dorsey</b>, Mon, Apr 13 at  9:54 PM
								<span class="label">Permanent</span>
							</div> 
							 <div class="solution_title">
									<div class="tag_list"> 
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000060715/articles/5000607603-batch-processing-of-images-in-photoshop/tag_uses/5000247017-images"><i class="icon-close"></i></a>
											images
										</div>
									</div>
							 </div>
							 <span class="seperator"></span>
							 <div class="solutions_text clearfix">
								<p><br></p>
						<div></div>
						<div>Open PhotoshopRun File &gt; Scripts &gt; Image Processor</div>
						<div></div>
						<div><img width="918" height="516" style="cursor: default;" alt="Image 1" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-1.png" class="alignnone &nbsp;wp-image-5964"></div>
						<div></div>
						<div>
						Select the folder with the original files.</div>
						<div></div>
						<div><img data-height="570" style="cursor: default; width: 547.961335676626px; height: 570px;" alt="Image 2" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-2.png" class="alignnone size-full wp-image-5965"></div>
						<div>
						Choose JPEG
						Check "Resize to Fit" 800x800px
						Set quality to 12</div>
						<div></div>
						<div>Click on RUN</div>
						<div>
						After those files have fully batched, open one image that is NOT 800px on either side.</div>
						<div></div>
						<div>Go to Window &gt; Actions</div>
						<div><img width="1053" height="592" style="cursor: default;" alt="Image 12" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-12.png" class="alignnone &nbsp;wp-image-5973"></div>
						<div></div>
						<div></div>
						<div></div>
						<div>Start recording a new action.</div>
						<div></div>
						<div><img style="cursor: default; width: 207.612662942272px; height: 536px;" data-height="536" alt="Image 4" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-4.png" class="alignnone size-full wp-image-5967"></div>
						<div></div>
						<div>Click on the "New Actions" icon as shown in the image above.</div>
						<div></div>
						<div></div>
						<div>Click on the opened file.</div>
						<div></div>
						<div>
						- Right click on the image, set the "Canvas Size" to 800 x 800</div>
						<div>
						<a href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-13.png"><img style="cursor: default; width: 609px; height: 237px;" data-height="237" alt="Image 13" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-13.png" class="alignnone size-full wp-image-5974"></a>
						<img style="cursor: default;" alt="Image 7" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-7.png" class="alignnone size-full wp-image-5969">
						</div>
						<div>- Go to File&gt; Save for Web, save into a new folder</div>
						<div>
						<div></div>
						<div>- 60 quality JPG *be careful not to click on any other files and do not rename the image in any way during the save.</div>
						</div>
						<div><img style="cursor: default;" alt="Image 17" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-17.png" class="alignnone size-full wp-image-5975"></div>
						<div></div>
						<div>- Close the file, do not save changes.Stop Recording the action by clicking on the stop button in the Actions window.</div>
						<div></div>
						<div><img style="cursor: default;" alt="Image 8" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-8.png" class="alignnone size-full wp-image-5970"></div>
						<div>
						Go to File &gt; Automate &gt; Batch</div>
						<div><img style="cursor: default;" alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-11.png" class="alignnone size-full wp-image-5972"></div>
						<div></div>
						<div></div>
						<div>
						Choose the action you just created</div>
						<div></div>
						<div><img style="cursor: default;" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-10.png" class="alignnone size-full wp-image-5971"></div>
						<div>At "Source:" choose the folder that has the 800 jpgs from the previous process.</div>
						<div></div>
						<div>Click on OK and the new images should appear where you chose to save images during "Save for Web"</div>
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
		//elseif($_GET['general']=="product_image_preparation")
		{
			$str .= '<div id="product_image_preparation" class="knowledgebase_content" ><div id="article-section" class="artical_section">
					<h2 class="title">
						Product Image Preparation
					</h2>
					<div class="help-text">
						By <b> John Dorsey</b>, Mon, Apr 13 at  9:46 PM
						<span class="label">Permanent</span>
					</div> 
					  <div class="solution_title">
							<div class="tag_list"> 
								<div class="item">			
									  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000060715/articles/5000607605-product-image-preparation/tag_uses/5000247017-images"><i class="icon-close"></i></a>
									images
								</div>
							</div>
					 </div>
					 <span class="seperator"></span>
					 <div class="solutions_text clearfix">
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To ensure quality of pictures displayed on the website all images are recommended to&nbsp;uniformly be at 800x800 pixels and saved in JPEG format with the product SKU as the filename.</p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Images that are smaller than 800x800 px are acceptable, but it is recommended that it is no smaller than 500x500 px.</p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">All images must be square and not increased in size for a smaller size, as doing so will lessen the quality of the pictur</p>
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
		//elseif($_GET['general']=="changing_your_password")
		{
			$str .= '<div id="changing_your_password" class="knowledgebase_content" ><div id="article-section" class="artical_section">
						<h2 class="title">
							Changing Your Password
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at  9:48 PM
							<span class="label">Permanent</span>
						</div> 
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000060715/articles/5000607607-changing-your-password/tag_uses/5000247022-login"><i class="icon-close"></i></a>
										login
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000060715/articles/5000607607-changing-your-password/tag_uses/5000247023-password"><i class="icon-close"></i></a>
										password
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p>In the admin backend, go to “System” on the top navigation menu and then click on “My Account”.</p>
					<p><br></p>
					<p><img width="300" height="53" style="cursor: default; width: 300px; height: 53px;" data-height="53" alt="" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-151-300x53.png" class="alignnone wp-image-14 size-medium">&nbsp;</p>
					<p><br></p>
					<p>Upon clicking my account, a new page with relevant information to the account is presented, including “Email”, “New Password” and “Password</p>
					<p><span>Confirmation” fields.&nbsp;</span></p>
					<p><br></p>
					<p><br></p>
					<p><img style="cursor: default; width: 298.295454545455px; height: 175px;" data-height="175" alt="Change password" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-16-300x176.png" class="alignnone size-medium wp-image-13"><span>&nbsp;</span><br></p>
					<p><em>Please verify y</em><em>our email is correct</em><span> and input your new desired password twice, once into each of the two password field. When finished click on “Save Account” on the upper right corner to ensure all the necessary changes are saved.</span><br></p>
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
		//elseif($_GET['general']=="getting_into_admin_backend")
		{
			$str .= '<div id="getting_into_admin_backend" class="knowledgebase_content" ><div id="article-section" class="artical_section">
				 		<h2 class="title">
						Getting into the admin backend
					</h2>
					<div class="help-text">
						By <b> John Dorsey</b>, Mon, Apr 13 at  9:49 PM		
						<span class="label">Permanent</span>
					</div>
					  <div class="solution_title">
							<div class="tag_list"> 
								<div class="item">			
									  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000060715/articles/5000607608-getting-into-the-admin-backend/tag_uses/5000247022-login"><i class="icon-close"></i></a>
									login
								</div>
							</div>
					 </div>
					 <span class="seperator"></span>
					 <div class="solutions_text clearfix">
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To access the admin backend of your website, go to the front page of your website and add “/idealAdmin” to the front page address of your website.</p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">For example, your website is http://www.yourwebsite.com, to access your admin backend, the address would be, http://www.yourwebsite.com/idealAdmin.</p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="The Log-In Window" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-14-300x131.png"></p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Enter your credentials</p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
				<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><b>username</b>: manager<br><b>password</b>: idealbrand9 (this is a default password, please change this when you first log in)</p>
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