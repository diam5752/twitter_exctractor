<?php

require "../vendor/autoload.php";

class Credentials
{
    private $key;
    private $secret;
    private $access_token;
    private $access_token_secret;

    /**
     * Credentials constructor.
     * @param $key
     * @param $secret
     * @param $access_token
     * @param $access_token_secret
     */
    public function __construct()
    {
        $this->key = "6mDYseGNhpzmjo90tZ0OyO1pJ";
        $this->secret = "kBuC38r4dqwf2YmSCamU14HXTJPxmpapT6V3w32mLExiFvEC81";
        $this->access_token = "880669245121736706-6ZbuKPXF26pENf1CkAJOEK0qEMvz5Wg";
        $this->access_token_secret = "2QZzAMvQFfcTArnp5bYUHZFP7JrLKEMVYGOTYbfi0KAmK";
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param mixed $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return mixed
     */
    public function getAccessTokenSecret()
    {
        return $this->access_token_secret;
    }

    /**
     * @param mixed $access_token_secret
     */
    public function setAccessTokenSecret($access_token_secret)
    {
        $this->access_token_secret = $access_token_secret;
    }

}
