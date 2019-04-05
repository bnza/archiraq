<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
    }

    /**
     * @Route("/logout", name="logout", methods={"POST"})
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
    }

    /**
     * @Route("/logoutSuccess", name="logoutSuccess")
     */
    public function logoutSuccess(Request $request, CsrfTokenManagerInterface $manager)
    {
        $token = $manager->getToken('archiraq');
        //@TODO check request
        return new JsonResponse([
            'message' => 'User logged out',
            'xsrfToken' => $token->getValue()
        ]);
    }
}
