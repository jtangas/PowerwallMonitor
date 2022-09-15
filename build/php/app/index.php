<?php

use Jtangas\GatewayApi\App;
use Jtangas\GatewayApi\GatewayConfig;

require_once('vendor/autoload.php');

$config = new GatewayConfig([
  'email' => $_SERVER['GATEWAY_EMAIL'], // your email to log in to the gateway
  'username' => $_SERVER['GATEWAY_USERNAME'],
  'password' => $_SERVER['GATEWAY_PASSWD'], // your password
  'url' => $_SERVER['GATEWAY_URL'],
  'cookieBaseUrl' => $_SERVER['GATEWAY_COOKIEBASEURL'], // e.g. gateway.asgard.io
]);

$app = new App($config);
header('Content-Type: application/json');
echo $app->index();