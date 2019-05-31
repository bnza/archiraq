<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class XsrfListenerEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var CsrfTokenManagerInterface
     */
    private $manager;

    public static function getSubscribedEvents()
    {
        return array(
            'kernel.request' => array('onKernelRequest', 1000),
            'kernel.response' => 'onKernelResponse',
        );
    }

    public function __construct(CsrfTokenManagerInterface $provider)
    {
        $this->manager = $provider;
    }

    protected function refreshToken(FilterResponseEvent $e)
    {
        $cookie = Cookie::create(
            'xsrf-token',
            $this->manager->refreshToken('archiraq'),
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

    public function onKernelRequest(GetResponseEvent $e)
    {
        if (in_array($e->getRequest()->getMethod(), array('POST', 'PUT', 'DELETE', 'PATCH'))) {
            $token = $this->manager->getToken('archiraq');
            if (
                $token
                && !$this->manager->isTokenValid($token)
                || $token->getValue() !== $e->getRequest()->headers->get('x-xsrf-token')
            ) {
                $e->setResponse(new Response('The XSRF token is invalid', 412));

                return;
            }
        }
    }

    public function onKernelResponse(FilterResponseEvent $e)
    {
        if (
            $e->getRequest()->isMethod('GET') && '/' === $e->getRequest()->getPathInfo()
            || $e->getRequest()->isMethod('POST') && '/logout' === $e->getRequest()->getPathInfo()
        ) {
            $this->refreshToken($e);
        }
    }
}
