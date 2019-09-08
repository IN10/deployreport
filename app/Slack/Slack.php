<?php

namespace App\Slack;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Slack
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function report(Deploy $deploy) : void
    {
        // Use the override channel if set
        $channel = config('slack.override_channel', $deploy->application->slack_channel);

        $this->client->post('https://slack.com/api/chat.postMessage', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('slack.token'),
            ],
            'body' => json_encode([
                'channel' => $channel,
                'text' => $this->constructMessage($deploy),5
            ]),
        ]);
    }

    private function constructMessage(Deploy $deploy) : string
    {
        $stage = ucfirst($deploy->stage);

        return "{$deploy->username} just deployed to {$stage}";
    }
}
