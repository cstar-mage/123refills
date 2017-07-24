<?php
 /**
 * GoMage Advanced Navigation Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2011 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 2.1
 * @since        Class available since Release 1.0
 */

function gan_cat_sort($a, $b)
{
   $a_col = ($a->getData('navigation_column') ? $a->getData('navigation_column') : 1); 
   $b_col = ($b->getData('navigation_column') ? $b->getData('navigation_column') : 1);
   
   if ($a_col == $b_col)
   {
       return ($a->getData('position') < $b->getData('position')) ? -1 : 1;
   }
   else
   {
       return ($a_col < $b_col) ? -1 : 1;
   }   
}

function gan_cat_slide_sort($a, $b)
{
   $a_col = ($a->getData('navigation_column_side') ? $a->getData('navigation_column_side') : 1); 
   $b_col = ($b->getData('navigation_column_side') ? $b->getData('navigation_column_side') : 1);
   
   if ($a_col == $b_col)
   {
       return ($a->getData('position') < $b->getData('position')) ? -1 : 1;
   }
   else
   {
       return ($a_col < $b_col) ? -1 : 1;
   }   
}


class GoMage_Navigation_Block_Navigation extends Mage_Core_Block_Template
{
    
    const MENU_BAR = 1;
    const LEFT_COLUMN = 2;
    const RIGTH_COLUMN = 3;
    
    protected $_categoryInstance = null;
    
    protected $_type_navigation = null;  
    
    protected $_childs_count = 0;    
    protected $_columns = 0;   
    protected $_current_column = 0;
    protected $_root_level = 0;
    protected $_plain_image = '';

    protected $_navigation_place = self::MENU_BAR;

    /**
     * Array of level position counters
     *
     * @var array
     */
    protected $_itemLevelPositions = array();
    
    public function SetNavigationPlace($place)
    {
        $this->_navigation_place = $place;
    }
    
    public function getTypeNavigation()
    {
        if ($this->_type_navigation) 
            return $this->_type_navigation;
        
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  if(Mage::helper('gomage_navigation')->isGomageNavigation())  
                      $this->_type_navigation = Mage::getStoreConfig('gomage_navigation/menubarsettings/navigation');
                  else
                      $this->_type_navigation = GoMage_Navigation_Model_Layer::FILTER_TYPE_DEFAULT;    
                break;
            case self::LEFT_COLUMN :
                  $this->_type_navigation = Mage::getStoreConfig('gomage_navigation/category/filter_type');
                break;    
            case self::RIGTH_COLUMN :
                  $this->_type_navigation = Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/filter_type');
                break;        
                
        }        
            
