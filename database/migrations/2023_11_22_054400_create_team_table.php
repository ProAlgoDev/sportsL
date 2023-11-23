<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('teamId');
            $table->string('teamName');
            $table->string('sportsType');
            $table->string('area');
            $table->string('age');
            $table->string('sex');
            $table->string('owner');
            $table->string('teamAvatar')->default('default_avatar.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team');
    }
};
