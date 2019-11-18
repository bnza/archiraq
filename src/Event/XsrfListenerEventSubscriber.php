<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;

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

    protected function refreshToken(ResponseEvent $e)
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

    protected function isLogoutRequest(KernelEvent $e): bool
    {
        return $e->getRequest()->isMethod('POST') && $e->getRequest()->getPathInfo() === '/logout';
    }

    public function onKernelRequest(RequestEvent $e)
    {
        if (!$this->isLogoutRequest($e) && in_array($e->getRequest()->getMethod(), array('POST', 'PUT', 'DELETE', 'PATCH'))) {
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

    public function onKernelResponse(ResponseEvent $e)
    {
        if (
            $e->getRequest()->isMethod('GET') && '/' === $e->getRequest()->getPathInfo()
            || $this->isLogoutRequest($e)
        ) {
            $this->refreshToken($e);
        }
    }
}
