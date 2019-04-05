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
    public function serialize()
    {
        $serialized = [$this->auth, parent::serialize(true)];

        //return $this->doSerialize($serialized, \func_num_args() ? \func_get_arg(0) : null);

        return serialize($serialized);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->auth, $parentStr) = \is_array($serialized) ? $serialized : unserialize($serialized);
        parent::unserialize($parentStr);
    }
}
