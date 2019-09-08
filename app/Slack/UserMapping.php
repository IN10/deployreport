<?php

namespace App\Slack;

/**
 * To mention users on Slack, we have to adopt the new syntax <@D3AGNJ2SE>.
 * This class converts local users (from deployment) to Slack IDs.
 */
class UserMapping
{
    private static $mapping = [
        'jakobbuis' => 'U3AK7MC1K',
    ];

    public static function map(string $username) : string
    {
        if (isset(self::$mapping[$username])) {
            return '<@' . self::$mapping[$username] . '>';
        } else {
            return $username;
        }
    }
}
