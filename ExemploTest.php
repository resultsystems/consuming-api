<?php

namespace ResultSystems\ConsumingAPI;

include 'ApiRestful.php';
include 'ApiRestfulToken.php';

$api = new ApiRestfulToken();
$api->setFieldUsername('login');
$api->setFieldPassword('senha');
$api->setUsername('emtudo');
$api->setPassword('123456');
$api->setTemporaryCredentialsRequestUrl('http://sistema.dev/api/v1/auth');
$api->connect();
$api->setApiUrl('http://sistema.dev/api/v1/');
//echo $api->getToken();
$api->setTokenByVariable('token');
$api->setEntitity('usuario');
echo $api->getToken();
echo "\n";
echo "\n";
print_r($api->get(4));
echo "\n";
echo "\n";
/*
$data          = array();
$data['usuario']='emtudo';
$data['senha'] = '12346';
print_r($data);
print_r($api->create($data));
 */
echo "\n";
echo "\n";
//echo '===================';

