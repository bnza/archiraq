<?php


namespace App\Security\Guard\Token;

use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;


class GeoserverDigest1PostAuthenticationGuardToken extends PostAuthenticationGuardToken
{
    /**
     * base64 encoded http basic auth
     * @var string
     */
    private $auth;

    /**
     * @return string
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Only password!
     * @param string $password the password fragment
     */
    public function setAuth(string $password): void
    {
        $this->auth = base64_encode($this->getUsername().":$password");
    }

    /**
     * {@inheritdoc}
     */
    public function __serialize(): array
    {
        return [$this->auth, parent::__serialize()];
    }

    /**
     * {@inheritdoc}
     */
    public function __unserialize(array $data): void
    {
        [$this->auth, $parentData] = $data;
        parent::__unserialize($parentData);
    }
}