        return $this->_type_navigation; 
    }
    
    public function getIsAjax()
    {
        if ($this->getTypeNavigation() == GoMage_Navigation_Model_Layer::FILTER_TYPE_DEFAULT_PRO)
            return false;
            
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return false;
                break;
            case self::LEFT_COLUMN :                  
                  if (!(Mage::registry('current_category') || (Mage::app()->getFrontController()->getRequest()->getRouteName() == 'catalogsearch')))
                     return false;
                  else 
                     return (Mage::getStoreConfig('gomage_navigation/category/ajax_enabled') == 1) && 
                             Mage::registry('current_category') && 
                             Mage::registry('current_category')->getisAnchor() &&
                             (Mage::registry('current_category')->getDisplayMode() != Mage_Catalog_Model_Category::DM_PAGE);    
                break;    
            case self::RIGTH_COLUMN :
                  if (!(Mage::registry('current_category') || (Mage::app()->getFrontController()->getRequest()->getRouteName() == 'catalogsearch')))
                     return false;
                  else 
                     return (Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/ajax_enabled') == 1) && 
                             Mage::registry('current_category') && 
                             Mage::registry('current_category')->getisAnchor() &&
                             (Mage::registry('current_category')->getDisplayMode() != Mage_Catalog_Model_Category::DM_PAGE);
                break;                        
        }   
    }
    
    public function getAjaxUrl($category)
    {        
        $params = array();
        $params['_current']     = true;
        $params['_nosid']       = true;
        $params['_use_rewrite'] = true;        
        $params['_query']       = array();
        $params['_escape']      = false;	
        $params['_query']['ajax'] = true;
        
        $active_cats = Mage::app()->getFrontController()->getRequest()->getParam('cat');
        $active_cats = explode(',', $active_cats);
        
        if ($this->getIsActiveAjaxCategory($category))
        {           
           $active_cats = array_diff($active_cats, array($category->getId()));
        }
        else
        {
           $active_cats[] = $category->getId();
        }
        
        $active_cats = array_diff($active_cats, array(''));        
        
        if (count($active_cats) > 0)
            $params['_query']['cat'] = implode(',', $active_cats);
        else
            $params['_query']['cat'] = null;        
                        
        return urlencode(Mage::getUrl('*/*/*', $params));
    }
    
    public function getIsActiveAjaxCategory($category)
    {
        if (!$this->getIsAjax())
           return false;
           
        $active_cats = Mage::app()->getFrontController()->getRequest()->getParam('cat');
        $active_cats = explode(',', $active_cats);
        
        return in_array($category->getId(), $active_cats);
        
    }
    
    public function canShowMinimized(){
		        
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return false;
                break;
            case self::LEFT_COLUMN :
                  if('true' === Mage::app()->getFrontController()->getRequest()->getParam('left-category_is_open'))
                  {        		
        			  return false;        		
        		  }elseif('false' === Mage::app()->getFrontController()->getRequest()->getParam('left-category_is_open'))
        		  {        			
        			  return true;        			
        		  }
        		  return (bool) Mage::getStoreConfigFlag('gomage_navigation/category/show_minimized');    
                break;    
            case self::RIGTH_COLUMN :
                  if('true' === Mage::app()->getFrontController()->getRequest()->getParam('right-category_is_open'))
                  {        		
        			  return false;        		
        		  }elseif('false' === Mage::app()->getFrontController()->getRequest()->getParam('right-category_is_open'))
        		  {        			
        			  return true;        			
        		  }
        		  return (bool) Mage::getStoreConfigFlag('gomage_navigation/rightcolumnsettings/show_minimized');
                break;                        
        } 
	}
	
    public function canShowPopup(){
		
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return false;
                break;
            case self::LEFT_COLUMN :
                    return (bool) Mage::getStoreConfigFlag('gomage_navigation/category/show_help');    
                break;    
            case self::RIGTH_COLUMN :
                    return (bool) Mage::getStoreConfigFlag('gomage_navigation/rightcolumnsettings/show_help');
                break;                        
        }		
		
	}
	
    public function getPopupText(){
		
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return null;
                break;
            case self::LEFT_COLUMN :
                    return trim(Mage::getStoreConfig('gomage_navigation/category/popup_text'));    
                break;    
            case self::RIGTH_COLUMN :
                    return trim(Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/popup_text'));
                break;                        
        }				
	}
	
    public function getPopupWidth(){
		
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return 0;
                break;
            case self::LEFT_COLUMN :
                    return (int) Mage::getStoreConfig('gomage_navigation/category/popup_width');    
                break;    
            case self::RIGTH_COLUMN :
                    return (int) Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/popup_width');
                break;                        
        }				
	}
	
	public function getPopupHeight(){
		
	    switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return 0;
                break;
            case self::LEFT_COLUMN :
                    return (int) Mage::getStoreConfig('gomage_navigation/category/popup_height');    
                break;    
            case self::RIGTH_COLUMN :
                    return (int) Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/popup_height');
                break;                        
        }				
	}
	
    public function canShowLabels(){
		
		
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return false;
                break;
            case self::LEFT_COLUMN :
                    return (bool) Mage::getStoreConfigFlag('gomage_navigation/category/show_image_name');    
                break;    
            case self::RIGTH_COLUMN :
                    return (bool) Mage::getStoreConfigFlag('gomage_navigation/rightcolumnsettings/show_image_name');
                break;                        
        }
		
	}
	
    public function getImageWidth(){
		
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return false;
                break;
            case self::LEFT_COLUMN :
                    return (int) Mage::getStoreConfig('gomage_navigation/category/image_width');    
                break;    
            case self::RIGTH_COLUMN :
                    return (int) Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/image_width');
                break;                        
        }        		
	}
	
	public function getImageHeight(){
		
	    switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return false;
                break;
            case self::LEFT_COLUMN :
                    return (int) Mage::getStoreConfig('gomage_navigation/category/image_height');    
                break;    
            case self::RIGTH_COLUMN :
                    return (int) Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/image_height');
                break;                        
        }
		
	}
	
	public function getImageAlign(){
		
	    $image_align = null;
	    
	    switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return $image_align;
                break;
            case self::LEFT_COLUMN :
                    switch(Mage::getStoreConfig('gomage_navigation/category/image_align'))
                    {		
            			default:            				
            				$image_align = 'default';            				
            			break;            			
            			case (1):            				
            				$image_align = 'horizontally';            				
            			break;            			
            			case (2):            				
            				$image_align = '2-columns';            				
            			break;            			
                    }    
                break;    
            case self::RIGTH_COLUMN :
                    switch(Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/image_align'))
                    {		
            			default:            				
            				$image_align = 'default';            				
            			break;            			
            			case (1):            				
            				$image_align = 'horizontally';            				
            			break;            			
            			case (2):            				
            				$image_align = '2-columns';            				
            			break;            			
                    }
                break;                        
        }
	    
		return $image_align;
		
	}
	
    public function canShowCheckbox(){
		
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  return false;
                break;
            case self::LEFT_COLUMN :
                    return (bool) Mage::getStoreConfigFlag('gomage_navigation/category/show_checkbox');    
                break;    
            case self::RIGTH_COLUMN :
                    return (bool) Mage::getStoreConfigFlag('gomage_navigation/rightcolumnsettings/show_checkbox');
                break;                        
        }
				
	}
	
    public function getInBlockHeight(){
		
        switch ($this->_navigation_place)
        {
            case self::LEFT_COLUMN :
                    return Mage::getStoreConfig('gomage_navigation/category/inblock_height');    
                break;    
            case self::RIGTH_COLUMN :
                    return Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/inblock_height');
                break;                        
        }
				
	}
	
    public function getColumnColor(){
		
        switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                    return Mage::helper('gomage_navigation')->formatColor(Mage::getStoreConfig('gomage_navigation/menubarsettings/column_color'));
                break;
            case self::LEFT_COLUMN :
                    return Mage::helper('gomage_navigation')->formatColor(Mage::getStoreConfig('gomage_navigation/category/column_color'));    
                break;    
            case self::RIGTH_COLUMN :
                    return Mage::helper('gomage_navigation')->formatColor(Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/column_color'));                     
                break;                        
        }
				
	}
	
	public function getIsShowAllSubcategories(){
	    switch ($this->_navigation_place)
        {
            case self::MENU_BAR :
                  false;
                break;
            case self::LEFT_COLUMN :
                    return Mage::getStoreConfigFlag('gomage_navigation/category/show_allsubcats');    
                break;    
            case self::RIGTH_COLUMN :
                    return Mage::getStoreConfigFlag('gomage_navigation/rightcolumnsettings/show_allsubcats');                     
                break;                        
        }
	}
	            
    protected function _prepareLayout()
    { 
        parent::_prepareLayout();
        if(Mage::helper('gomage_navigation')->isGomageNavigation()){ 
            $this->getLayout()->getBlock('head')->addCss('css/gomage/advanced-navigation.css'); 
            $this->getLayout()->getBlock('head')->addjs('gomage/category-navigation.js');
        }       
    }

    protected function _construct()
    {                                        
        $this->addData(array(
            'cache_lifetime'    => false,
            'cache_tags'        => array(Mage_Catalog_Model_Category::CACHE_TAG, Mage_Core_Model_Store_Group::CACHE_TAG),
        ));         
    }

    /**
     * Get Key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {        
        $shortCacheId = array(
            'CATALOG_NAVIGATION',
            $this->_navigation_place,
            Mage::app()->getStore()->getId(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template'),
            Mage::getSingleton('customer/session')->getCustomerGroupId(),            
            'template' => $this->getTemplate(),
            'name' => $this->getNameInLayout(),
            'cats' => Mage::app()->getFrontController()->getRequest()->getParam('cat') 
        );
        $cacheId = $shortCacheId;

        $shortCacheId = array_values($shortCacheId);
        $shortCacheId = implode('|', $shortCacheId);
        $shortCacheId = md5($shortCacheId);

        $cacheId['category_path'] = $this->getCurrenCategoryKey();
        $cacheId['short_cache_id'] = $shortCacheId;

        return $cacheId;
    }

    public function getCurrenCategoryKey()
    {
        if ($category = Mage::registry('current_category')) {
            return $category->getPath();
        } else {
            return Mage::app()->getStore()->getRootCategoryId();
        }
    }

    /**
     * Get catagories of current store
     *
     * @return Varien_Data_Tree_Node_Collection
     */
    public function getStoreCategories($root_category = null)
    {                
        if (is_null($root_category)){
            $root_category = Mage::app()->getStore()->getRootCategoryId();
        }
        $tree = Mage::getResourceModel('catalog/category_tree');        
        $nodes = $tree->loadNode($root_category)
            ->loadChildren(max(0, (int) Mage::app()->getStore()->getConfig('catalog/navigation/max_depth')))
            ->getChildren();
                    
        $collection = Mage::getResourceModel('catalog/category_collection')->setLoadProductCount(true);    
        $collection->addAttributeToSelect('*');    
                
        $tree->addCollectionData($collection, Mage::app()->getStore()->getId(), $root_category, true, true);
            
        return $nodes;    
    }

    /**
     * Retrieve child categories of current category
     *
     * @return Varien_Data_Tree_Node_Collection
     */
    public function getCurrentChildCategories()
    {
        $layer = Mage::getSingleton('catalog/layer');
        $category   = $layer->getCurrentCategory();
        /* @var $category Mage_Catalog_Model_Category */
        $categories = $category->getChildrenCategories();
        $productCollection = Mage::getResourceModel('catalog/product_collection');
        $layer->prepareProductCollection($productCollection);
        $productCollection->addCountToCategories($categories);
        return $categories;
    }

    /**
     * Checkin activity of category
     *
     * @param   Varien_Object $category
     * @return  bool
     */
    public function isCategoryActive($category)
    {
        if ($this->getCurrentCategory()) {
            return in_array($category->getId(), $this->getCurrentCategory()->getPathIds());
        }
        return false;
    }

    protected function _getCategoryInstance()
    {
        if (is_null($this->_categoryInstance)) {
            $this->_categoryInstance = Mage::getModel('catalog/category');
        }
        return $this->_categoryInstance;
    }

    /**
     * Get url for category data
     *
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function getCategoryUrl($category)
    {        
        if ($category instanceof Mage_Catalog_Model_Category) {
            $url = $category->getUrl();            
        } else {              
            $url = $this->_getCategoryInstance()
                ->setData($category->getData())
                ->getUrl();
        }

        return Mage::getModel('core/url')->sessionUrlVar($url);
    }

    /**
     * Return item position representation in menu tree
     *
     * @param int $level
     * @return string
     */
    protected function _getItemPosition($level)
    {
        if ($level == 0) {
            $zeroLevelPosition = isset($this->_itemLevelPositions[$level]) ? $this->_itemLevelPositions[$level] + 1 : 1;
            $this->_itemLevelPositions = array();
            $this->_itemLevelPositions[$level] = $zeroLevelPosition;
        } elseif (isset($this->_itemLevelPositions[$level])) {
            $this->_itemLevelPositions[$level]++;
        } else {
            $this->_itemLevelPositions[$level] = 1;
        }

        $position = array();
        for($i = 0; $i <= $level; $i++) {
            if (isset($this->_itemLevelPositions[$i])) {
                $position[] = $this->_itemLevelPositions[$i];
            }
        }
        return implode('-', $position);
    }
    
    public function getResizedImage($image, $width = null, $height = null, $quality = 100) 
    {                
        $imageUrl = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "category" . DS . $image;
        if (! is_file ( $imageUrl ))
            return false;
        
        $imageResized = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "product" . DS . "cache" . DS . "cat_resized" . DS . $image;
        if (! file_exists ( $imageResized ) && file_exists ( $imageUrl ) || file_exists($imageUrl) && filemtime($imageUrl) > filemtime($imageResized)) 
        {
            $imageObj = new Varien_Image ( $imageUrl );
            $imageObj->constrainOnly ( true );
            //$imageObj->keepAspectRatio ( true );
            $imageObj->keepFrame ( false );
            $imageObj->quality ( $quality );
            if ($width) 
               $imageObj->resize ( $width, ($height ? $height : null) );
            $imageObj->save ( $imageResized );
        }
        
        if(file_exists($imageResized)){
            return $image;
        }else{
            return false;
        }    
    } 
        
    function sort_category($array)
    {        
        if ($this->_navigation_place == self::MENU_BAR)
           usort($array, "gan_cat_sort");
        else
           usort($array, "gan_cat_slide_sort");  
        
        return $array;
    }

    /**
     * Render category to html
     *
     * @param Mage_Catalog_Model_Category $category
     * @param int Nesting level number
     * @param boolean Whether ot not this item is last, affects list item class
     * @param boolean Whether ot not this item is first, affects list item class
     * @param boolean Whether ot not this item is outermost, affects list item class
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @param boolean Whether ot not to add on* attributes to list item
     * @return string
     */
    protected function _renderCategoryMenuItemHtml($category, $level = 0, $isLast = false, $isFirst = false,
        $isOutermost = false, $outermostItemClass = '', $childrenWrapClass = '', $noEventAttributes = false)
    {
        if (!$category->getIsActive()) {
            return '';
        }
        $html = array();

        // get all children        
        $children = $category->getChildren();
        $childrenCount = $children->count();
        
        $hasChildren = ($children && $childrenCount);

        // select active children
        $activeChildren = array();
        foreach ($children as $child) {
            if ($child->getIsActive()) {
                $activeChildren[] = $child;
            }
        }
        $activeChildrenCount = count($activeChildren);
        $hasActiveChildren = ($activeChildrenCount > 0);

        // prepare list item html classes
        $classes = array();
        $classes[] = 'level' . $level;
        $classes[] = 'nav-' . $this->_getItemPosition($level);

        if ($this->_navigation_place == self::MENU_BAR)
        {
            if ($this->isCategoryActive($category)) {
                $classes[] = 'active';
            }
        }
                
        $linkClass = '';
        if ($isOutermost && $outermostItemClass) {
            $classes[] = $outermostItemClass;
            $linkClass = ' class="'.$outermostItemClass.'"';            
        }
        if ($isFirst) {
            $classes[] = 'first';
        }
        if ($isLast) {
            $classes[] = 'last';
        }
        if ($hasActiveChildren) {
            $classes[] = 'parent';
        }

        // prepare list item attributes
        $attributes = array();
        if (count($classes) > 0) {
            $attributes['class'] = implode(' ', $classes);
        }
        
        
        switch ($this->getTypeNavigation())
        {
            case GoMage_Navigation_Model_Layer::FILTER_TYPE_DROPDOWN:
                
                if ($this->getIsAjax())                
                    $attributes['onchange'] = "setNavigationUrl(this.value); return false;";                
                else                
                    $attributes['onchange'] = "window.location=this.value";
                    
                
                $curent_id = 0;
                if (Mage::registry('current_category')) $curent_id = Mage::registry('current_category')->getId();
                
                if ($category->getLevel() == $this->_root_level)
                {
                    $htmlSel = '<li><select';
                    foreach ($attributes as $attrName => $attrValue) {
                        $htmlSel .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
                    }
                    $htmlSel .= '>';
                    $html[] = $htmlSel;

                    $option_value = ($this->getIsAjax() ? $this->getAjaxUrl($category) : $this->getCategoryUrl($category) );
                    
                    $html[] = '<option class="gan-dropdown-top" value=' . $option_value . '>' . (str_repeat('&nbsp;&nbsp;', $category->getLevel() - $this->_root_level) . $category->getName()) . '</option>';
                    
                }
                                                 
                $option_selected = ( $curent_id == $category->getId() ? 'selected="selected"' : '');
                $option_value = ($this->getIsAjax() ? $this->getAjaxUrl($category) : $this->getCategoryUrl($category) );
        
                $html[] = '<option ' . $option_selected . ' value=' . $option_value . '>' . (str_repeat('&nbsp;&nbsp;', $category->getLevel() - $this->_root_level) . $category->getName()) . '</option>';
        
                // render children
                $htmlChildren = '';
                $j = 0;
                foreach ($activeChildren as $child) {
                    $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                        $child,
                        ($level + 1),
                        ($j == $activeChildrenCount - 1),
                        ($j == 0),
                        false,
                        $outermostItemClass,
                        $childrenWrapClass,
                        $noEventAttributes
                    );
                    $j++;
                }
                if (!empty($htmlChildren)) {
                    
                    $html[] = $htmlChildren;
                    
                } 
                if ($category->getLevel() == $this->_root_level) $html[] = '</select></li>';  
                
                break;
            case GoMage_Navigation_Model_Layer::FILTER_TYPE_PLAIN: 

                $linkClass = '';
                if ($isOutermost && $outermostItemClass) {                    
                    $linkClass = $outermostItemClass;                                
                }                
                if ($this->getIsActiveAjaxCategory($category) || $this->isCategoryActive($category))
                {
                    $linkClass .= ' active';
                }
                
                $linkClass = ' class="'.$linkClass.'" ';
                
                if ($category->getLevel() == $this->_root_level)
                {
                    if ($hasActiveChildren && !$noEventAttributes) {
                         $attributes['onmouseover'] = 'toggleMenu(this,1)';
                         $attributes['onmouseout'] = 'toggleMenu(this,0)';
                    }
                    
                    $htmlLi = '<li';
                    foreach ($attributes as $attrName => $attrValue) {
                        $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
                    }
                    $htmlLi .= '>';
                    $html[] = $htmlLi;  

                    $htmlA = '<a href="'.$this->getCategoryUrl($category).'"'.$linkClass;        
                    if ($this->getIsAjax())
                    {
                        $htmlA .= ' onclick="setNavigationUrl(\'' . $this->getAjaxUrl($category) . '\'); return false;" ';
                    }
                    $htmlA .= '>';
                    
                    $html[] = $htmlA;
                    
                    $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';
                    $html[] = '</a>';
                    
                    if ($hasActiveChildren)
                    { 
                       if ($this->_navigation_place == self::MENU_BAR) 
                           $_width = $category->getData('navigation_pw_width');
                       else    
                           $_width = $category->getData('navigation_pw_side_width');
                           
                       $gan_plain_style = ($this->_navigation_place == self::MENU_BAR ? 'background-color: ' . $this->getColumnColor() . ';' : '') .  ($_width ? 'width: ' . $_width . 'px;' : '');
                       if ($gan_plain_style){
                           $gan_plain_style = 'style="' . $gan_plain_style . '"'; 
                       } 
                           
                       $html[] = '<div ' . $gan_plain_style . ' class="gan-plain" >';
                       
                       if (!($this->_navigation_place == self::MENU_BAR))                       
                           $html[] = '<span class="gan-plain-border"></span>';
                       

                       $_add_style = '';
                       
                       if ($this->_navigation_place == self::MENU_BAR) 
                       {                       
                           $navigation_image = $category->getData('navigation_image');
                           $navigation_image_position = $category->getData('navigation_image_position');
                    
                           if ($navigation_image) 
                               $navigation_image = $this->getResizedImage($navigation_image, $category->getData('navigation_image_width'), $category->getData('navigation_image_height'));
                                   
                               
                           if ($navigation_image)
                           {
                                $_add_image_style = '';
                                if ($category->getData('navigation_image_width'))
                                   $_add_image_style = 'width:' . $category->getData('navigation_image_width') . 'px;';
                                if ($category->getData('navigation_image_height'))
                                   $_add_image_style .= 'height:' . $category->getData('navigation_image_height') . 'px;';   
                                   
                                if ($_add_image_style){
                                    $_add_image_style = 'style="' . $_add_image_style . '"';
                                }   
                                $this->_plain_image  = '<div class="' . GoMage_Navigation_Model_Adminhtml_System_Config_Source_Category_Image_Position::getPositionClass($navigation_image_position) . '">';                            
                                $this->_plain_image .= '<img ' . $_add_image_style . ' src="' . Mage::getBaseUrl ( 'media' ) ."catalog/product/cache/cat_resized/" . $navigation_image . '" alt="' . $this->escapeHtml($category->getName()) . '" />';
                                $this->_plain_image .= '</div>';
                                
                                $imageObj = new Varien_Image(Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "product" . DS . "cache" . DS . "cat_resized" . DS . $navigation_image);
                                                             
                                switch ($navigation_image_position)
                                {
                                    case GoMage_Navigation_Model_Adminhtml_System_Config_Source_Category_Image_Position::RIGHT:
                                         $_add_style = ' style="margin-right: ' . ((int)($category->getData('navigation_image_width') ? $category->getData('navigation_image_width') : $imageObj->getOriginalWidth()) + 10) . 'px;" ';
                                         $html[] = $this->_plain_image;
                                         $this->_plain_image = '';
                                        break;
                                    case GoMage_Navigation_Model_Adminhtml_System_Config_Source_Category_Image_Position::TOP:
                                         $html[] = $this->_plain_image;
                                         $this->_plain_image = '';
                                        break;     
                                    case GoMage_Navigation_Model_Adminhtml_System_Config_Source_Category_Image_Position::BOTTOM:
                                        break;    
                                    default:    
                                    case GoMage_Navigation_Model_Adminhtml_System_Config_Source_Category_Image_Position::LEFT:
                                         $_add_style = ' style="margin-left: ' . ((int)($category->getData('navigation_image_width') ? $category->getData('navigation_image_width') : $imageObj->getOriginalWidth()) + 10) . 'px;" ';
                                         $html[] = $this->_plain_image;
                                         $this->_plain_image = ''; 
                                        break;
                                }
                                
                           }                       
                       }
                       
                       $html[] = '<div ' . $_add_style . ' class="gan-plain-items">';
                                                                     
                       $activeChildren = $this->sort_category($activeChildren);
                                                                     
                    }                     
                }    
                else
                {        
                     $_cat_column = null;
                     if ($category->getLevel() == ($this->_root_level + 1))
                     {
                          if ($this->_navigation_place == self::MENU_BAR)
                              $_cat_column = ($category->getData('navigation_column') ? $category->getData('navigation_column') : 1);
                          else
                              $_cat_column = ($category->getData('navigation_column_side') ? $category->getData('navigation_column_side') : 1);      
                     }               
                     
                     if (($this->_childs_count == 1) || ($_cat_column && ($_cat_column != $this->_current_column)))                     
                     {
                        $this->_current_column = $_cat_column;  
                        $_with_percent = floor(100/$this->_columns);

                        if ($this->_childs_count != 1)
                           $html[] = '</ul>';
                           
                        $html[] = '<ul style="width:' . $_with_percent . '%;" class="gan-plain-item">';
                     }
                                          
                     $html[] = '<li' . ($category->getLevel() == ($this->_root_level + 1) ? ' class="gan-plain-item-bold" ' : '') . '>';                         
                     $htmlA = '<a style="padding-left: ' .  (10*($category->getLevel() - ($this->_root_level + 1))) . 'px;" href="'.$this->getCategoryUrl($category).'"'.$linkClass;
                              
                     if ($this->getIsAjax())
                     {
                        $htmlA .= ' onclick="setNavigationUrl(\'' . $this->getAjaxUrl($category) . '\'); return false;" ';
                     }
                     $htmlA .= '>';                    
                     $html[] = $htmlA;
                     
                     
                     $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';                         
                     $html[] = '</a>';
                     $html[] = '</li>';                                                  
                }
        
                // render children
                $htmlChildren = '';
                $j = 0;
                foreach ($activeChildren as $child) {
                                                                                
                    $this->_childs_count++;    
                    
                    $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                        $child,
                        ($level + 1),
                        ($j == $activeChildrenCount - 1),
                        ($j == 0),
                        false,
                        $outermostItemClass,
                        $childrenWrapClass,
                        $noEventAttributes
                    );
                    $j++;                                            
                }
                if (!empty($htmlChildren)) {
                    
                    $html[] = $htmlChildren;
                    
                }  
                if ($category->getLevel() == $this->_root_level)
                {  

                    if ($hasActiveChildren)
                    {
                       $html[] = '</ul>';  
                       $html[] = '</div>'; //gan-plain-items
                       if ($this->_plain_image)
                       {
                           $html[] = $this->_plain_image;
                           $this->_plain_image = '';
                       }    
                       $html[] = '</div>'; //gan-plain
                    }   
                    $html[] = '</li>';
                }    

                break;

            case GoMage_Navigation_Model_Layer::FILTER_TYPE_FOLDING:
                                
                $htmlLi = '<li';
                foreach ($attributes as $attrName => $attrValue) {
                    $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
                }
                $htmlLi .= '>';
                $html[] = $htmlLi;
                
                $htmlA  = '<a href="'.$this->getCategoryUrl($category).'"';
                $htmlA .= ' style="padding-left: ' .  (10*($category->getLevel() - $this->_root_level)) . 'px;" ';
                        
                if ($this->getIsAjax())
                {
                    $htmlA .= ' onclick="setNavigationUrl(\'' . $this->getAjaxUrl($category) . '\'); return false;" ';
                }
                
                if ($this->getIsActiveAjaxCategory($category) || $this->isCategoryActive($category))
                {
                    $htmlA .= ' class="active" ';
                }
                                                
                $htmlA .= '>';
                
                $html[] = $htmlA; 
                $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';
                $html[] = '</a>';
        
                // render children
                $htmlChildren = '';
                $j = 0;
                foreach ($activeChildren as $child) {
                    $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                        $child,
                        ($level + 1),
                        ($j == $activeChildrenCount - 1),
                        ($j == 0),
                        false,
                        $outermostItemClass,
                        $childrenWrapClass,
                        $noEventAttributes
                    );
                    $j++;
                }
                if (!empty($htmlChildren)) {
                    
                    $html[] = $htmlChildren;
                    
                }    
                $html[] = '</li>';
                break;   
            case GoMage_Navigation_Model_Layer::FILTER_TYPE_IMAGE:
                
                $htmlLi = '<li';
                foreach ($attributes as $attrName => $attrValue) {
                    $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
                }
                $htmlLi .= '>';
                $html[] = $htmlLi;
                                        
                $htmlA = '<a href="'.$this->getCategoryUrl($category).'"';
                              
                if ($this->getIsAjax())
                {
                    $htmlA .= ' onclick="setNavigationUrl(\'' . $this->getAjaxUrl($category) . '\'); return false;" ';
                }
                if ($this->getIsActiveAjaxCategory($category) || $this->isCategoryActive($category))
                {
                    $htmlA .= ' class="active" ';
                }
                
                $htmlA .= '>';                    
                $html[] = $htmlA;
                
                $image_url = $category->getData('filter_image');
                if ($image_url)
                {
                    $image_url = Mage::getBaseUrl('media').'/catalog/category/' . $image_url;
                    
                    if($image_width = $this->getImageWidth()){
                		$image_width = 'width="'.$image_width.'"';
                	}else{
                		$image_width = '';
                	}
                	if($image_height = $this->getImageHeight()){
                		$image_height = 'height="'.$image_height.'"';
                	}else{
                		$image_height = '';
                	}
                    
                    $html[] = '<img ' . $image_width . ' ' . $image_height . ' title="' . $category->getName() . '" src="' . $image_url . '" alt="' . $category->getName() . '" />';
                    
                }
                
                if ($this->canShowLabels())
                {
                    $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';
                }
                    
                $html[] = '</a>';
                        
                $html[] = '</li>';
                break;
                
            case GoMage_Navigation_Model_Layer::FILTER_TYPE_DEFAULT_PRO:    
                if ($hasActiveChildren && !$noEventAttributes) {
                         $attributes['onmouseover'] = 'toggleMenu(this,1)';
                         $attributes['onmouseout'] = 'toggleMenu(this,0)';
                    }
                    // assemble list item with attributes
                    $htmlLi = '<li';
                    foreach ($attributes as $attrName => $attrValue) {
                        $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
                    }
                    $htmlLi .= '>';
                    $html[] = $htmlLi;
                                            
                    $htmlA = '<a href="'.$this->getCategoryUrl($category).'"';
                                  
                    if ($this->getIsAjax())
                    {
                        $htmlA .= ' onclick="setNavigationUrl(\'' . $this->getAjaxUrl($category) . '\'); return false;" ';
                    }
                    if ($this->isCategoryActive($category)) {
                        $htmlA .= ' class="active" ';
                    }
                    $htmlA .= '>';                    
                    
                    $html[] = $htmlA;
                                        
                    $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';
                    $html[] = '</a>';
            
                    // render children
                    $htmlChildren = '';
                    $j = 0;
                    foreach ($activeChildren as $child) {
                        $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                            $child,
                            ($level + 1),
                            ($j == $activeChildrenCount - 1),
                            ($j == 0),
                            false,
                            $outermostItemClass,
                            $childrenWrapClass,
                            $noEventAttributes
                        );
                        $j++;
                    }
                    if (!empty($htmlChildren)) {
                        if ($childrenWrapClass) {
                            $html[] = '<div class="' . $childrenWrapClass . '">';
                        }
                        $html[] = '<ul class="level' . $level . '">';
                        $html[] = $htmlChildren;
                        $html[] = '</ul>';
                        if ($childrenWrapClass) {
                            $html[] = '</div>';
                        }
                    }    
                    $html[] = '</li>';
                 break;   
            default:                                   
                if ($this->_navigation_place == self::MENU_BAR)
                {                                
                    if ($hasActiveChildren && !$noEventAttributes) {
                         $attributes['onmouseover'] = 'toggleMenu(this,1)';
                         $attributes['onmouseout'] = 'toggleMenu(this,0)';
                    }
                    // assemble list item with attributes
                    $htmlLi = '<li';
                    foreach ($attributes as $attrName => $attrValue) {
                        $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
                    }
                    $htmlLi .= '>';
                    $html[] = $htmlLi;
                                            
                    $html[] = '<a href="'.$this->getCategoryUrl($category).'"'.$linkClass.'>';                    
                    
                    $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';
                    $html[] = '</a>';
            
                    // render children
                    $htmlChildren = '';
                    $j = 0;
                    foreach ($activeChildren as $child) {
                        $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                            $child,
                            ($level + 1),
                            ($j == $activeChildrenCount - 1),
                            ($j == 0),
                            false,
                            $outermostItemClass,
                            $childrenWrapClass,
                            $noEventAttributes
                        );
                        $j++;
                    }
                    if (!empty($htmlChildren)) {
                        if ($childrenWrapClass) {
                            $html[] = '<div class="' . $childrenWrapClass . '">';
                        }
                        $html[] = '<ul class="level' . $level . '">';
                        $html[] = $htmlChildren;
                        $html[] = '</ul>';
                        if ($childrenWrapClass) {
                            $html[] = '</div>';
                        }
                    }    
                    $html[] = '</li>'; 
                }
                else
                {
                    $htmlLi = '<li';
                    foreach ($attributes as $attrName => $attrValue) {
                        $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
                    }
                    
                    $htmlLi .= '>';
                    $html[] = $htmlLi;
                                            
                    $htmlA  = '<a href="'.$this->getCategoryUrl($category).'"';
                    $htmlA .= ' style="padding-left: ' .  (10*($category->getLevel() - $this->_root_level)) . 'px;" ';
                                  
                    if ($this->getIsAjax())
                    {
                        $htmlA .= ' onclick="setNavigationUrl(\'' . $this->getAjaxUrl($category) . '\'); return false;" ';
                    }
                    if ($this->getIsActiveAjaxCategory($category) || $this->isCategoryActive($category))
                    {
                        $htmlA .= ' class="active" ';
                    }
                    $htmlA .= '>';                    
                    $html[] = $htmlA;
                    
                    
                    $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';
                    $html[] = '</a>';
            
                    // render children
                    $htmlChildren = '';
                    $j = 0;
                    
                    if ($this->getIsActiveAjaxCategory($category) || $this->getIsShowAllSubcategories())
                    {
                        foreach ($activeChildren as $child) {
                            $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                                $child,
                                ($level + 1),
                                ($j == $activeChildrenCount - 1),
                                ($j == 0),
                                false,
                                $outermostItemClass,
                                $childrenWrapClass,
                                $noEventAttributes
                            );
                            $j++;
                        }
                    }
                    
                    
                    if (!empty($htmlChildren)) {
                        if ($childrenWrapClass) {
                            $html[] = '<div class="' . $childrenWrapClass . '">';
                        }
                        $html[] = '<ul class="level' . $level . '">';
                        $html[] = $htmlChildren;
                        $html[] = '</ul>';
                        if ($childrenWrapClass) {
                            $html[] = '</div>';
                        }
                    }    
                    $html[] = '</li>'; 
                }
        }

        $html = implode("\n", $html);
        return $html;
    }

    /**
     * Render category to html
     *
     * @deprecated deprecated after 1.4
     * @param Mage_Catalog_Model_Category $category
     * @param int Nesting level number
     * @param boolean Whether ot not this item is last, affects list item class
     * @return string
     */
    public function drawItem($category, $level = 0, $last = false)
    {
        return $this->_renderCategoryMenuItemHtml($category, $level, $last);
    }

    /**
     * Enter description here...
     *
     * @return Mage_Catalog_Model_Category
     */
    public function getCurrentCategory()
    {
        if (Mage::getSingleton('catalog/layer')) {
            return Mage::getSingleton('catalog/layer')->getCurrentCategory();
        }
        return false;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getCurrentCategoryPath()
    {
        if ($this->getCurrentCategory()) {
            return explode(',', $this->getCurrentCategory()->getPathInStore());
        }
        return array();
    }

    /**
     * Enter description here...
     *
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function drawOpenCategoryItem($category) {
        $html = '';
        if (!$category->getIsActive()) {
            return $html;
        }

        $html.= '<li';

        if ($this->isCategoryActive($category)) {
            $html.= ' class="active"';
        }

        $html.= '>'."\n";
        $html.= '<a href="'.$this->getCategoryUrl($category).'"><span>'.$this->htmlEscape($category->getName()).'</span></a>'."\n";

        if (in_array($category->getId(), $this->getCurrentCategoryPath())){
            $children = $category->getChildren();
            $hasChildren = $children && $children->count();

            if ($hasChildren) {
                $htmlChildren = '';
                foreach ($children as $child) {
                    $htmlChildren.= $this->drawOpenCategoryItem($child);
                }

                if (!empty($htmlChildren)) {
                    $html.= '<ul>'."\n"
                            .$htmlChildren
                            .'</ul>';
                }
            }
        }
        $html.= '</li>'."\n";
        return $html;
    }

    /**
     * Render categories menu in HTML
     *
     * @param int Level number for list item class to start from
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @return string
     */
    public function renderCategoriesMenuHtml($level = 0, $outermostItemClass = '', $childrenWrapClass = '')
    {
        $activeCategories = array();
        
        $_root_category = Mage::app()->getStore()->getRootCategoryId();
        switch ($this->_navigation_place)
        {            
            case self::LEFT_COLUMN :  
            case self::RIGTH_COLUMN :
                  if ($this->getTypeNavigation() == GoMage_Navigation_Model_Layer::FILTER_TYPE_DEFAULT_PRO)
                  {
                     $_root_category = Mage::app()->getStore()->getRootCategoryId(); 
                  }
                  elseif (Mage::registry('current_category'))
                  {
                     $_root_category = Mage::registry('current_category')->getId();
                  }
                break;                        
        }   
        
        $this->_root_level = Mage::getModel('catalog/category')->load($_root_category)->getLevel() + 1;
        
        foreach ($this->getStoreCategories($_root_category) as $child) {
            if ($child->getIsActive()) {                
                switch ($this->_navigation_place){
                    case self::LEFT_COLUMN :
                        if (Mage::getStoreConfig('gomage_navigation/category/hide_empty') && 
                            !$child->getProductCount()){	                	    
	                	    continue 2;	                	    
	                	} 
                    break;
                    case self::RIGTH_COLUMN :
                        if (Mage::getStoreConfig('gomage_navigation/rightcolumnsettings/hide_empty') && 
                            !$child->getProductCount()){	                	    
	                	    continue 2;	                	    
	                	} 
                    break;                                
                }
                $activeCategories[] = $child;                
            }
        }
        
        $activeCategoriesCount = count($activeCategories);
        $hasActiveCategoriesCount = ($activeCategoriesCount > 0);

        if (!$hasActiveCategoriesCount) {
            return '';
        }

        $html = '';
        $j = 0;        
        foreach ($activeCategories as $category) {
                                                                                                
            $children = $category->getChildren();
            $childrenCount = $children->count();            
            $hasChildren = ($children && $childrenCount);
    
            $columns = array();
            $columns[] = 1;
            foreach ($children as $child) {
                if ($child->getIsActive()) {
                                                            
                    if ($this->_navigation_place == self::MENU_BAR)
                       $_column = ($child->getData('navigation_column') ? $child->getData('navigation_column') : 1);
                    else
                       $_column = ($child->getData('navigation_column_side') ? $child->getData('navigation_column_side') : 1);                     
                    
                    if (!in_array($_column, $columns))
                          $columns[] = $_column;  
                }
            }
                        
            $this->_columns = count($columns);
            $this->_current_column =  min($columns); 
            $this->_childs_count = 0;
            $this->_plain_image = '';
                           
            $html .= $this->_renderCategoryMenuItemHtml(
                $category,
                $level,
                ($j == $activeCategoriesCount - 1),
                ($j == 0),
                true,
                $outermostItemClass,
                $childrenWrapClass,
                true
            );
            $j++;
        }

        return $html;
    }

}