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

namespace FCamara\Getnet\Block\Customer\Cards;

use \Magento\Framework\View\Element\Template;
use FCamara\Getnet\Model\Client;
use \Magento\Customer\Model\Session;

class Listaction extends Template
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * Listaction constructor.
     * @param Template\Context $context
     * @param Client $client
     * @param Session $customerSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Client $client,
        Session $customerSession,
        array $data = []
    ) {
        $this->client = $client;
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * @return bool|mixed
     */
    public function getCardList()
    {
        $cards = $this->client->cardList($this->customerSession->getCustomerId());
        return isset($cards['cards']) ? $cards['cards'] : [];
    }
}
