<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('sports_list', function (Blueprint $table) {
            $table->id();
            $table->string('sportsId');
            $table->string('sportsType');
            $table->timestamps();

        });
        DB::table('sports_list')->insert([
            ['sportsId' => '01', 'sportsType' => '野球'],
            ['sportsId' => '02', 'sportsType' => '相撲'],
            ['sportsId' => '03', 'sportsType' => 'フットボール'],
            ['sportsId' => '04', 'sportsType' => 'テニス'],
            ['sportsId' => '05', 'sportsType' => 'ゴルフ'],
            ['sportsId' => '06', 'sportsType' => 'ボクシング'],
            ['sportsId' => '07', 'sportsType' => 'バスケットボール'],
            ['sportsId' => '08', 'sportsType' => '自動車レース'],
            ['sportsId' => '09', 'sportsType' => 'プロレス'],
            ['sportsId' => '10', 'sportsType' => '武道'],
            ['sportsId' => '11', 'sportsType' => 'スキー'],
            ['sportsId' => '12', 'sportsType' => '卓球'],
            ['sportsId' => '13', 'sportsType' => 'フィギュアスケート'],
            ['sportsId' => '14', 'sportsType' => 'クリケット'],
            ['sportsId' => '15', 'sportsType' => 'ラグビーユニオン'],
            ['sportsId' => '16', 'sportsType' => 'ハンドボール'],
            ['sportsId' => '17', 'sportsType' => 'アイスホッケー'],
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sports_list');
    }
};
