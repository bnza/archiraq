<?php

namespace App\Security\Guard;

use App\Security\Guard\Token\GeoserverDigest1PostAuthenticationGuardToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Routing\RouterInterface;

class GeoServerDigest1Authenticator extends AbstractGuardAuthenticator
{
    const MAX_ATTEMPTS = 3;
    const NO_USERNAME_SUPPLIED = 'No username supplied';
    const NO_PASSWORD_SUPPLIED = 'No password supplied';
    const WRONG_CREDENTIALS = 'Wrong credentials';
    const TOO_MANY_ATTEMPTS = 'Maximum login attempts exceeded. Please contact your administrator';
    const MUST_LOGIN = 'You must login to access this content';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var string
     */
    private $geoserverGuestUsername;

    /**
     * @var $password
     */
    private $password;

    public function __construct(RouterInterface $router, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $this->router = $router;
        $this->encoder = $encoder;
        $this->em = $em;

    }

    public function setGeoserverGuestAuth(string $auth)
    {
        //geoserver service guest username cannot login
        $this->geoserverGuestUsername = explode(':',$auth)[0];
    }

    public function supports(Request $request)
    {
        return '/login' == $request->getPathInfo() && $request->isMethod('POST');
    }

    public function getCredentials(Request $request): array
    {
        return array(
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (empty($credentials['username'])) {
            throw new BadCredentialsException(self::NO_USERNAME_SUPPLIED);
        }

        if ($this->geoserverGuestUsername && $credentials['username'] == $this->geoserverGuestUsername) {
            throw new BadCredentialsException(self::WRONG_CREDENTIALS);
        }

        try {
            return $userProvider->loadUserByUsername($credentials['username']);
        } catch (UsernameNotFoundException $e) {
            throw new BadCredentialsException(self::WRONG_CREDENTIALS);
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if (!empty($credentials['password'])) {
            $plainPassword = $credentials['password'];
        }

        if (!isset($plainPassword)) {
            throw new BadCredentialsException(self::NO_PASSWORD_SUPPLIED);
        }

        if ($this->encoder->isPasswordValid($user, $plainPassword)) {
            $this->password = $plainPassword;
            return true;
        }

        throw new BadCredentialsException(self::WRONG_CREDENTIALS);
    }

    public function createAuthenticatedToken(UserInterface $user, $providerKey)
    {
        $token = new GeoserverDigest1PostAuthenticationGuardToken(
            $user,
            $providerKey,
            $user->getRoles()
        );
        $token->setAuth($this->password);
        return $token;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'errors' => $exception->getMessage(),
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new JsonResponse([
                'username' => $token->getUsername(),
                'roles' => $token->getRoleNames()
            ]
        );
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'errors' => self::MUST_LOGIN,
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }
}
