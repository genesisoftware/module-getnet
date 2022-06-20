<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to https://www.fcamara.com.br/ for more information.
 *
 * @category  FCamara
 * @package   FCamara_Getnet
 * @copyright Copyright (c) 2020 Getnet
 * @Agency    FCamara Formação e Consultoria, Inc. (http://www.fcamara.com.br)
 * @author    Danilo Cavalcanti de Moura <danilo.moura@fcamara.com.br>
 */

namespace FCamara\Getnet\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Message\ManagerInterface;
use Magento\Quote\Api\CartRepositoryInterface;

class SalesOrderPlaceAfter implements ObserverInterface
{
    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var CartRepositoryInterface
     */
    private $quoteRepository;

    /**
     * SalesOrderPlaceAfter constructor.
     * @param ManagerInterface $messageManager
     * @param CartRepositoryInterface $quoteRepository
     */
    public function __construct(ManagerInterface $messageManager, CartRepositoryInterface $quoteRepository)
    {
        $this->messageManager = $messageManager;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        try {
            $order = $observer->getOrder();
            $quote = $this->quoteRepository->get($order->getData('quote_id'));

            if ($quote->getData('subscription_id')) {
                $order->addData(['subscription_id' => $quote->getData('subscription_id')]);
                $order->save();
            }

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }
}
