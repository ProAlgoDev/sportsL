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
            ['sportsId' => '01', 'sportsType' => 'サッカー'],
            ['sportsId' => '02', 'sportsType' => 'フットサル'],
            ['sportsId' => '03', 'sportsType' => '野球'],
            ['sportsId' => '04', 'sportsType' => 'ソフトボール'],
            ['sportsId' => '05', 'sportsType' => 'ゴルフ'],
            ['sportsId' => '06', 'sportsType' => 'テニス'],
            ['sportsId' => '07', 'sportsType' => 'パデル'],
            ['sportsId' => '08', 'sportsType' => 'バスケットボール'],
            ['sportsId' => '09', 'sportsType' => 'ラグビー'],
            ['sportsId' => '10', 'sportsType' => 'バレーボール'],
            ['sportsId' => '11', 'sportsType' => 'アメリカンフットボール'],
            ['sportsId' => '12', 'sportsType' => 'バドミントン'],
            ['sportsId' => '13', 'sportsType' => 'ハンドボール'],
            ['sportsId' => '14', 'sportsType' => '卓球'],
            ['sportsId' => '15', 'sportsType' => 'クリケット'],
            ['sportsId' => '16', 'sportsType' => 'ラクロス'],
            ['sportsId' => '17', 'sportsType' => 'ドッジボール'],
            ['sportsId' => '18', 'sportsType' => 'ゲートボール'],
            ['sportsId' => '19', 'sportsType' => 'ボウリング'],
            ['sportsId' => '20', 'sportsType' => 'スカッシュ'],
            ['sportsId' => '21', 'sportsType' => 'ビリヤード'],
            ['sportsId' => '22', 'sportsType' => 'ランニング・マラソン'],
            ['sportsId' => '23', 'sportsType' => '陸上'],
            ['sportsId' => '24', 'sportsType' => '水泳'],
            ['sportsId' => '25', 'sportsType' => 'フィットネス'],
            ['sportsId' => '26', 'sportsType' => 'ヨガ'],
            ['sportsId' => '27', 'sportsType' => '体操'],
            ['sportsId' => '28', 'sportsType' => 'ダンス'],
            ['sportsId' => '29', 'sportsType' => 'サイクリング'],
            ['sportsId' => '30', 'sportsType' => '射撃'],
            ['sportsId' => '31', 'sportsType' => 'ダーツ'],
            ['sportsId' => '32', 'sportsType' => 'スキー'],
            ['sportsId' => '33', 'sportsType' => 'スノーボード'],
            ['sportsId' => '34', 'sportsType' => 'フィギュアスケート'],
            ['sportsId' => '35', 'sportsType' => 'フィールドホッケー'],
            ['sportsId' => '36', 'sportsType' => 'アイスホッケー'],
            ['sportsId' => '37', 'sportsType' => '相撲'],
            ['sportsId' => '38', 'sportsType' => '柔道'],
            ['sportsId' => '39', 'sportsType' => '剣道'],
            ['sportsId' => '40', 'sportsType' => '空手'],
            ['sportsId' => '41', 'sportsType' => 'ボクシング'],
            ['sportsId' => '42', 'sportsType' => 'フェンシング'],
            ['sportsId' => '43', 'sportsType' => 'ムエタイ'],
            ['sportsId' => '44', 'sportsType' => 'レスリング'],
            ['sportsId' => '45', 'sportsType' => '総合格闘技'],
            ['sportsId' => '46', 'sportsType' => 'テコンドー'],
            ['sportsId' => '47', 'sportsType' => 'モータースポーツ'],
            ['sportsId' => '48', 'sportsType' => 'F1'],
            ['sportsId' => '49', 'sportsType' => 'ストリートサッカー'],
            ['sportsId' => '50', 'sportsType' => 'セパタクロー'],
            ['sportsId' => '51', 'sportsType' => 'アウトドアスポーツ'],
            ['sportsId' => '52', 'sportsType' => 'サーフィン'],
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
