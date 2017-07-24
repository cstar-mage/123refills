<?php

/**
 * Class IWD_OrderManager_Helper_Image
 */
class IWD_OrderManager_Helper_Image extends Mage_Catalog_Helper_Image
{
    /**
     * @param Mage_Catalog_Model_Product $product
     * @param string $attributeName
     * @param null $imageFile
     * @return $this
     */
    public function init(Mage_Catalog_Model_Product $product, $attributeName, $imageFile = null)
    {
        $this->_reset();
        $this->_setModel(Mage::getModel('iwd_ordermanager/product_image'));
        $this->_getModel()->setDestinationSubdir($attributeName);
        $this->setProduct($product);

        $destSubdir = $this->_getModel()->getDestinationSubdir();

        $this->_getModel()->product = $this->getProduct();
        $this->setWatermark(Mage::getStoreConfig("design/watermark/{$destSubdir}_image"));
        $this->setWatermarkImageOpacity(Mage::getStoreConfig("design/watermark/{$destSubdir}_imageOpacity"));
        $this->setWatermarkPosition(Mage::getStoreConfig("design/watermark/{$destSubdir}_position"));
        $this->setWatermarkSize(Mage::getStoreConfig("design/watermark/{$destSubdir}_size"));

        if ($imageFile) {
            $this->setImageFile($imageFile);
        } else {
            // add for work original size
            $this->_getModel()->setBaseFile($this->getProduct()->getData($destSubdir));
        }

        return $this;
    }

    /**
     * Return Image URL
     *
     * @return string
     */
    public function __toString()
    {
        try {
            $model = $this->_getModel();

            if ($this->getImageFile()) {
                $model->setBaseFile($this->getImageFile());
            } else {
                $model->setBaseFile($this->getProduct()->getData($model->getDestinationSubdir()));
            }

            if ($model->isCached()) {
                return $model->getUrl();
            } else {
                if ($this->_scheduleRotate) {
                    $model->rotate($this->getAngle());
                }

                if ($this->_scheduleResize) {
                    $model->resize();
                }

                if ($this->getWatermark()) {
                    $model->setWatermark($this->getWatermark());
                }

                $url = $model->saveFile()->getUrl();
            }
        } catch (Exception $e) {
            $url = Mage::getDesign()->getSkinUrl($this->getPlaceholder(), array('_area' => 'frontend'));
        }

        return $url;
    }
}
