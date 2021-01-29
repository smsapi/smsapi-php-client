<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests;

use Symfony\Component\Yaml\Yaml;

class Config
{
    public static function get(string $key)
    {
        $distConfigFilePath = realpath(CONFIG_DIR . '/config.dist.yml');
        $configFilePath = realpath(CONFIG_DIR . '/config.yml');

        $distConfig = Yaml::parse(file_get_contents($distConfigFilePath));

        if ($configFilePath) {
            $config = array_merge($distConfig, Yaml::parse(file_get_contents($configFilePath)));
        }

        return $config[$key] ?? null;
    }
}
