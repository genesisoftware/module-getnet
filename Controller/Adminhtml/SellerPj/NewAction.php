<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to https://www.fcamara.com.br/ for more information.
 *
 * @category  FCamara
 * @package   FCamara_
 * @copyright Copyright (c) 2020 FCamara Formação e Consultoria
 * @Agency    FCamara Formação e Consultoria, Inc. (http://www.fcamara.com.br)
 * @author    Danilo Cavalcanti de Moura <danilo.moura@fcamara.com.br>
 */

namespace FCamara\Getnet\Controller\Adminhtml\SellerPj;

use FCamara\Getnet\Model\Seller\SellerClientPj;
use Magento\Backend\App\Action\Context;
use FCamara\Getnet\Model\SellerFactory;

class NewAction extends \Magento\Backend\App\Action
{
    /**
     * @var SellerFactory
     */
    protected $seller;

    /**
     * @var Client
     */
    protected $client;

    /**
     * NewAction constructor.
     * @param Context $context
     * @param SellerFactory $seller
     * @param SellerClientPj $client
     */
    public function __construct(
        Context $context,
        SellerFactory $seller,
        SellerClientPj $client
    ) {
        $this->seller = $seller;
        $this->client = $client;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
        $data = $this->getRequest()->getParam('main_fieldset');
        $integratedSeller = false;

        if (is_array($data)) {
            $seller = $this->seller->create();
            $seller->addData($data['seller_information']);
            $seller->addData(['business_address' => json_encode($data['seller_address'])]);
            $seller->addData(['mailing_address' => json_encode($data['seller_address'])]);
            $seller->addData(['bank_accounts' => json_encode($data['bank_accounts'])]);
            $seller->addData(['phone' => json_encode($data['phone'])]);
            $seller->addData(['cellphone' => json_encode($data['cellphone'])]);
            $seller->addData(['legal_representative' => json_encode($data['legal_representative'])]);
            $seller->addData(['list_commissions' => json_encode($data['list_commissions'])]);
            $seller->addData(['type' => 'PJ']);

            try {
                $integratedSeller = $this->client->createSellerPj($seller->getData());

                if (!isset($integratedSeller['subseller_id'])) {
                    if (isset($integratedSeller['ModelState'])) {
                        foreach ($integratedSeller['ModelState'] as $key => $msg) {
                            $this->messageManager->addErrorMessage($key . ': ' . $msg[0]);
                        }
                    }

                    if (isset($integratedSeller['errors'])) {
                        foreach ($integratedSeller['errors'] as $error) {
                            $this->messageManager->addErrorMessage($error);
                        }
                    }

                    throw new \Exception(__('Error Create Seller, Please try again!'));
                }

                $seller->addData([
                    'subseller_id' => $integratedSeller['subseller_id'],
                    'fiscal_type' => $integratedSeller['fiscal_type'],
                    'enabled' => $integratedSeller['enabled'],
                    'status' => $integratedSeller['status'],
                    'capture_payments_enabled' => $integratedSeller['capture_payments_enabled'],
                    'anticipation_enabled' => $integratedSeller['anticipation_enabled'],
                    'lock_schedule' => $integratedSeller['lock_schedule'],
                    'lock_capture_payments' => $integratedSeller['lock_capture_payments'],
                    'merchant_id' => $integratedSeller['merchant_id']
                ]);

                $seller->save();

                $this->messageManager->addSuccessMessage('Seller Successfully Saved!');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('fcamara_getnet/seller/index');
        }
    }
}
