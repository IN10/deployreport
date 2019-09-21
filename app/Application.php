<?php

namespace App;

use App\Events\ApplicationCreated;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name',
        'slack_channel',
        'jira_projectcode',
        'github_repository',
    ];

    protected $dispatchesEvents = [
        'created' => ApplicationCreated::class,
    ];

    public static function name(string $name) : ?self
    {
        return self::where('name', $name)->first();
    }

    public function canReport() : bool
    {
        return !empty($this->github_repository)
            && !empty($this->jira_projectcode)
            && !empty($this->slack_channel);
    }
}
