<?php

spl_autoload_extensions();
spl_autoload_register();

$proxy = new \SMSApi\Api\Proxy\Native('http://smsapi.local/api/');

$client = new \SMSApi\Api\Client('test');
$client->setPassword( $client->hashPassword('test') );

$smsApi = new \SMSApi\Api\SMSFactory($client);
$smsApi->proxy($proxy);

$result =
	$smsApi->actionSend()
		->setTo('694562829')
		->setText('helloworld')
		->setFrom('SMSAPI')
		->setFast(true)
		->setIDx('idx test '.time())
		->setCheckIDx(true)
		->execute();

print_r($result->getList()[0]->getID());
