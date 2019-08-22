<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllApplicationFieldsOptional extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('jira_projectcode')->nullable(true)->change();
            $table->string('github_repository')->nullable(true)->change();
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('jira_projectcode')->nullable(false)->change();
            $table->string('github_repository')->nullable(false)->change();
        });
    }
}
