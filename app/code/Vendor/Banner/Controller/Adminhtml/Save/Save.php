<?php

namespace Vendor\Banner\Controller\Adminhtml\Save;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Vendor\Banner\Model\BannerFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Psr\Log\LoggerInterface;

class Save extends Action
{
    protected $bannerFactory;
    protected $dataPersistor;
    protected $filesystem;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $logger;

    public function __construct(
        Action\Context $context,
        BannerFactory $bannerFactory,
        DataPersistorInterface $dataPersistor,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        LoggerInterface $logger
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->dataPersistor = $dataPersistor;
        $this->filesystem = $filesystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->logger = $logger;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue(); // Retrieve form data

        if ($data) {
            /** @var \Vendor\Banner\Model\Banner $model */
            $model = $this->bannerFactory->create(); // Creating instance of model

            $id = $this->getRequest()->getParam('id');

            if ($id) {
                $model->load($id); // Load existing record if ID is set
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('Banner does not exist.'));
                    return $this->_redirect('banner/banner/edit');
                }
            }

            // Handle the image upload
            if (isset($data['image']['file']) && $data['image']['file'] != '') {



                try {
                    // Define media directory path for image upload
                    $mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
                    $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif']); // Allowed file types
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);

                    $imagePath = 'banner/images/'; // Define subdirectory for uploaded images
                    $result = $uploader->save($mediaDirectory->getAbsolutePath($imagePath));

                    if ($result['file']) {
                        $data['image'] = $imagePath . $result['file']; // Store image path in the database
                    }
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('Image upload failed: ' . $e->getMessage()));
                    $this->logger->critical($e);
                }
            }

            // Set data manually
            $model->setData('name', $data['name']);
            $model->setData('status', $data['status']);
            $model->setData('category', $data['category_id']);
            $model->setData('from_date', $data['from_date']);
            $model->setData('to_date', $data['to_date']);
            if (isset($data['image'])) {
                $model->setData('image', $data['image']);
            }

            try {
                $model->save(); // Save data into database
                $this->messageManager->addSuccessMessage(__('Banner saved successfully.'));
                $this->dataPersistor->clear('banner_data');

                return $this->_redirect('banner/banner/edit'); // Redirect after save
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the banner.'));
            }

            $this->dataPersistor->set('banner_data', $data);
            return $this->_redirect('banner/banner/edit', ['id' => $id]);
        }

        return $this->_redirect('banner/banner/edit');
    }
}
