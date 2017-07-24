<?php

/**
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Block_Adminhtml_Help
    extends Mage_Adminhtml_Block_Template
{

    /**
     * Image file holder
     *
     * @var string
     */
    private $_imgSrc = '';


    /**
     * Set the image file
     */
    public function _construct()
    {
        parent::_construct();

        $this->_imgSrc = Mage::getDesign()->getSkinUrl(
            'images/dyncatprod/tooltip.png'
        );

    }

    /**
     * Get relevant path to template
     * The template name is set to the element type
     *
     * @return string
     */
    public function getTemplate()
    {
        $this->_template
            = 'dyncatprod/help/' . $this->getInputType() . '.phtml';
        if (file_exists(
            Mage::getBaseDir('design') . DS . 'adminhtml' . DS . 'default' . DS . 'default' . DS . 'template'
            . DS .$this->_template
        )) {
            return $this->_template;
        }

        return false;
    }

    /**
     * Prepare html output
     *
     * @return string
     */
    protected function _toHtml()
    {
        $random = rand(0, 1000) . rand(0, 1000);
        $html = parent::_toHtml();
        if (!empty($html)) {
            $html = '<span id="trigger-' . $this->getInputType() . $random
                . '" class="rule-help"><img src="' . $this->_imgSrc
                . '"  alt="" class="v-middle" /><div id="tooltip-'
                . $this->getInputType() . $random
                . '" class="tooltips" style="display:none;">'
                . $html
                . '<p class="tooltip-close">'
                . $this->__('click tooltip to hide')
                . '</p></div></span>
                <script>
                if(typeof Tooltip != "undefined") { new Tooltip("trigger-' . $this->getInputType() . $random
                . '", "tooltip-' . $this->getInputType() . $random . '"); }</script>
                ';
        }

        return $html;
    }

}