<?php

namespace App\Listeners;

use App\Events\ApplicationCreated;
use App\Slack\Slack;

/*
 * When a new application is created, we need to set some settings before it's
 * fully operational. Send the admin a Slack-message to notify him/her.
 */
class ReportNewApplication
{
    public function handle(ApplicationCreated $event)
    {
        $admin = config('slack.admin');
        $message = "New application registered for deployreport: {$event->application->name}. You'll need to add Slack, JIRA and Github settings before deployments will be reported.";

        app(Slack::class)->sendMessage($admin, $message);
    }
}
