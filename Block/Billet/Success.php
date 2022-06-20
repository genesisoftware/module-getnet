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

namespace FCamara\Getnet\Block\Billet;

class Success extends \Magento\Checkout\Block\Success
{
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \FCamara\Getnet\Model\ConfigInterface
     */
    private $config;

    /**
     * Success constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \FCamara\Getnet\Model\ConfigInterface $config
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \FCamara\Getnet\Model\ConfigInterface $config,
        array $data = []
    ) {
        $this->_orderFactory = $orderFactory;
        $this->checkoutSession = $checkoutSession;
        $this->config = $config;

        parent::__construct($context, $orderFactory, $data);
    }

    /**
     * @return int
     */
    public function getRealOrderId()
    {
        /** @var \Magento\Sales\Model\Order $order */
        $lastorderId = $this->checkoutSession->getLastOrderId();
        $order = $this->_orderFactory->create()->load($lastorderId);
        return $order;
    }

    /**
     * @return bool
     */
    public function isBillet()
    {
        $order = $this->getRealOrderId();
        $code = $order->getPayment()->getMethodInstance()->getCode();
        if ($code ==  \FCamara\Getnet\Model\Ui\Billet\ConfigProvider::CODE) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getPaymentInfo()
    {
        $order = $this->getRealOrderId();

        return $order->getPayment()->getAdditionalInformation('billet_data');
    }

    /**
     * @return string
     */
    public function getBilletHtmlUrl()
    {
        $order = $this->getRealOrderId();
        $response = $order->getPayment()->getAdditionalInformation('billet_data');

        if (isset($response['_links'][1]['href'])) {
            return $this->config->endpoint() . $response['_links'][1]['href'];
        }

        return '';
    }

    /**
     * @return string
     */
    public function getBilletPdfUrl()
    {
        $order = $this->getRealOrderId();
        $response = $order->getPayment()->getAdditionalInformation('billet_data');

        if (isset($response['_links'][0]['href'])) {
            return $this->config->endpoint() . $response['_links'][0]['href'];
        }

        return '';
    }
}
