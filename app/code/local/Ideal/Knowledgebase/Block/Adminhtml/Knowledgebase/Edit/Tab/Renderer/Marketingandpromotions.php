<script>
function marketingandpromotions_displaydata(strid)
{
	jQuery(".knowledgebase_content").css("display","none");
	jQuery("#" + strid).css("display","block");
	jQuery('html, body').animate({
        scrollTop: jQuery("#" + strid).offset().top
    }, 1000);
}
</script>
<?php
class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Renderer_Marketingandpromotions extends Varien_Data_Form_Element_Text
{
	public function getHtml()
	{
	    //if(!$_GET['marketingandpromotions'])
    	{
    		$str = '<ul class="marketingandpromotions">';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="marketingandpromotions_displaydata(\'setup_zopim\'); ">';
    				$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
    				$str .= '<span>Setup Zopim on the Website</span>';
    				//$str .= '<span class="ex_name">(Image to Product)</span>';
    			$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="marketingandpromotions_displaydata(\'exporting_newsletter_subscribers\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?marketingandpromotions=exporting_newsletter_subscribers">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Exporting Newsletter Subscribers</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="marketingandpromotions_displaydata(\'common_discount_code_and_promotion_rules\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?marketingandpromotions=common_discount_code_and_promotion_rules">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Common Discount Code and Promotion Rules</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="marketingandpromotions_displaydata(\'discount_codes\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?marketingandpromotions=discount_codes">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Discount Codes</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '</ul>';
    	}
    	
    	//if($_GET['general']=="setup_zopim")
    	{
    		$str .= '<div id="setup_zopim" class="knowledgebase_content" ><div id="article-section" class="artical_section">
					<h2 class="title">
						Setup Zopim on the Website
					</h2>
					<div class="help-text">
						By <b> John Dorsey</b>, Mon, Apr 13 at 10:14 PM	
						<span class="label">Permanent</span>
					</div> 
					  <div class="solution_title">
							<div class="tag_list"> 
							</div>
					 </div>
					 <span class="seperator"></span>
					 <div class="solutions_text clearfix">
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Zopim is a chat application that will allow you to chat directly with customers on your website to address any questions or concerns real time. If you are unavailable, Zopim also takes messages for you via chat while you are away so you can speak to the customer when you are available.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To set up Zopim, follow these steps.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Go to&nbsp;<a data-mce-href="http://zopim.com" href="http://zopim.com/">zopim.com</a>&nbsp;and click on the "Sign Up" button&nbsp;</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
						<p><a style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px; background-color: rgb(255, 255, 255);" data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-3.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-3.png"><img style="cursor: default;" alt="Image 3" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-3.png"></a></p>
						<p><span style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To begin the registration, first enter your name and a valid email address you have access to. Check the box beside "I agree to Zopim\'s Terms of Service and Privacy Policy" and click on "Sign up for a free account"</span></p>
						<p><span style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></span></p>
						<p><img style="cursor: default; width: 811px; height: 426px;" data-height="426" alt="Image 5" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-5.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>Go to the inbox of the email you signed up with, you should have&nbsp;recevied&nbsp;a new email from Zopim after a few minutes. Open the email and click on "Verify your email" button, this will take you back to the Zopim website to continue your registration.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-6.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-6.png"><img alt="Image 6" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-6.png"></a>&nbsp;<img width="1042" height="365" style="cursor: default;" alt="Image 7" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-72.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Continue filling in the rest of the required information and click on "Save and go to dashboard".</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 8" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-8.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">When you are finished you will be taken to the dashboard and a set of welcome messages will pop-up. Click on Next</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 9" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-91.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Then fill in the required information.&nbsp;Display&nbsp;name will be the name customers see in the live chat. Check or uncheck email notifications you wish to receive from Zopim and click on next.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-103.png" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-103.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Finally, copy the code shown in the next window. Copy this code (highlight,&nbsp;right-click, copy) and email this block of text (right-click, paste into empty text field) to the designer or the support personnel in Ideal Brand Marketing so that we may be able to put the code in for you.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-112.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Alternatively, the code will be&nbsp;mailed&nbsp;to you.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-12.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-12.png"><img style="cursor: default;" alt="Image 12" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-12.png"></a>&nbsp;<img width="1107" height="325" style="cursor: default; width: 854.363076923077px; height: 324px;" data-height="324" alt="Image 13" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/Image-131.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;</p>
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
    	//elseif($_GET['general']=="exporting_newsletter_subscribers")
    	{
    		$str .= '<div id="exporting_newsletter_subscribers" class="knowledgebase_content" ><div id="article-section" class="artical_section">
						<h2 class="title">
							Exporting Newsletter Subscribers
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 11:13 PM
							<span class="label">Permanent</span>
						</div>  
						  <div class="solution_title">
								<div class="tag_list"> 
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To export the list of your newsletter subscribers, go to Newsletter &gt; Newsletter Subscribers</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1072" height="189" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-107.png" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-107.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">At "Export To" there is a dropdown of the file format the list should be in, whether it is in CSV or Excel XML</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-115.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-115.png"><img alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-115.png"></a>&nbsp;<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-125.png" alt="Image 12" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-125.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Choose the desired file type and click on the "Export" &nbsp;<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-134.png" alt="Image 13" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-134.png">&nbsp;button.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">The file should begin downloading.</p>
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
    	//elseif($_GET['general']=="common_discount_code_and_promotion_rules")
    	{
    		$str .= '<div id="common_discount_code_and_promotion_rules" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
						<h2 class="title">
							Common Discount Code and Promotion Rules
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Fri, Apr 24 at  5:33 AM	
							<span class="label">Permanent</span>
						</div> 
					 <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254450/articles/5000607644-common-discount-code-and-promotion-rules/tag_uses/5000247069-coupons"><i class="icon-close"></i></a>
										coupons
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254450/articles/5000607644-common-discount-code-and-promotion-rules/tag_uses/5000247070-discounts"><i class="icon-close"></i></a>
										discounts
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254450/articles/5000607644-common-discount-code-and-promotion-rules/tag_uses/5000255743-promotions"><i class="icon-close"></i></a>
										promotions
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254450/articles/5000607644-common-discount-code-and-promotion-rules/tag_uses/5000247073-promo-codes"><i class="icon-close"></i></a>
										promo codes
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">For universal discounts, no conditions need to be set.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">1. Cart\'s amount is greater than or equal to X amount</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-34.png" alt="Image 34" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-34.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">2. Exclude certain items from the promotions</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"></p>
					<p><img data-id="5014673703" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5014673703/original/Image_12.png?1429878820"></p>
					<br><p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">3. Include only specific items from promotions using specific attribute tags like "Manufacturer" or "Brand"</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"></p>
					<p><img style="cursor: default;" data-id="5014673653" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5014673653/original/Image_10.png?1429878798"></p>
					<br>
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
    	//elseif($_GET['general']=="discount_codes")
    	{
    		$str .= '<div id="discount_codes" class="knowledgebase_content" ><div id="article-section" class="artical_section">		
						<h2 class="title">
							Discount Codes
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 11:17 PM	
							<span class="label">Permanent</span>
						</div> 	
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254450/articles/5000607645-discount-codes/tag_uses/5000247069-coupons"><i class="icon-close"></i></a>
										coupons
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254450/articles/5000607645-discount-codes/tag_uses/5000247072-promos"><i class="icon-close"></i></a>
										promos
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254450/articles/5000607645-discount-codes/tag_uses/5000247073-promo-codes"><i class="icon-close"></i></a>
										promo codes
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Discount codes are used by customers upon checkout to avail of a promotional price on items.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To create a discount code for your customers to avail of promotional prices, go to Promotions &gt; Shopping Cart Price Rules</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-171.png" alt="Image 17" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-171.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1007" height="505" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-16_b.png" alt="Image 16_b" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-16_b.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">On the "Rule&nbsp;Information" section, fill in the rule name, this name will be visible on the invoice when customers use them.<br>The "Status" is set to Active by default.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>Choose the Customer Groups who can use this promotional code. NOT LOGGED IN (guest users), General (which are most customers), Wholesale or Retailer</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>On the field "Coupon Code" input the desired code customers will use upon checkout. Note, these codes are not case sensitive. A discount code "PROMO" can be entered as "promo" or even "Promo".</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1009" height="388" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-18.png" alt="Image 18" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-18.png"><br>Set "Uses per Coupon" to the desired amount. This number determines how many times the discount&nbsp;code may be used. Add in 9999 if you want the use to be infinite.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>Set "Uses per Customer" to the desired amount. This number determines how many times a logged-in customer can use the code. Note, only logged in customers are subject to this rule and they can use the coupon as many times as they want as a guest user. In order to enforce the certain number of times per customer, the coupon should not include "NOT LOGGED IN"from the allowed customer groups who can use the coupon and inform customers that they need to create an account/login in order to&nbsp;use&nbsp;the discount code.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>The dates wherein the discount codes will be active can be set on the "From Date" and "To Date" options.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">At this point, click on Save and Continue Edit&nbsp;<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-19.png" alt="Image 19" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-19.png">&nbsp;button in order to ensure that changes will be saved.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">After the code is made, it is necessary now to define the discount code rules. On the left menu, click on "Actions"</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1010" height="480" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-221.png" alt="Image 22" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-221.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">The option "Apply" is where you can&nbsp;choose&nbsp;a number of options, these options include:<br>Percentage<br>Fixed amount (individual items)<br>Fixed amount (for the whole cart)<br>Buy X get Y free</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1022" height="172" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-231.png" alt="Image 23" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-231.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">At the Discount Amount field, name the percentage/fixed amount or Y (from Buy X get Y free) amount.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>You can name the maximum quantity of items the discount can be applied to in "Maximum Qty Discount is Applied To" field.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>Apply to Shipping Amount excludes or includes shipping fees from the discount.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>The option to include Free Shipping upon using the code is also available to be turned on or off.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Certain conditions can also be made before the code will be valid. A minimum price or quantity can be set before the discount code will be applied, or it can apply only for selected items.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">For example, to apply a discount to items amount to greater than or equal to $100, the rules would look like this.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-34.png" alt="Image 34" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-34.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To name a rule, click on the&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-251.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-251.png"><img alt="Image 25" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-251.png"></a>then, a dropdown will appear. Choose the desired setting</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-26.png" alt="Image 26" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-26.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">When a rule is chosen, the rule will appear along with clickable options "is" and "..."</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-292.png" alt="Image 29" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-292.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Clicking "is" brings down a number of options</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-311.png" alt="Image 31" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-311.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">While clicking on "..." brings out a field where quantity can be named.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="558" height="137" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-351.png" alt="" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-351.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-34.png" alt="Image 34" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-34.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To delete any rule, simply press on the red "X" button beside each rule<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-281.png" alt="Image 28" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-281.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Remember to click on "Save" when all the changes are finished.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">The discount code can now be used on the Shopping Cart page. The code needs to be typed in and the "Apply" button must be clicked on in order for the discount to be applied.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-37.png" alt="Image 37" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-37.png"></p>
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