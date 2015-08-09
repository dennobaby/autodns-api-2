<?php

namespace Autodns\Api;

use Autodns\Api\Client\Request\Task;
use Autodns\Api\Client\Request;
use Autodns\Api\Client\Response;
use Autodns\Api\XmlDelivery;
use Autodns\Api\Account\Info;

class Client
{
    /**
     * @var XmlDelivery
     */
    private $delivery;

    /**
     * @var Info
     */
    private $accountInfo;

    /**
     * @param XmlDelivery $delivery
     * @param Info $accountInfo
     */
    public function __construct(XmlDelivery $delivery, Info $accountInfo)
    {
        $this->delivery = $delivery;
        $this->accountInfo = $accountInfo;
    }

    public function setTimeout( $timeout )
    {
        $this->delivery->setTimeout( $timeout );
    }

    /**
     * @param Task $task
     * @return Response
     */
    public function call(Task $task)
    {
        $request = new Request($task);
        $request->setAuth($this->accountInfo->getAuthInfo());
        $url = $this->accountInfo->getUrl();
        $response = $this->delivery->send($url, $request);

        return new Response($response);
    }
}
