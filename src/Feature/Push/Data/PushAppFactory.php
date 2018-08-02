<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

/**
 * @internal
 */
class PushAppFactory
{
    public function createFromObject(\stdClass $object): PushApp
    {
        $pushApp = new PushApp();
        $pushApp->id = $object->id;
        $pushApp->name = $object->name;

        if (isset($object->icon)) {
            $pushApp->icon = $object->icon;
        }

        return $pushApp;
    }
}
