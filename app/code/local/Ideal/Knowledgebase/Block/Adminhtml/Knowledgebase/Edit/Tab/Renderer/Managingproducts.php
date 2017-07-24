<script>
function managingproducts_displaydata(strid)
{
	jQuery(".knowledgebase_content").css("display","none");
	jQuery("#" + strid).css("display","block");
	//jQuery(document).scrollTo("#" + strid);
	jQuery('html, body').animate({
        scrollTop: jQuery("#" + strid).offset().top
    }, 1000);
}
</script>
<?php
class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Renderer_Managingproducts extends Varien_Data_Form_Element_Text
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
    		$str = '<ul class="managingproducts">';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'add_product\'); ">';
    			//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=image_to_product">';
    				$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
    				$str .= '<span>Add Product</span>';
    				$str .= '<span class="ex_name">(Add a Single Product)</span>';
    			$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'update_product_to_update_multiple_products\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=batch_processing">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Using Update Product to Update Multiple Products</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'prepare_a_data_sheet_for_uploading\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=product_image_preparation">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>How to Prepare a Data Sheet (CSV) for Uploading</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'call_for_price_feature\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=changing_your_password">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Call for Price Feature</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
    			$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'working_with_attributes\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Working with Attributes</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'working_with_filters\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Working with Filters</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'mass_product_update\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Mass Product Update</span>';
		    		//$str .= '<span class="ex_name">(Image to Product)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'adding_sizes_to_products\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Adding Sizes to Products</span>';
		    		$str .= '<span class="ex_name">(Advanced Product Options/Special Options)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'attribute_sets\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Attribute Sets</span>';
		    		//$str .= '<span class="ex_name">(Advanced Product Options/Special Options)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'how_to_add_attributes\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>How to Add Attributes</span>';
		    		//$str .= '<span class="ex_name">(Advanced Product Options/Special Options)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'attribute_and_attribute_sets\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>What is an attribute and what are attribute sets?</span>';
		    		//$str .= '<span class="ex_name">(Advanced Product Options/Special Options)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '<li>';
	    		$str .= '<a href="javascript:" onClick="managingproducts_displaydata(\'sorting_of_products_on_the_list_pages\'); ">';
	    		//$str .= '<a href="http://www.jewelrydemo.com/index.php/knowledgebase/adminhtml_knowledgebase/knowledgebase?general=getting_into_admin_backend">';
		    		$str .= '<img src="http://www.idealbrandmarketing.com/knowledgebase/images/psd.jpg" />';
		    		$str .= '<span>Sorting of Products on the List Pages</span>';
		    		//$str .= '<span class="ex_name">(Advanced Product Options/Special Options)</span>';
	    		$str .= '</a>';
    		$str .= '</li>';
    		$str .= '</ul>';
    	}
		
		//if($_GET['general']=="image_to_product")
		{
			$str .= '<div id="add_product" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
							<h2 class="title">
								Add Product (Add a Single Product)
							</h2>
							<div class="help-text">
								By <b> John Dorsey</b>, Mon, Apr 13 at 10:29 PM
							<span class="label">Permanent</span>
							</div> 
							   <div class="solution_title">
									<div class="tag_list"> 
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607618-add-product-add-a-single-product-/tag_uses/5000247045-products"><i class="icon-close"></i></a>
											products
										</div>
									</div>
							 </div>
							 <span class="seperator"></span>
							 <div class="solutions_text clearfix">
								<p>To add a product individually, go to Catalog &gt; Manage Products&nbsp;</p>
						<p>At the upper right corner of the page, click on "Add Product" <img style="cursor: default;" alt="Image 5" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-52.png" class="alignnone size-full wp-image-6078">button.&nbsp;</p>
						<p>&nbsp;
						<br><img width="1107" height="573" style="cursor: default;" alt="Image 5" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-51.png" class="alignnone &nbsp;wp-image-6066">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>
						<p>A new page will load where you can set the product type and attribute set the product will use. Usually, Simple Product with the default attribute set is chosen.
						Simply click on "Continue" <img style="cursor: default;" alt="Image 7" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-72.png" class="alignnone size-full wp-image-6068"> button to proceed.<br><img width="1115" height="577" style="cursor: default;" alt="Image 6" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-61.png" class="alignnone &nbsp;wp-image-6067">
						<br><br></p>
						<p>Another page will load containing numerous fields where information may be inputted. Under "General" tab, the Name, Description, Short Description, SKU, Weight, Status are required.&nbsp;</p>
						<p>&nbsp;
						<br><img width="1125" height="578" style="cursor: default;" alt="Image 8" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-82.png" class="alignnone &nbsp;wp-image-6069">
						&nbsp;&nbsp;&nbsp;
						<img width="1125" height="582" style="cursor: default;" alt="Image 9" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-91.png" class="alignnone &nbsp;wp-image-6070">&nbsp;After the required information in "General" is filled out, "Specification" requires Product Type and Gender, although it is recommended to fill out other attributes such as Style, Metal Type and other such attributes that would give a potential buyer more information about the product. Attributes like "Style", "Metal Type Availability" and "Setting" are shown in a list instead of a drop-down menu are multiple-select and as such, more than one option may be chosen. To choose more than one option, hold down "Ctrl" button in the keyboard (Or Cmd on a Macintosh) while clicking the desired options. &nbsp;Remember to click on "Save and Continue Edit" often to ensure all changes are saved and the login session to the admin will not expire due to inactivity.</p>
						<p>&nbsp;
						<img width="1126" height="583" style="cursor: default;" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-105.png" class="alignnone &nbsp;wp-image-6071"> <img width="1122" height="581" style="cursor: default;" alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-113.png" class="alignnone &nbsp;wp-image-6072">&nbsp;</p>
						<p>Next, under "Prices" the Price and Tax-Class are required. Input the price of the product, the Special Price can also be used to easily advertise a promotional price to be displayed. Should you wish to display the special price only from a certain date, the Special Price From Date and Special Price To Date can be used, simply add in the dates. For Tax Class, simply choose "Taxable Goods".
						<br><img width="1133" height="586" style="cursor: default;" alt="Image 12" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-123.png" class="alignnone &nbsp;wp-image-6073">
						astly, to add an image to your new product, go to the "Images" menu and click on "Browse Files" <img alt="Image 14" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-141.png" class="alignnone size-full wp-image-6075"> button at the lower part of the screen. This button will not load if the page has not fully loaded. Browse for your image and select it. When finished, click on "Upload Files" <img alt="Image 15" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-151.png" class="alignnone size-full wp-image-6076"> button. &nbsp;The new image should show on the table.<img width="1142" height="591" style="cursor: default;" alt="Image 13" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-132.png" class="alignnone &nbsp;wp-image-6074">&nbsp;<br>After confirming the image is uploaded, add a label to describe the image if you like and then make sure all the radio buttons of the new image is chosen. If there are numerous images for a product, the primary image should be the one to have the radio buttons selected.</p>
						<p>&nbsp;
						<img width="1171" height="232" style="cursor: default;" alt="Image 21" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-212.png" class="alignnone &nbsp;wp-image-6079">
						<br><br></p>
						<p>When finished, click on "Save" button on the upper right corner. &nbsp;Remember to add your new product to a category from the "Manage Category" or from the left-side menu "Categories" in this Manage Product page, or the product will not be seen yet on any of the categories.
						&nbsp;
						&nbsp;</p>
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
			$str .= '<div id="update_product_to_update_multiple_products" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
						<h2 class="title">
							Using Update Product to Update Multiple Products
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 10:22 PM
							<span class="label">Permanent</span>
						</div> 
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607616-using-update-product-to-update-multiple-products/tag_uses/5000247042-product"><i class="icon-close"></i></a>
										product
									</div>
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607616-using-update-product-to-update-multiple-products/tag_uses/5000247043-update"><i class="icon-close"></i></a>
										update
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">It is&nbsp;possible to&nbsp;update multiple products with different data all at once, without having to go through each individual product one by one.<br><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">First, a&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/how-to-prepare-a-data-sheet-csv-for-uploading/" href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/how-to-prepare-a-data-sheet-csv-for-uploading/" title="How to Prepare a Data Sheet (CSV) for Uploading">CSV data sheet needs to be prepared</a>. This CSV file needs to contain all the necessary details and the new information that will be updated. This article will guide you through that process.<br><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">After this CSV is prepared, go to Catalog&nbsp;&gt; Upload Product<br><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-106.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Click on "Choose File"&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-114.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-114.png"><img alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-114.png"></a>&nbsp;button and choose the CSV file.&nbsp;<i>Make sure the csv filename contains no spaces or special characters.<br><br></i></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Click on "Upload CSV"&nbsp;<img style="cursor: default;" alt="Image 12" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-124.png">&nbsp;button<br><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">A notice should show if the CSV has been successfully uploaded.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 13" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-133.png"></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If the CSV has uploaded successfully, click on "Insert Product in PopUp"&nbsp;<img style="cursor: default;" alt="Image 14" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-142.png">&nbsp;button.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">A new window will pop-up, informing you of the progress. The update can take a lot of time, depending on the amount of information it needs to process.<br><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default; float: none; margin: 0px;" alt="Image 15" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-152.png"><br><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If the csv has been formatted correctly with the right information, no errors should show and the update should be complete.</p>
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
			$str .= '<div id="prepare_a_data_sheet_for_uploading" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
							<h2 class="title">
								How to Prepare a Data Sheet (CSV) for Uploading
							</h2>
							<div class="help-text">
								By <b> John Dorsey</b>, Mon, Apr 13 at 10:25 PM
								<span class="label">Permanent</span>
							</div> 
							  <div class="solution_title">
									<div class="tag_list"> 
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607617-how-to-prepare-a-data-sheet-csv-for-uploading/tag_uses/5000247044-data-sheet"><i class="icon-close"></i></a>
											data sheet
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607617-how-to-prepare-a-data-sheet-csv-for-uploading/tag_uses/5000247045-products"><i class="icon-close"></i></a>
											products
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607617-how-to-prepare-a-data-sheet-csv-for-uploading/tag_uses/5000247046-updating"><i class="icon-close"></i></a>
											updating
										</div>
									</div>
							 </div>
							 <span class="seperator"></span>
							 <div class="solutions_text clearfix">
								<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To update multiple products with different data all at once, without having to go through each individual product one by one, the use of data sheets can be a useful tool to get things done faster.<br><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">The data sheet file type used for the admin backend is called a "csv" and this is a kind of file very similar to an excel sheet, only instead of .xls or .xlsx format, the file is a .csv format.<br><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To create a sheet for uploading, open MS Excel or a similar app. For demonstration purposes, this article will use MS Excel 2010 as an example.<br><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 33" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-33.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">The very first row of this new sheet should be the SKU number, which would be the key referencing point of the system.&nbsp;<strong>Without the SKU, the system will not be able to identify which product\'s values need to be changed, so this is very important.</strong>&nbsp;The following values for B1, C1 and D1 can contain all the other attributes that need to be changed, such as "name", "description" "short description" "status" or even "price". Keep in mind that these are their&nbsp;<strong>attribute&nbsp;codes</strong>, the names that show on the database, not the descriptive names usually seen, which is called an attribute label. As such, they are&nbsp;<strong>case sensitive</strong>&nbsp;and usually contain&nbsp;<strong>no spaces.<br><br></strong></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To find a list of attributes and their specific attribute codes, referring to Catalog &gt; Manage Attributes and searching the attribute label would yield the attribute codes.<br><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="653" height="565" style="cursor: default;" alt="" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-36-e1426586773137.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Alternatively, you can also use the list in a certain attribute set to learn the attribute codes.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="934" height="460" style="cursor: default;" alt="Image 35" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-352.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Once the first rows are filled in properly, the rest of the sheet can be filled out with the proper changes.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 37" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-371.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Take note that changes to attributes that are dropdown or multiple select need to have the values pre-defined and existing before they can be changed. So, if you have "Brand" as one of the attributes you want to change, but have not yet edited the "Brand" attribute to have brands listed in them, they cannot be changed until they are first defined in the attributes. Doing this is covered in another topic, how to manage&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/how-to-add-attributes-and-place-them-in-attribute-sets/" href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/how-to-add-attributes-and-place-them-in-attribute-sets/" title="How to Add Attributes">attributes</a>.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><i>Also, it is not recommended to use the comma "," on any of the fields as this might disrupt the file-formatting.</i></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Once you are done with your datasheet, go to File &gt; Save As and remember to save the sheet in CSV format.&nbsp;<i>Please make sure there are no spaces or special characters in the filename.&nbsp;</i></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 38" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-38.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Several warning pop-ups will show up when creating this format. Simply click "OK" and "Yes" and the file will be generated.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-39.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-39.png"><img style="cursor: default;" alt="Image 39" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-39.png"></a>&nbsp;<img style="cursor: default; width: 752px; height: 158px;" data-height="158" alt="Image 40" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-40.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
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
		//elseif($_GET['general']=="changing_your_password")
		{
			$str .= '<div id="call_for_price_feature" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
							<h2 class="title">
								Call for Price Feature
							</h2>
							<div class="help-text">
								By <b> John Dorsey</b>, Mon, Apr 13 at 10:19 PM	
								<span class="label">Permanent</span>
							</div> 
							  <div class="solution_title">
									<div class="tag_list"> 
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607615-call-for-price-feature/tag_uses/5000247038-call-for-price"><i class="icon-close"></i></a>
											call for price
										</div>
									</div>
							 </div>
							 <span class="seperator"></span>
							 <div class="solutions_text clearfix">
								<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To update existing products with "Call for Price" go to Catalog &gt; Manage Product<br><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">On the left side of each products there is a checkbox, click&nbsp;on all the products that need to be updated. There is no need to precisely check on the little boxes, clicking on the space around the little box will do.<br><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">When you have selected all the products you want to update, go to the upper right corner, "Actions" drop down.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br><img width="1291" height="155" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-23.png" alt="Image 23" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-23.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">A new page will load. At the Update Attribute page, go to the bottom of the page "Replace Price Message/Call"</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 4" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-43.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Click on "Change" and input the desired message to show on the price field. Click on "Save"&nbsp;<img style="cursor: default;" alt="Image 5" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-53.png">&nbsp;button to save changes.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If creating a new product, "Call for Price" is set not under Price left-menu, but under it\'s own menu. Simply place a message into the field and it will display the inputted text instead of a numerical price.<br><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1070" height="456" style="cursor: default;" alt="Image 6" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-62.png"></p>
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
			$str .= '<div id="working_with_attributes" class="knowledgebase_content" ><div id="article-section" class="artical_section">
							<h2 class="title">
								Working with Attributes
							</h2>
							<div class="help-text">
								By <b> John Dorsey</b>, Mon, Apr 13 at 10:16 PM	
								<span class="label">Permanent</span>
							</div> 
							  <div class="solution_title">
									<div class="tag_list"> 
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607612-working-with-attributes/tag_uses/5000247032-attributes"><i class="icon-close"></i></a>
											attributes
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607612-working-with-attributes/tag_uses/5000247033-filters"><i class="icon-close"></i></a>
											filters
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607612-working-with-attributes/tag_uses/5000247034-show-attributes"><i class="icon-close"></i></a>
											show attributes
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607612-working-with-attributes/tag_uses/5000247035-show-filters"><i class="icon-close"></i></a>
											show filters
										</div>
									</div>
							 </div>
							 <span class="seperator"></span>
							 <div class="solutions_text clearfix">
								<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To make an attribute show or not show on the front end, the controls are set under "Visible on Product View Page on Front-end"</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To show the attribute,&nbsp;"Visible on Product View Page on Front-end" must be set to "YES", and for it to not show, it must be set to "NO"</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To make an attribute show as filters on the side of the product list pages, "Use in Search Results Layered Navigation" must be set to "YES", take note this is only available for attributes with multi-select or dropdown types of attributes.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" alt="Image 3" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-312.png"></p>
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
			$str .= '<div id="working_with_filters" class="knowledgebase_content" ><div id="article-section" class="artical_section">
								<h2 class="title">
									Working with Filters
								</h2>
								<div class="help-text">
									By <b> John Dorsey</b>, Mon, Apr 13 at 10:41 PM		
									<span class="label">Permanent</span>
								</div> 
								  <div class="solution_title">
										<div class="tag_list"> 
											<div class="item">			
												  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607621-working-with-filters/tag_uses/5000247032-attributes"><i class="icon-close"></i></a>
												attributes
											</div>
											<div class="item">			
												  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607621-working-with-filters/tag_uses/5000247033-filters"><i class="icon-close"></i></a>
												filters
											</div>
										</div>
								 </div>
								 <span class="seperator"></span>
								 <div class="solutions_text clearfix">
									<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Filters are a way for customers browsing your website to narrow down the product list to items relevant to what they\'re looking for.<br><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Filters are found on the left side of the product list page.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-104.png" alt="Image 10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-104.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Commonly used filters are "Metal Type" and "Product Type" but any filter can be made through the use of&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/what-is-an-attribute-and-how-to-work-with-attributes-and-attribute-sets/" href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/what-is-an-attribute-and-how-to-work-with-attributes-and-attribute-sets/" title="What is an attribute and what are attribute sets?">attributes</a>.<br><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To create a new filter, a corresponding attribute needs to exist. For example, if you wish to have "Brands" as a filter in your product list pages, first there must be a "Brand" attribute. After&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/how-to-add-attributes-and-place-them-in-attribute-sets/" href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/how-to-add-attributes-and-place-them-in-attribute-sets/" title="How to Add Attributes">this attribute is created</a>, set to the appropriate&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/attribute-sets/" href="http://www.idealbrandmarketing.com/knowledgebase/knwbase/attribute-sets/" title="Attribute Sets">attribute set</a>, products must have the proper value of "Brands" in their product attributes in order for the filters to show.<br><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Remember when creating an attribute that only dropdown or multiple-select type attributes are filterable and that "Use in Layered Navigation" option should be set to "Filterable (with results)".<br><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-112.png" alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-112.png"></p>
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
		//if($_GET['general']=="image_to_product")
		{
			$str .= '<div id="mass_product_update" class="knowledgebase_content" ><div id="article-section" class="artical_section">		
							<h2 class="title">
								Mass Product Update
							</h2>
							<div class="help-text">
								By <b> John Dorsey</b>, Thu, Apr 23 at  3:14 AM		
								<span class="label">Permanent</span>
							</div> 
							  <div class="solution_title">
									<div class="tag_list"> 
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607624-mass-product-update/tag_uses/5000247045-products"><i class="icon-close"></i></a>
											products
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607624-mass-product-update/tag_uses/5000247052-change-status"><i class="icon-close"></i></a>
											change status
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607624-mass-product-update/tag_uses/5000247053-mass-upload"><i class="icon-close"></i></a>
											mass upload
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607624-mass-product-update/tag_uses/5000247046-updating"><i class="icon-close"></i></a>
											updating
										</div>
									</div>
							 </div>
							 <span class="seperator"></span>
							 <div class="solutions_text clearfix">
								<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Go to Catalog &gt; Manage Product</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">On the left side of each products there is a checkbox, click&nbsp;on all the products that need to be updated. There is no need to precisely check on the little boxes, clicking on the space around the little box will do.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">When you have selected all the products you want to update, go to the upper right corner, "Actions" drop down.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1291" height="155" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-23.png" alt="Image 23" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-23.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br>Choose either "Change&nbsp;Status" which would enable you to instantly update whether or not a product will be shown in the front end or choose "Update Attributes" to update a certain attribute of multiple products.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">For Change Status, a new dropdown will appear. Choose to "enable" or "disable" and click on submit.<br><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-24.png" alt="Image 24" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-24.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">For update products, a new window will load with all the attributes that apply to all the products.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="895" height="463" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-29.png" alt="Image 29" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-29.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To change an attribute, first the checkbox "Change" must be checked/selected before anything will be editable, as demonstrated below. Once the checkbox is on, the field is now editable.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"></p>
						<p><img style="cursor: default;" data-id="5014516132" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5014516132/original/Image_6.png?1429783949"></p>
						<p><br></p>
						<p><span style="font-size: 16px;">After clicking on "Change" and making the desired changes, click on "save"</span><img data-id="5014516313" class="inline-image" src="https://s3.amazonaws.com/cdn.freshdesk.com/data/helpdesk/attachments/production/5014516313/original/Image_7.png?1429784034"><span style="font-size: 16px; line-height: 1.3;">&nbsp;</span><span style="font-size: 16px; line-height: 1.3;">on the upper right hand corner and the changes should reflect immediately on the front end.&nbsp;</span></p>
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
		//elseif($_GET['general']=="batch_processing")
		{
			$str .= '<div id="adding_sizes_to_products" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
							<h2 class="title">
								Adding Sizes to Products (Advanced Product Options/Special Options)
							</h2>
							<div class="help-text">
								By <b> John Dorsey</b>, Mon, Apr 13 at 10:52 PM	
								<span class="label">Permanent</span>
							</div> 
							  <div class="solution_title">
									<div class="tag_list"> 
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607626-adding-sizes-to-products-advanced-product-options-special-options-/tag_uses/5000247056-advanced-product-options"><i class="icon-close"></i></a>
											advanced product options
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607626-adding-sizes-to-products-advanced-product-options-special-options-/tag_uses/5000247057-special-options"><i class="icon-close"></i></a>
											special options
										</div>
									</div>
							 </div>
							 <span class="seperator"></span>
							 <div class="solutions_text clearfix">
								<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To add advanced product options, or “special options” like sizes, go to the admin backend, Catalog &gt; Advanced Product Options</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="185" height="307" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image07.png" alt="image07" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image07.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">A new page will load, listing existing product options. Buttons on the upper right of the page also enables the creation of new advanced options.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To create new advanced product options, click on the button&nbsp;<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image05.png" alt="image05" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image05.png">&nbsp;and a new screen will load.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1087" height="216" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image12.png" alt="image12" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image12.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Input name of special option in “Title” field, to describe what the option is, such as “Ring Size”. After that, click on the button&nbsp;<img style="cursor: default;" alt="image00" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image00.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><strong>&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image04.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image04.png"><img width="1075" height="166" style="cursor: default;" alt="image04" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image04.png"></a></strong></strong></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">A number of new options will appear. Input title again and choose input type. Usually, dropdown is best. Take note of the other options like “Is Required” which means customers of the website need to choose an option before they can proceed to the cart or not.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Once an input type is selected, another new field will appear.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1058" height="321" data-height="321" style="cursor: default; width: 857px; height: 321px;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image06.png" alt="image06" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image06.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Click on Add New Row button&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image02.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image02.png"><img style="cursor: default;" alt="image02" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image02.png"></a>&nbsp;to make more rows appear.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1083" height="420" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image10.png" alt="image10" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image10.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">In the rows that appear, there will be spaces for title and price. Title is where the special options will go, like size numbers or colors. The price beside the titles is the additional price that will be added to the listed price for choosing such an option.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><strong>&nbsp;</strong></strong></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">When finished, save and continue before going to add products that will use this special option. On the left hand side, under the menu “Product Options” there is “Products”<br>Upon clicking Products, a page with a grid will be shown.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1067" height="272" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image01.png" alt="image01" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image01.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">At first, there will be nothing shown in the grid. To show products, do a simple search. In order to see products which do not currently carry the special option being edited on, the left more dropdown of the grid needs to be selected “No”. To narrow the search even further, searching for the product name (such as “engagement ring”) should be beneficial in mass updating for special products.</p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1058" height="379" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image19.png" alt="image19" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image19.png"></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
						<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To include the special options with the products, simply check the products that apply (Select All is also an option to select every option that falls under the search, along with select visible which only selects what you see in the grid and not the others from the other pages). Those that have the check mark will then carry the special options as soon as the option is saved.</p>
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
			$str .= '<div id="attribute_sets" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
						<h2 class="title">
							Attribute Sets
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 10:54 PM	
							<span class="label">Permanent</span>
						</div> 
						  <div class="solution_title">
								<div class="tag_list"> 
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">After creating a new attribute, that attribute needs to be assigned to an Attribute Set in order to be visible while editing a product.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Find Catalog &gt; Attribute &gt; Attribute Set. There, a list of attribute sets will be shown. The default is “Default” for all jewelry products and “Diamonds” for all loose diamond products. More can be added as necessary.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><strong>&nbsp;</strong></strong></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Click on the attribute set that will get the new attribute and a new page will load, showing the name of the attribute set, the existing attributes in the set under “Groups” and attributes that are not part of the group called “Unassigned Attributes”</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><strong>&nbsp;<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image17-300x155.png" alt="image17" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image17-300x155.png"></strong></strong></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><br></strong></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To assign the new attribute and be able to use it, simply drag the name of the new attribute into the “Groups” list in the desired position</p>
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
		//elseif($_GET['general']=="changing_your_password")
		{
			$str .= '<div id="how_to_add_attributes" class="knowledgebase_content" ><div id="article-section" class="artical_section">
								<h2 class="title">
									How to Add Attributes
								</h2>
								<div class="help-text">
									By <b> John Dorsey</b>, Mon, Apr 13 at 10:58 PM
								<span class="label">Permanent</span>
								</div> 
								  <div class="solution_title">
										<div class="tag_list"> 
											<div class="item">			
												  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607631-how-to-add-attributes/tag_uses/5000247032-attributes"><i class="icon-close"></i></a>
												attributes
											</div>
										</div>
								 </div>
								 <span class="seperator"></span>
								 <div class="solutions_text clearfix">
									<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To add an attribute, select “Manage Attributes” from Catalog tab.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><strong>&nbsp;<img style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image13.png" alt="image13" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image13.png"></strong></strong></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><strong><br></strong></strong></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">When the page loads, a list of attributes is shown. On the upper right Select “Add New Attribute”</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><strong>&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image08.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image08.png"><img width="702" height="143" style="cursor: default;" alt="image08" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image08.png"></a></strong></strong></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To add a new attribute, an attribute code must be typed in. Attribute codes are specific to the backend and won’t be shown in the front end. It’s recommended that attribute codes are all in&nbsp;<i>lowercase</i>&nbsp;and have&nbsp;<i>no spaces.</i></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><strong><strong>&nbsp;<img width="784" height="962" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image09.png" alt="image09" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image09.png"></strong></strong></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Keep in mind the attribute&nbsp;input type. There are many options available to choose from to properly reflect your data.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="616" height="166" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/inputtype.png" alt="inputtype" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/inputtype.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<ul style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">
							<li>Text field is the default, though it is not recommended for use unless the data inputted will often be different</li>
							<li>Text area is a bigger text field, useful for descriptions.</li>
							<li>Date allows the attribute to take in specific dates as the&nbsp;input</li>
							<li>Yes/No means the attribute only takes in Yes or No as data</li>
							<li>Multiple Select allows several options to be chosen as data, for example, attribute metal color as multiple select can allow "yellow gold" "white gold" and "pink gold" to be shown<i>&nbsp;all at once</i>.</li>
							<li>Dropdown allows&nbsp;<i>one</i>&nbsp;option to be chosen as data, for example, attribute metal color as dropdown can only allow&nbsp;<i>one</i>&nbsp;among "yellow gold" "white gold" and "pink gold"&nbsp;<i>only one may be chosen.</i>
							</li>
							<li>Price accepts a numeral value</li>
							<li>Media image allows a picture image to be associate with an attribute</li>
							<li>Take note, for&nbsp;attributes that you wish to make into a filter, only attributes that are&nbsp;<i>dropdown</i>&nbsp;or<i>&nbsp;multiple-select</i>&nbsp;can be filterable.</li>
							</ul>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">After the attribute name, “Manage Label/Options” is where attribute names can be added. The first line under “Default Store View” is where the new attribute’s name should be typed.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="412" height="420" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image11.png" alt="image11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/image11.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If you chose an attribute that requires all inputs to be manually added, "Manage Label/Options will look different."<img width="1054" height="337" style="cursor: default;" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-31.png" alt="Image 3" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-31.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">To begin adding input options, click on Add Option button&nbsp;<a data-mce-href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-41.png" href="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-41.png"><img alt="Image 4" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-41.png"></a>&nbsp;this will make one row appear. clicking on it multiple times will make several rows appear.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img width="1143" height="384" style="cursor: default; height: 384px;" data-height="384" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-6.png" alt="Image 6" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/02/Image-6.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Add the name of the input values into the "Admin" and "Default Store View" field, to the right "Position" is where you can control which one shows first, just input numbers 1, 2, 3 etc. Checking "Is Default" will make the certain input the default value.</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">If you wish to make an attribute filterable, go back to "Properties"</p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><img style="cursor: default; width: 784px; height: 194px;" data-height="194" data-mce-src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-112.png" alt="Image 11" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/03/Image-112.png"></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Scroll down to Frontend Properties. At the "Use in Layered Navigation" option, choose "Filterable (with results)".</p>
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
		//elseif($_GET['general']=="getting_into_admin_backend")
		{
			$str .= '<div id="attribute_and_attribute_sets" class="knowledgebase_content" ><div id="article-section" class="artical_section">		
						<h2 class="title">
							What is an attribute and what are attribute sets?
						</h2>
						<div class="help-text">
							By <b> John Dorsey</b>, Mon, Apr 13 at 10:59 PM	
							<span class="label">Permanent</span>
						</div> 
						  <div class="solution_title">
								<div class="tag_list"> 
									<div class="item">			
										  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000607632-what-is-an-attribute-and-what-are-attribute-sets-/tag_uses/5000247032-attributes"><i class="icon-close"></i></a>
										attributes
									</div>
								</div>
						 </div>
						 <span class="seperator"></span>
						 <div class="solutions_text clearfix">
							<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Attributes are a way to organize certain details pertaining to a product that can be used in numerous ways throughout the site. Examples of attributes are “Product Type” and “Color”.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;"><br></p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">Attribute sets are used to assign a group of attributes to a particular product, so if there are several kinds of products needing different kinds of attribute sets, each kind of product may have its own attribute set. For example, an attribute set for jewelry would have its own attribute set and another attribute set will be made and selected for watches.</p>
					<p style="font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 16px;">&nbsp;<br></p>
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
		//elseif($_GET['general']=="getting_into_admin_backend")
		{
			$str .= '<div id="sorting_of_products_on_the_list_pages" class="knowledgebase_content" ><div id="article-section" class="artical_section">	
							<h2 class="title">
								Sorting of Products on the List Pages
							</h2>
							<div class="help-text">
								By <b> Paulina</b>, Thu, Apr 30 at  3:00 AM	
								<span class="label">Permanent</span>
							</div> 
							  <div class="solution_title">
									<div class="tag_list"> 
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000616440-sorting-of-products-on-the-list-pages/tag_uses/5000259781-sort"><i class="icon-close"></i></a>
											sort
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000616440-sorting-of-products-on-the-list-pages/tag_uses/5000247042-product"><i class="icon-close"></i></a>
											product
										</div>
										<div class="item">			
											  <a rel="nofollow" data-method="delete" class="tag_delete" href="/solution/categories/5000038864/folders/5000254466/articles/5000616440-sorting-of-products-on-the-list-pages/tag_uses/5000247045-products"><i class="icon-close"></i></a>
											products
										</div>
									</div>
							 </div>
							 <span class="seperator"></span>
							 <div class="solutions_text clearfix">
								<p>Per each category, you can adjust the sorting in Catalog &gt; Manage Categories</p>
						<p><br></p>
						<p><img width="188" height="302" alt="Inline image 2" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/sorting_of_products_image1.png" /><br></p>
						<p><br></p>
						<p>Then choose the category where you want the products to be sorted and click on "Display Settings" tab.</p>
						<p><br></p>
						<p><img width="562" height="321" style="cursor: default;" alt="Inline image 3" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/sorting_of_products_image2.png" /></p>
						<p>On "Display Settings" go to "Default Product Listing Sort By" and uncheck the "Use Config Settings" and then choose which best applies from the dropdown menu.</p>
						<p><br></p>
						<p><img width="562" height="404" style="cursor: default;" alt="Inline image 1" src="http://www.idealbrandmarketing.com/knowledgebase/wp-content/uploads/2015/04/sorting_of_products_image3.png" /></p>
						<p>Then click on "Save" on the upper right corner.</p>
						<div style="font-family: arial, sans-serif;" dir="ltr"><div style="font-size: 11px; font-weight: bold; text-align: center; color: rgb(68, 68, 68); border: 1px solid rgb(115, 115, 115); margin-left: 8px; background: rgba(0, 0, 0, 0.6);" data-tooltip="Download" data-tooltip-class="a1V" id=":1s8"><div><p></p></div></div></div>
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