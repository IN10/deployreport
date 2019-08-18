<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name',
        'slack_channel',
        'jira_projectcode',
        'github_repository',
    ];

    public static function name(string $name) : ?self
    {
        return self::where('name', $name)->first();
    }
}
