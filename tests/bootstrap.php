<?php
declare(strict_types=1);

use PHPUnit\Util\Blacklist;

define('ROOT_DIR', dirname(__DIR__));
define('RESOURCE_DIR', ROOT_DIR . '/tests-resources');
define('CONFIG_DIR', RESOURCE_DIR . '/config');
define('FIXTURES_DIR', RESOURCE_DIR . '/fixtures');

require_once ROOT_DIR . '/vendor/autoload.php';

/**
 * @see https://github.com/sebastianbergmann/phpunit/issues/1598#issuecomment-434340706
 */
if (!empty(Blacklist::$blacklistedClassNames)) {
    foreach (Blacklist::$blacklistedClassNames as $className => $parent) {
        try {
            if (!class_exists($className)) {
                unset(Blacklist::$blacklistedClassNames[$className]);
            }
        } catch (Exception $e) {
            unset(Blacklist::$blacklistedClassNames[$className]);
        }
    }
}