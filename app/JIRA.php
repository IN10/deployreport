<?php

namespace App;

use Illuminate\Support\Collection;

class JIRA
{
    /**
     * Search all messages for valid ticket references, and build a collection
     * of the relevant details.
     */
    public function parseTickets(Collection $messages, string $projectCode) : Collection
    {
        // Ticket IDs take the shape of the project identifier + a number
        $regex = '/(' . $projectCode . '\-\d+)/i';

        $tickets = collect();

        foreach ($messages as $message) {
            $matches = [];
            if (!preg_match_all($regex, $message, $matches)) {
                continue;
            }

            // Replace tickets inline with Slack-URLs
            $matches = $matches[0];
            $matches = array_unique($matches); // prevent double-linking when the same ticket is mentioned twice
            foreach ($matches as $match) {
                $link = '<'. config('jira.base_url') . $match .'|' . $match . '>';
                $message = str_replace($match, $link, $message);
            }

            $tickets->push($message);
        }

        return $tickets;
    }
}
