<?php

namespace ResultSystems\ConsumingAPI;

use OAuth;

abstract class ApiRestful
{
    /**
     * Url para callback
     * @var url
     */
    protected $callbackUrl;

    /**
     * Url para credenciais temporárias
     * @var url
     */
    protected $temporaryCredentialsRequestUrl;

    /**
     * Url autorização administrativa
     * @var url
     */
    protected $adminAuthorizationUrl;

    /**
     * Token para gerar token
     * @var url
     */
    protected $accessTokenRequestUrl;

    /**
     * Url da API
     * @var url
     */
    protected $apiUrl;

    /**
     * Chave do cliente
     * @var string
     */
    protected $consumerKey;

    /**
     * Senha do cliente
     * @var string
     */
    protected $consumerSecret;

    /**
     * Objeto oauth
     * @var object
     */
    protected $oauth;

    /**
     * Entidade
     * @var string
     */
    protected $entitity = null;

    /**
     * Secret
     * @var string
     */
    protected $secret = null;

    /**
     * token
     * @var string
     */
    protected $token = null;

    /**
     * username
     * @var string
     */
    protected $username = null;

    /**
     * password
     * @var string
     */
    protected $password = null;

    /**
     * company
     * @var string
     */
    protected $company = null;

    /**
     * Campo login
     *
     * @var string
     */
    protected $fieldUsername = 'username';

    /**
     * Campo password
     *
     * @var string
     */
    protected $fieldPassword = 'password';

    /**
     * Campo empresa
     *
     * @var string
     */
    protected $fieldCompany = null;

    public function __construct($callbackUrl = null, $temporaryCredentialsRequestUrl = null, $adminAuthorizationUrl = null, $accessTokenRequestUrl = null, $apiUrl = null, $consumerKey = null, $consumerSecret = null, $username = null, $password = null, $company = null)
    {
/*
$this->callbackUrl = config('apirestful.callbackUrl');
$this->temporaryCredentialsRequestUrl = config('apirestful.temporaryCredentialsRequestUrl');
$this->adminAuthorizationUrl = config('apirestful.adminAuthorizationUrl');
$this->accessTokenRequestUrl = config('apirestful.accessTokenRequestUrl');
$this->apiUrl = config('apirestful.apiUrl');
$this->consumerKey = config('apirestful.consumerKey');
$this->consumerSecret = config('apirestful.consumerSecret');

 */
        if (!is_null($callbackUrl)) {
            $this->callbackUrl = $callbackUrl;
        }

        if (!is_null($temporaryCredentialsRequestUrl)) {
            $this->temporaryCredentialsRequestUrl = $temporaryCredentialsRequestUrl;
        }

        if (!is_null($adminAuthorizationUrl)) {
            $this->adminAuthorizationUrl = $adminAuthorizationUrl;
        }

        if (!is_null($accessTokenRequestUrl)) {
            $this->accessTokenRequestUrl = $accessTokenRequestUrl;
        }

        if (!is_null($apiUrl)) {
            $this->apiUrl = $apiUrl;
        }

        if (!is_null($consumerKey)) {
            $this->consumerKey = $consumerKey;
        }

        if (!is_null($consumerSecret)) {
            $this->consumerSecret = $consumerSecret;
        }

        if (!is_null($username)) {
            $this->username = $username;
        }

        if (!is_null($password)) {
            $this->password = $password;
        }

        if (!is_null($company)) {
            $this->company = $company;
        }
    }

    /**
     * Destroi a conexão
     */
    public function disconnect()
    {
        $this->secret = null;
    }

    public function forceConnect()
    {
        $this->disconnect();
        $this->connect();
    }
    /**
     * Connect no API
     */
    abstract public function connect();

    // /public function state
    /**
     * set Entitity
     * @param string $entitity
     */
    public function setEntitity($entitity)
    {
        if (!is_null($entitity)) {
            $this->entitity = $entitity;
        }

        return $this;
    }

    abstract protected function request($entitity, $method, $data = false, $id = null);

    /**
     * Pega todos os itens da entidade
     *
     * @param  string|null $entitity [description]
     */
    public function all($entitity = null)
    {
        return $this->request($entitity, OAUTH_HTTP_METHOD_GET);
    }

    /**
     * Cria um objeto
     *
     * @param  array  $data
     * @param  string|null $entitity
     */
    public function create(array $data, $entitity = null)
    {
        return $this->request($entitity, OAUTH_HTTP_METHOD_POST, json_encode($data));
    }

    /**
     * Atualiza um item do objeto
     *
     * @param  array  $data
     * @param  int $id
     * @param  string|null $entitity
     */
    public function update(array $data, $id, $entitity = null)
    {
        return $this->request($entitity, OAUTH_HTTP_METHOD_PUT, json_encode($data), $id);
    }

    /**
     * Apaga um item
     *
     * @param  int $id
     * @param  string|null $entitity
     */
    public function delete($id, $entitity = null)
    {
        return $this->request($entitity, OAUTH_HTTP_METHOD_DELETE, false, $id);
    }

    /**
     * Pega um item
     *
     * @param  int $id
     * @param  string|null $entitity
     */
    public function get($id, $entitity = null)
    {
        return $this->request($entitity, OAUTH_HTTP_METHOD_GET, false, $id);
    }

    /**
     * set callbackUrl
     * @param string $value
     */
    public function setCallbackUrl($value)
    {
        $this->callbackUrl = $value;

        return $this;
    }

    /**
     * set temporaryCredentialsRequestUrl
     * @param string $value
     */
    public function setTemporaryCredentialsRequestUrl($value)
    {
        $this->temporaryCredentialsRequestUrl = $value;

        return $this;
    }

    /**
     * set adminAuthorizationUrl
     * @param string $value
     */
    public function setAdminAuthorizationUrl($value)
    {
        $this->adminAuthorizationUrl = $value;

        return $this;
    }

    /**
     * set accessTokenRequestUrl
     * @param string $value
     */
    public function setAccessTokenRequestUrl($value)
    {
        $this->accessTokenRequestUrl = $value;

        return $this;
    }

    /**
     * set apiUrl
     * @param string $value
     */
    public function setApiUrl($value)
    {
        $this->apiUrl = $value;

        return $this;
    }

    /**
     * set consumerKey
     * @param string $value
     */
    public function setConsumerKey($value)
    {
        $this->consumerKey = $value;

        return $this;
    }

    /**
     * set consumerSecret
     * @param string $value
     */
    public function setConsumerSecret($value)
    {
        $this->consumerSecret = $value;

        return $this;
    }

    /**
     * set username
     * @param string $value
     */
    public function setUsername($value)
    {
        $this->username = $value;

        return $this;
    }

    /**
     * set password
     * @param string $value
     */
    public function setPassword($value)
    {
        $this->password = $value;

        return $this;
    }

    /**
     * set company
     * @param string $value
     */
    public function setCompany($value)
    {
        $this->company = $value;

        return $this;
    }

    /**
     * set fieldUsername
     * @param string $value
     */
    public function setFieldUsername($value)
    {
        $this->fieldUsername = $value;

        return $this;
    }

    /**
     * set fieldPassword
     * @param string $value
     */
    public function setFieldPassword($value)
    {
        $this->fieldPassword = $value;

        return $this;
    }

    /**
     * set fieldCompany
     * @param string $value
     */
    public function setFieldCompany($value)
    {
        $this->fieldCompany = $value;

        return $this;
    }
}
