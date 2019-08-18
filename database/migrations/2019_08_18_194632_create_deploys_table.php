<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeploysTable extends Migration
{
    public function up()
    {
        Schema::create('deploys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->string('stage');
            $table->string('sha1');
            $table->timestamps();

            $table->foreign('application_id')
                ->references('id')->on('applications')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deploys');
    }
}
