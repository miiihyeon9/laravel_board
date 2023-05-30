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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // PK는 정수형 
            // 문자열을 PK로 잡으면 속도가 굉장히 느려짐 
            $table->string('password');
            $table->string('email')->unique();
            $table->string('name');
            //  rememberToken() => 엘로퀀트가 지원하는 메소드 
            // 로그인 유지하기 기능
            // 가지고 있는 토큰과 유저가 보낸 토큰과 일치할 경우 로그인 유지 (엘로퀀트 사용할 경우만 )
            $table->rememberToken();
            // $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
