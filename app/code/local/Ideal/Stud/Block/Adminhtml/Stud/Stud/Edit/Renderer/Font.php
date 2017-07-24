<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font extends Varien_Data_Form_Element_Select
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
    public function getElementHtml()
    {

        $time = $this->getHtmlId();
        // Get the default HTML for this option
        $html = parent::getElementHtml();

        $html .= '<br/><div id="athlete_gfont_preview'.$time.'" style="font-size:20px; margin-top:5px;">The quick
        brown fox jumps over the lazy dog</div>
		<script>
        var googleFontPreviewModel'.$time.' = Class.create();

        googleFontPreviewModel'.$time.'.prototype = {
            initialize : function()
            {
                this.fontElement = $("'.$this->getHtmlId().'");
                this.previewElement = $("athlete_gfont_preview'.$time.'");
                this.loadedFonts = "";

                this.refreshPreview();
                this.bindFontChange();
            },
            bindFontChange : function()
            {
                Event.observe(this.fontElement, "change", this.refreshPreview.bind(this));
                Event.observe(this.fontElement, "keyup", this.refreshPreview.bind(this));
                Event.observe(this.fontElement, "keydown", this.refreshPreview.bind(this));
            },
        	refreshPreview : function()
            {
                if ( this.loadedFonts.indexOf( this.fontElement.value ) > -1 ) {
                    this.updateFontFamily();
                    return;
                }

        		var ss = document.createElement("link");
        		ss.type = "text/css";
        		ss.rel = "stylesheet";
        		ss.href = "//fonts.googleapis.com/css?family=" + this.fontElement.value;
        		document.getElementsByTagName("head")[0].appendChild(ss);

                this.updateFontFamily();

                this.loadedFonts += this.fontElement.value + ",";
            },
            updateFontFamily : function()
            {
                $(this.previewElement).setStyle({ fontFamily: this.fontElement.value });
            }
        }

        googleFontPreview'.$time.' = new googleFontPreviewModel'.$time.'();
		</script>
        ';
        return $html;
    }
}