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
        Schema::create('area_list', function (Blueprint $table) {
            $table->id();
            $table->string('areaId');
            $table->string('areaName');
            $table->timestamps();
        });
        DB::table('area_list')->insert([
            ['areaId' => '01', 'areaName' => '三重県'],
            ['areaId' => '02', 'areaName' => '京都府'],
            ['areaId' => '03', 'areaName' => '佐賀県'],
            ['areaId' => '04', 'areaName' => '兵庫県'],
            ['areaId' => '05', 'areaName' => '北海道'],
            ['areaId' => '06', 'areaName' => '千葉県'],
            ['areaId' => '07', 'areaName' => '和歌山県'],
            ['areaId' => '08', 'areaName' => '埼玉県'],
            ['areaId' => '09', 'areaName' => '大分県'],
            ['areaId' => '10', 'areaName' => '大阪府'],
            ['areaId' => '11', 'areaName' => '奈良県'],
            ['areaId' => '12', 'areaName' => '宮城県'],
            ['areaId' => '13', 'areaName' => '宮崎県'],
            ['areaId' => '14', 'areaName' => '富山県'],
            ['areaId' => '15', 'areaName' => '山口県'],
            ['areaId' => '16', 'areaName' => '山形県'],
            ['areaId' => '17', 'areaName' => '山梨県'],
            ['areaId' => '18', 'areaName' => '岐阜県'],
            ['areaId' => '19', 'areaName' => '岡山県'],
            ['areaId' => '20', 'areaName' => '岩手県'],
            ['areaId' => '21', 'areaName' => '島根県'],
            ['areaId' => '22', 'areaName' => '広島県'],
            ['areaId' => '23', 'areaName' => '徳島県'],
            ['areaId' => '24', 'areaName' => '愛媛県'],
            ['areaId' => '25', 'areaName' => '愛知県'],
            ['areaId' => '26', 'areaName' => '新潟県'],
            ['areaId' => '27', 'areaName' => '栃木県'],
            ['areaId' => '28', 'areaName' => '沖縄県'],
            ['areaId' => '29', 'areaName' => '滋賀県'],
            ['areaId' => '30', 'areaName' => '熊本県'],
            ['areaId' => '31', 'areaName' => '石川県'],
            ['areaId' => '32', 'areaName' => '神奈川県'],
            ['areaId' => '33', 'areaName' => '福井県'],
            ['areaId' => '34', 'areaName' => '福岡県'],
            ['areaId' => '35', 'areaName' => '福島県'],
            ['areaId' => '36', 'areaName' => '秋田県'],
            ['areaId' => '37', 'areaName' => '群馬県'],
            ['areaId' => '38', 'areaName' => '茨城県'],
            ['areaId' => '39', 'areaName' => '長崎県'],
            ['areaId' => '40', 'areaName' => '長野県'],
            ['areaId' => '41', 'areaName' => '青森県'],
            ['areaId' => '42', 'areaName' => '静岡県'],
            ['areaId' => '43', 'areaName' => '香川県'],
            ['areaId' => '44', 'areaName' => '高知県'],
            ['areaId' => '45', 'areaName' => '鳥取県'],
            ['areaId' => '46', 'areaName' => '鹿児島県'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_list');
    }
};
