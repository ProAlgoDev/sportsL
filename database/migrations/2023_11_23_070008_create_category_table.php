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
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('teamId');
            $table->json('defaultList')->default(json_encode([
                '月謝',
                '積立',
                '保険',
                '旅費交通費',
                'コーチ費',
                '施設利用費',
                '消耗品費',
                'ユニフォーム費',
                '飲食費',
                '差入れ費',
                '登録・更新費',
                '水道光熱費',
                '会議費',
                '研修費',
                'イベント費',
                'その他',

            ]));
            $table->json('categoryList')->default(json_encode([]));
            $table->timestamps();
        });
        DB::table('category')->insert([
            ['teamId' => 'default']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
};
