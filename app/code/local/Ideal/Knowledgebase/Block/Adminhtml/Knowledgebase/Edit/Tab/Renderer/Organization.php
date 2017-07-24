<script>
function organization_displaydata(strid)
{
	jQuery(".knowledgebase_content").css("display","none");
	jQuery("#" + strid).css("display","block");
	jQuery('html, body').animate({
        scrollTop: jQuery("#" + strid).offset().top
    }, 1000);
}
</script>
<?php
class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Renderer_Organization extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
    	//if(!$_GET['organization'])
    	{
    		$str = '<ul class="organization">';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="organization_displaydata(\'how_to_change_position_of_products\'); ">';
    			//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?organization=image_to_product">';
    				$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
    				$str .= '<span>How to change position of products</span>';
    				//$str .= '<span class="ex_name">(Image to Product)</span>';
    			$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="organization_displaydata(\'adding_multiple_products_in_a_category\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?organization=batch_processing">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Adding Multiple Products in a Category</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '</ul>';
    	}
		
		//elseif($_GET['organization']=="batch_processing")
		{
			$str .= '<div id="how_to_change_position_of_products" class="knowledgebase_content" ><div id="article-section" class="artical_section">
						    <h2 class="title">
						      How to change position of products
						    </h2>
						    <div class="help-text">
						      By <b> John Dorsey</b>, Mon, Apr 13 at 11:10 PM
						      <span class="label">Permanent</span>
						    </div> 
						      <div class="solution_title">
						        <div class="tag_list"> 
						          <div class="item">			
						              <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254469/articles/5000607640-how-to-change-position-of-products/tag_uses/5000247068-position"><i class="icon-close"></i></a>
						            position
						          </div>
						          <div class="item">			
						              <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254469/articles/5000607640-how-to-change-position-of-products/tag_uses/5000247045-products"><i class="icon-close"></i></a>
						            products
						          </div>
						        </div>
						     </div>
						     <span class="seperator"></span>
						     <div class="solutions_text clearfix">
						      <p style="font-family: Georgia,\'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To change position of products go to Catalog &gt; Manage Categories and click “Display Settings” tab</p>
						  <p style="font-family: Georgia,\'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><strong>&nbsp;<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-4-300x61.png" alt="Image 4" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-4-300x61.png"></strong></strong></p>
						  <p style="font-family: Georgia,\'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						  <p style="font-family: Georgia,\'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Look for “Default Product Listing Sort By” and set it to your desired setting.</p>
						  <p style="font-family: Georgia,\'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default; float: none; margin: 0px;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-3-300x223.png" alt="Image 3" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-3-300x223.png"></p>
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
		//elseif($_GET['organization']=="product_image_preparation")
		{
			$str .= '<div id="adding_multiple_products_in_a_category" class="knowledgebase_content" ><div id="article-section" class="artical_section">
						<h2 class="title">
							Adding Multiple Products in a Category
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 11:12 PM		
							<span class="label">Permanent</span>
						</div> 
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254469/articles/5000607641-adding-multiple-products-in-a-category/tag_uses/5000247066-categories"><i class="icon-close"></i></a>
										categories
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254469/articles/5000607641-adding-multiple-products-in-a-category/tag_uses/5000247045-products"><i class="icon-close"></i></a>
										products
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Got to Catalog &gt; Manage Products</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Select the category where new products will be added on the left, and click on "Category Products" tab found on the right side of the page.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="973" height="483" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-14.png" alt="Image 1" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-14.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">The page will load, showing a list of all the existing products currently in the category. If there are no products yet on the category, the list will be blank.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="988" height="495" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-103.png" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-103.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To begin searching for products to include into the category, on the left side of the list there is a dropdown that is "Yes" by default. This drop down indicates whether or not to display products that are included in the category. As we are looking for new products to include, select the drop down and click on&nbsp;"No".</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="458" height="262" style="cursor: default; float: none; margin: 0px;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-10b.png" alt="Image 10b" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-10b.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To further narrow down the search, fill in "Name" to the right of the first drop down and search for the name of the products. A&nbsp;certain product type can also be chosen from the drop down "Product Type". Alternatively, partial SKU numbers may be searched for, or descriptions. When you are satisfied with the parameters of your search, click on the "Search" button on the upper right corner of the list&nbsp;<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-15.png" alt="Image 15" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-15.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="980" height="507" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-211.png" alt="Image 21" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-211.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Click the check box on the left of the products to select the products meant to go into the category. Clicking on the space around the check box is sufficient, there is no need to be too precise. You can choose to display up to 200 products from "View per page" option on top of the list. Alternatively, the little check box at the top of the list (Beside the label "ID") will select every visible product. When you are finished, click on Save Category &nbsp;<img style="cursor: default; width: 120px; height: 21px;" data-height="21" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-22.png" alt="Image 22" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-22.png">&nbsp;button and the products should now appear on the front-end.</p>
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