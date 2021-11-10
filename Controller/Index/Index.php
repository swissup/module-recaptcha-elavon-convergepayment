<?php
namespace Swissup\RecaptchaElavonConvergePayment\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    private $helper;

    /**
     * @param \Magento\Captcha\Helper\Data $helper
     * @param Context                     $context
     */
    public function __construct(
        \Magento\Captcha\Helper\Data $helper,
        Context $context
    ) {
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $formId = $this->getRequest()->getParam('form_id', '');
        $token = $this->getRequest()->getParam('token', '');
        $captcha = $formId ? $this->helper->getCaptcha($formId) : null;
        $response = $captcha ? $captcha->verify($token) : null;
        $isSuccess = $response && $response->isSuccess();

        if ($isSuccess) {
            if ($this->getRequest()->isAjax()) {
                return $this->resultFactory
                    ->create(ResultFactory::TYPE_JSON)
                    ->setData([
                        'status' => 'ok'
                    ]);
            } else {
                $this->messageManager->addSuccessMessage(__("Recaptcha is valid"));

                return $resultRedirect->setPath('');
            }
        }

        $errors = implode(
            $response ? $response->getErrorCodes() : ['missing-form-id'],
            ', '
        );
        if ($this->getRequest()->isAjax()) {
            return $this->resultFactory
                    ->create(ResultFactory::TYPE_JSON)
                    ->setData([
                        'status' => 'error',
                        'message' => __("Invalid recaptcha. [error-code: %1]", $errors)
                    ]);
        }

        $this->messageManager->addErrorMessage(
            __("Invalid recaptcha. [error-code: %1]", $errors)
        );

        return $resultRedirect->setPath('');
    }
}
