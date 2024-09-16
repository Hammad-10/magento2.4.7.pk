<?php
namespace HammadIdrees\HelloWorld\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use HammadIdrees\HelloWorld\Model\HelloWorld;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
const ADMIN_RESOURCE = 'HammadIdrees_HelloWorld::helloworld1';

protected $dataProcessor;
protected $dataPersistor;
protected $model;

public function __construct(
Action\Context $context,
PostDataProcessor $dataProcessor,
HelloWorld $model,
DataPersistorInterface $dataPersistor
) {
$this->dataProcessor = $dataProcessor;
$this->dataPersistor = $dataPersistor;
$this->model = $model;
parent::__construct($context);
}

public function execute()
{
$data = $this->getRequest()->getPostValue();
$resultRedirect = $this->resultRedirectFactory->create();

if ($data) {
// Filter the data
$data = $this->dataProcessor->filter($data);

// Get the ID (if it's an existing record)
$id = $this->getRequest()->getParam('id');
if ($id) {
$this->model->load($id);  // Load existing record
} else {
$this->model->setId(null);  // Set ID to null for new record
}


//setting the data on the model
    $this->model->setData('title', $data['title']);
    $this->model->setData('content', $data['content']);
    $this->model->setData('customer_id', $data['entity_id']);

// Set the data on the model
//$this->model->setData($data);

// Dispatch event before saving
$this->_eventManager->dispatch(
'helloworld_prepare_save',
['helloworld' => $this->model, 'request' => $this->getRequest()]
);

// Validate data
if (!$this->dataProcessor->validate($data)) {
return $resultRedirect->setPath('*/*/edit', ['id' => $this->model->getId(), '_current' => true]);
}

try {
// Save the model
$this->model->save();
$this->messageManager->addSuccessMessage(__('You saved the Post.'));
$this->dataPersistor->clear('helloworld');  // Clear the persisted data on success

// Redirect based on the 'back' parameter
if ($this->getRequest()->getParam('back')) {
return $resultRedirect->setPath('*/*/edit', [
'id' => $this->model->getId(),
'_current' => true
]);
}

return $resultRedirect->setPath('*/*/');
} catch (LocalizedException $e) {
$this->messageManager->addErrorMessage($e->getMessage());
} catch (\Exception $e) {
$this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Post.'));
}

// Persist data in case of error
$this->dataPersistor->set('helloworld', $data);
return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
}

return $resultRedirect->setPath('*/*/');
}
}
