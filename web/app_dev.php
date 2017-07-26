<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
$ip2longCli = ip2long(@$_SERVER['REMOTE_ADDR']);
$minIp = ip2long('172.18.0.1');
$maxIp = ip2long('172.24.0.10');

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
// I custom by remove this instruction in the condition '|| isset($_SERVER['HTTP_X_FORWARDED_FOR'])' because it's the header send by xdebug
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || (!(in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', 'fe80::1', '::1', '192.168.33.10:80'])) and !(($minIp <= $ip2longCli) && ($ip2longCli <= $maxIp)))
        || php_sapi_name() === 'cli-server'
) {
    header('HTTP/1.0 403 Forbidden');
    echo @$_SERVER['REMOTE_ADDR'],
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
