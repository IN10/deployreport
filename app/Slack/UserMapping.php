<?php

namespace App\Slack;

/**
 * To mention users on Slack, we have to adopt the new syntax <@D3AGNJ2SE>.
 * This class converts local users (from deployment) to Slack IDs.
 */
class UserMapping
{
    private static $mapping = [
        'basdebeer' => 'U0E591Z7Z',
        'ivometz' => 'U05084NHP',
        'jakobbuis' => 'U3AK7MC1K',
        'julesverdijk' => 'UCF2LQ9EJ',
        'remcolakens' => 'U7T5ZGDDJ',
        'remkojanse' => 'U62EV881Z',
        'sanderwapstra' => 'U1LUAPRJP',
        'sebastiaanhols' => 'UHEKCMEMN',
        'stephandebruin' => 'UB0UV282E',
        'stevenotto' => 'U22RGSV5H',
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
