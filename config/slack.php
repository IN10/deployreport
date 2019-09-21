<?php

return [
    'token' => env('SLACK_TOKEN'),

    /*
     * If set, all messages will be sent to the channel override.
     * This is useful in testing.
     */
    'override_channel' => env('SLACK_OVERRIDE_CHANNEL'),

    'admin' => env('SLACK_ADMIN_USER', 'U3AK7MC1K'), // Default Jakob Buis
];
