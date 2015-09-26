<?php

namespace ResultSystems\ConsumingAPI;

class ApiRestfulToken extends ApiRestful
{
    /**
     * Código de retorno http
     *
     * @var int
     */
    protected $httpCode;

    /**
     * Connect no API
     */
    public function connect()
    {
        $data                       = array();
        $data[$this->fieldUsername] = $this->username;
        $data[$this->fieldPassword] = $this->password;
        if (!is_null($this->fieldCompany)) {
            $data[$this->fieldCompany] = $this->company;
        }
        $header   = array();
        $header[] = 'Content-Type: application/json';
        $header[] = 'Content-Length: ' . strlen(json_encode($data));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->temporaryCredentialsRequestUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result         = curl_exec($ch);
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->token = $result;

        return $this;
    }

    /**
     * Faz a requisição
     *
     * @param  string|null  $entitity
     * @param  string  $method
     * @param  boolean|array $data
     * @param  int  $id
     */
    protected function request($entitity, $method, $data = false, $id = null)
    {
        $this->setEntitity($entitity);

        if (is_null($this->entitity)) {
            return;
        }

        $header[] = 'Content-Type: application/json';
        $header[] = 'Authorization: Bearer ' . $this->token;

        if ($data && $method != 'GET') {
            $header[] = 'Content-Length: ' . strlen($data);
        }

        $resourceUrl = $this->apiUrl . $this->entitity;

        if (!is_null($id)) {
            $resourceUrl .= '/' . $id;
        }

        if ($method == 'GET' && $data) {
            $resourceUrl .= '?' . http_build_query($data);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $resourceUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data && $method != 'GET') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($method == 'GET') {
            curl_setopt($ch, CURLOPT_POST, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result         = curl_exec($ch);
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $result;
    }

    public function setTokenByVariable($var)
    {
        $this->token = json_decode($this->token, true)[$var];
    }

    public function getToken()
    {
        return $this->token;
    }
}
