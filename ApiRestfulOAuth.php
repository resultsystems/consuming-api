<?php

namespace ResultSystems\ConsumingAPI;

use OAuth;
use OAuthException;

class ApiRestfulOAuth extends ApiRestfuli
{
    /**
     * Faz a requisição.
     *
     * @param  string|null  $entitity
     * @param  string  $method
     * @param  bool|array $data
     * @param  int  $id
     */
    protected function request($entitity, $method, $data = false, $id = null)
    {
        $this->setEntitity($entitity);

        if (is_null($this->entitity)) {
            return;
        }

        $this->oauth->setToken($this->token, $this->secret);

        $resourceUrl = $this->apiUrl.$this->entitity;

        if (!is_null($id)) {
            $resourceUrl .= '/'.$id;
        }

        $headers = ['Content-Type' => 'application/json'];
        $this->oauth->fetch($resourceUrl, $data, $method, $headers);

        return $this->oauth->getLastResponseInfo();
    }

    /**
     * Connect no API.
     */
    public function connect()
    {
        try {
            //oauth state 1
            $this->oauth = new OAuth($this->consumerKey, $this->consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
            $this->oauth->enableDebug();

            $requestToken = $this->oauth->getRequestToken($this->temporaryCredentialsRequestUrl);

            $this->secret = $requestToken['oauth_token_secret'];

            //oauth state 2
            $this->oauth = new OAuth($this->consumerKey, $this->consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION);
            $this->oauth->enableDebug();

            $this->oauth->setToken($requestToken['oauth_token'], $this->secret);
            $accessToken = $this->oauth->getAccessToken($this->accessTokenRequestUrl);
            $this->token = $accessToken['oauth_token'];
            $this->secret = $accessToken['oauth_token_secret'];

            if (!is_null($this->callbackUrl)) {
                header('Location: '.$this->callbackUrl);
                exit;
            }

            return true;
        } catch (OAuthException $e) {
            return false;
            //print_r($e);
        }
    }
}
