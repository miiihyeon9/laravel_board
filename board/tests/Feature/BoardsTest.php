<?php

namespace Tests\Feature;

use App\Models\Boards;
use App\Models\Users;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoardsTest extends TestCase
{
    // 명령어
    // php artisan make:test 파일명 
    // 이름의 끝이 Test로 끝날 것 

    use RefreshDatabase; // 테스트 완료 후 DB 초기화를 위한 트레이트 테스트를 진행할 때 더미데이터를 쌓아주고 테스트가 끝날 경우 데이터를 정리해줌 
    use DatabaseMigrations; // DB Migration


    
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // ! 메소드는 항상 test로 시작 
    // 인덱스에서 게스트일 경우 리다이렉트가 제대로 되는지 
    public function test_index_guest_redirect()
    {
        
        $response = $this->get('/boards');
        $response->assertRedirect('/users/login');
    }


    public function test_index_user_certification(){
        // 테스트용 유저 생성
        $user = new Users([ 
            'email' => 'aa@aa.aa'
            ,'name'=> '김미현'
            ,'password' => '1234qwer!'
        ]);

        $user->save();
        $response = $this->actingAs($user)->get('/boards');
        // 권한 확인
        $this->assertAuthenticatedAs($user);

        // view 확인
        // $response->assertViewIs('list');

        
    } 

    public function test_index_userauth_view(){
        // 테스트용 유저 생성
        $user = new Users([ 
            'email' => 'aa@aa.aa'
            ,'name'=> '김미현'
            ,'password' => '1234qwer!'
        ]);

        $user->save();
        $response = $this->actingAs($user)->get('/boards');
        // 권한 확인
        // $this->assertAuthenticatedAs($user);

        // view 확인
        $response->assertViewIs('list');

        
    } 


    public function test_index_userauth_view_datacheck(){
        // 테스트용 유저 생성
        $user = new Users([ 
            'email' => 'aa@aa.aa'
            ,'name'=> '김미현'
            ,'password' => '1234qwer!'
        ]);

        $user->save();

        $board1 = new Boards([
            'title' => 'test1'
            ,'content' => 'content1'
        ]);

        $board1->save();

        $board2 = new Boards([
            'title' => 'test2'
            ,'content' => 'content2'
        ]);

        $board2->save();

        $response = $this->actingAs($user)->get('/boards');

        $response->assertViewHas('data');
        $response->assertsee('test1');
        $response->assertsee('test2');
        
    } 
}
