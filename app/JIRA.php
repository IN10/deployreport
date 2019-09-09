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
            if (!preg_match($regex, $message, $matches)) {
                continue;
            }

            $tickets->push((object) [
                'message' => $message,
            ]);
        }

        return $tickets;
    }
}
