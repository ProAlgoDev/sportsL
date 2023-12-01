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
        Schema::create('defaultcategory', function (Blueprint $table) {
            $table->id();
            $table->string('teamId');
            $table->string('defaultCategory');
            $table->timestamps();
        });
        DB::table('defaultcategory')->insert([
            ['teamId' => 'default', 'defaultCategory' => '月謝'],
            ['teamId' => 'default', 'defaultCategory' => '積立'],
            ['teamId' => 'default', 'defaultCategory' => '保険'],
            ['teamId' => 'default', 'defaultCategory' => '旅費交通費'],
            ['teamId' => 'default', 'defaultCategory' => 'コーチ費'],
            ['teamId' => 'default', 'defaultCategory' => '施設利用費'],
            ['teamId' => 'default', 'defaultCategory' => '消耗品費'],
            ['teamId' => 'default', 'defaultCategory' => 'ユニフォーム費'],
            ['teamId' => 'default', 'defaultCategory' => '飲食費'],
            ['teamId' => 'default', 'defaultCategory' => '差入れ費'],
            ['teamId' => 'default', 'defaultCategory' => '登録・更新費'],
            ['teamId' => 'default', 'defaultCategory' => '水道光熱費'],
            ['teamId' => 'default', 'defaultCategory' => '会議費'],
            ['teamId' => 'default', 'defaultCategory' => '研修費'],
            ['teamId' => 'default', 'defaultCategory' => 'イベント費'],
            ['teamId' => 'default', 'defaultCategory' => 'その他'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defaultcategory');
    }
};
