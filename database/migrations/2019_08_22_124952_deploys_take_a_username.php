<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeploysTakeAUsername extends Migration
{
    public function up()
    {
        Schema::table('deploys', function (Blueprint $table) {
            $table->string('username')->before('created_at');
        });
    }

    public function down()
    {
        Schema::table('deploys', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
}
