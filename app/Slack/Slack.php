<?php

namespace App\Slack;

use App\Deploy;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Slack
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send a freeform slack-message
     */
    public function sendMessage(string $channel, string $message) : void
    {
        $this->client->post('https://slack.com/api/chat.postMessage', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('slack.token'),
            ],
            'body' => json_encode([
                'channel' => $channel,
                'text' => $message,
            ]),
        ]);
    }

    /**
     * Report a deployment to the right Slack-channel
     */
    public function report(Deploy $deploy, Collection $messages) : void
    {
        $channel = $deploy->application->channel;

        // Use the override channel if set
        if (!empty(config('slack.override_channel'))) {
            $channel = config('slack.override_channel');
        }

        $message = view('slack.deployment_message', [
            'user' => UserMapping::map($deploy->username),
            'stage' => ucfirst($deploy->stage),
            'messages' => $messages,
        ])->render();

        $this->sendMessage($channel, $message);
    }
}
