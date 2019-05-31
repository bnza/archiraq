<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class EnvDataListenerEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var array
     */
    private $envData;

    public static function getSubscribedEvents()
    {
        return array(
            'kernel.response' => 'onKernelResponse'
        );
    }

    public function __construct(array $envData)
    {
        $envData['geoServer']['guestAuth'] = base64_encode($envData['geoServer']['guestAuth']);
        $this->envData = $envData;
    }

    protected function refreshData(ResponseEvent $e) {
        $cookie = Cookie::create(
            'env-data',
            json_encode($this->envData),
            0,
            '/',
            null,
            false,
            false
        );
        $e
            ->getResponse()
            ->headers
            ->setCookie(
                $cookie
            );
    }

    public function onKernelResponse(ResponseEvent $e)
    {
        if (
            $e->getRequest()->isMethod('GET') && $e->getRequest()->getPathInfo() === '/'
        ) {
            $this->refreshData($e);
        }
    }
}
