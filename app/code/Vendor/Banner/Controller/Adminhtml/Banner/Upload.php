<?php
namespace Vendor\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem\Driver\File as FileDriver;

class Upload extends \Magento\Backend\App\Action
{
protected $uploaderFactory;
protected $fileDriver;

public function __construct(
Context $context,
UploaderFactory $uploaderFactory,
FileDriver $fileDriver
) {
parent::__construct($context);
$this->uploaderFactory = $uploaderFactory;
$this->fileDriver = $fileDriver;
}

public function execute()
{
try {
$uploader = $this->uploaderFactory->create(['fileId' => 'image']);
$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
$uploader->setAllowRenameFiles(true);
$uploader->setFilesDispersion(false);

$mediaDirectory = $this->_objectManager->get(\Magento\Framework\Filesystem::class)
->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
$target = $mediaDirectory->getAbsolutePath('banner/');

$result = $uploader->save($target);

// Return uploaded file URL
$result['url'] = $this->_url->getBaseUrl() . 'pub/media/banner/' . $result['file'];

return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
} catch (\Exception $e) {
return $this->resultFactory->create(ResultFactory::TYPE_JSON)
->setData(['error' => $e->getMessage(), 'errorcode' => $e->getCode()]);
}
}
}
