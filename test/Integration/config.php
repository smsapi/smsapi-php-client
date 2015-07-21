<?php

$distFilePath = __DIR__ . '/config.dist.php';

if (is_file($distFilePath)) {
    return include $distFilePath;
} else {
    return array(
        'api_login' => '',
        'api_password' => '',
        'number_test' => '',
        'sms_template_name' => '',
        'host' => '',
        'contacts_login' => '',
        'contacts_password' => '',
        'contacts_host' => '',
    );
}

