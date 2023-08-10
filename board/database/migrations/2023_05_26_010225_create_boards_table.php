<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30);
            $table->string('content',2000);
            $table->integer('hits')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    //softDeletes() -> 엘로퀀트를 이용할 때만 사용 가능 / 엘로퀀트를 사용 안할 경우에는 그냥 flg를 해주는게 좋음orm을 사용 안할 경우에는 where조건
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
};
