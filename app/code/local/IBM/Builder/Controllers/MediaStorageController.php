<?php

class IBM_Builder_MediaStorageController extends IBM_Builder_Controllers_BaseController
{
    public function importImageAction()
    {
        $imageUrls = $this->getRequest()->getParam('urls');

        $selfMediaUrl = Mage::getBaseUrl('media');

        $response = array();
        foreach ($imageUrls as $key => $imageUrl) {
            $urlItem = array();
            $urlItem['existedUrl'] = $imageUrl;
            $urlItem['newUrl'] = '';
            
            if (strpos($imageUrl, $selfMediaUrl) !== false) {
                $response[] = $urlItem;
                continue;
            }

            $fileContent = @file_get_contents($imageUrl);
            if (empty($fileContent)) {
                $response[] = $urlItem;
                continue;
            }

            /** @var Mage_Core_Model_File_Storage_File $fileStorage */
            $fileStorage = Mage::getModel('Core/File_Storage_File');

            $directory = 'wysiwyg'.DS.'IdealBrandMarketing';
            $pathInfo = pathinfo($imageUrl);

            $fileName = $pathInfo['filename'] . '.' . $pathInfo['extension'];

            $fileForImport = array(
                'filename' => $fileName,
                'content' => $fileContent,
                'directory' => $directory
            );
            $importResult = $fileStorage->importFiles(array($fileForImport));

            if ($importResult === false) {
                $response[] = $urlItem;
                continue;
            }

            $fileSystemPath = Mage::getBaseDir('media').DS.$directory.DS.$fileForImport['filename'];

            $resizeResult = Mage::getModel('cms/wysiwyg_images_storage')->resizeFile($fileSystemPath);
            if ($resizeResult === false) {
                return $this->getResponse()->setBody('');
            }

            $fileUrl = $selfMediaUrl .$directory . DS . $fileName;

            $urlItem['newUrl'] = $fileUrl;
            
            $response[] = $urlItem;
        }

        return $this->getResponse()->setBody(json_encode($response));
    }

    public function getImageUrlAction()
    {
        $helper = Mage::helper('cms/wysiwyg_images');
        
        $name = $this->getRequest()->getParam('name');

        $selfMediaUrl = Mage::getBaseUrl('media');

        if (strpos($name, '/cms_wysiwyg') === false) {
            $pos = strpos($name, 'media/wysiwyg');

            $fileUrl = $selfMediaUrl . substr($name, $pos + 6);
            return $this->getResponse()->setBody($fileUrl);
        }

        preg_match_all('~\/([\w,]{5,})\/~', $name, $matches);

        if (empty($matches[1])) {
            return;
        }

        $filename = $helper->idDecode(array_pop($matches[1]));

        preg_match('~\"(.*)\"~', $filename, $matches);

        if (empty($matches)) {
            return;
        }

        $fileUrl = $selfMediaUrl . array_pop($matches);
        return $this->getResponse()->setBody($fileUrl);
    }
}