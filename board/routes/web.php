<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//* 기본적인 라우팅 
// - URL과 클로저(익명함수)로 정의 
// - 모든 라라벨 라우트는 route 디렉토리 안에 들어 있는 라우트 파일에 정의 
//      이 파일은 App\Providers\RouteServiceProvider에 의해 자동으로 로드 
//  routes/web.php 파일은 웹 인터페이스를 위한 라우트들을 정의. 
//                          이 라우트들은 세션 상태와 CSRF 보호와 같은 기능을 제공하는 web 미들웨어 그룹이 할당 
// routes/web.php에 정의된 라우트는 브라우저를 통해서 유입되는 라우트 URL을 정의하는데 사용 

// php artisan route:list    (애플리케이션에 정의되어 있는 모든 라우트의 목록 조회)
// php artisan route:list -v  (미들웨어 표시 가능)
// php artisan route:list --except-vendor    (애플리케이션 고유의 라우트가 아닌 써드파티를 통해서 정의된 라우트를 표시 하지 않을 수 있습니다.)

//*라우터 메서드 
// Route::get($url, $callback);
// Route::post($url, $callback);
// Route::put($url, $callback);
// Route::patch($url, $callback);
// Route::delete($url, $callback);
// Route::options($url, $callback);

// 여러 HTTP 메서드에 응답하는 라우트 등록 => match 메서드 사용 
// Route::match(['get','post'],'/',function(){
    //     //
    // });
// 모든 HTTP 메서드에 응답하는 라우트 등록 => any 메서드 사용
// Route::any('/',function(){
    //
// });
//! 동일한 URL을 공유하는 여러개의 라우트를 정의할 때는 get, psot, put, patch, delete, options메서드를 any,match,redirect보다 먼저 정의 

//! 의존성 주입
// 라우트 클로저를 정의할 때 의존성을 타입힌트 가능. 선언되어 있는 의존 객체는 서비스 컨테이너에 의해 자동으로 주입. 
// 예를 들어 Illuminate\Http\Request클래스를 타입힌트 하여 현재 HTTP 요청객체를 라우트 클로저에 자동으로 전달 

//* CSRF
// POST, PUT,PATCH 또는 DELETE를 가리키는 라우트들은 모두 CSRF 토큰 빌드를 포함해야함 


//! 라우트 파라미터 
//*필수 파라미터 
//- 라우트중 URL 세그먼트를 필요로 하는 경우 
// Route::get('/user/{id}', function($id){
//     return 'User'.$id;
// });
// - 여러 파라미터 정의 가능 
// Route::get('/user/{id}/coments/{coments}', function($id, $coments){
//     return 'User'.$id.$coments;
// });

// * 파라미터와 의존성 주입 
// 라우트에 라라벨의 서비스 컨테이너가 주입해주는 의존성이 존재하는 경우, 의존 객체 뒤에 라우트 파라미터 나열 
// Route::get('/user/{id}',function(Request $request, $id){
//     return 'user'.$id;
// });


//*선택적 파라미터 
// 경우에 따라 URL에 항상 존재하지 않을 수 있는 경로 매개변수를 지정해야 할 수도 있음. 
// !=> 매개변수 이름 뒤에 ? 표시하고, 경로의 해당 변수에 기본값을 지정해야 함. 
// Route::get('/user/{id?}',function ($id=null){
//     return $id;
// });

//* 이름이 지정된 라우트 
// - 이름이 지정된 라우트는 URL의 생성이나 지정된 라우트로의 리다이렉션을 편리하게 해줌. 
// => name()메서드 체이닝하여 라우트 이름 지정
// Route::get('/user/profile',function(){
//     //
// })->name('profile');

//! 라우트 그룹
// 라우트 그룹을 사용하면 미들웨어와 같은 라우트 속성을 공유할 수 있어서,
// 많은 수의 라우트를 등록할 때 각각의 개별 라우트에 매번 속성들을 정의하지 않아도 됨. 

//*라우트의 그룹 및 공통 경로 설정
// 공통 경로
// prefix() : 접두사 (그룹 이름 설정)
// group() : 여러개의 라우트를 하나의 그룹으로 묶어줌. 
// 공통된 특수한 미들웨어 처리가 있을 경우 공통으로 묶음
                // 미들웨어 : 경로에 지정된 처리의 실행 전후에 임의의 처리를 실행
                // Request나 Response에 포함 된 값의 갱신이나, 암호화, 세션실행, 인증처리 등 
                // Route::middleware('auth')->prefix('users')->group(function(){

                //     Route::get('/login',function(){
                //         return 'Login!!';
                //     })->name('users.login');
                
                //     Route::get('/logout',function(){
                //         return 'Logout!!';
                //     })->name('users.logout');
                
                //     Route::get('/registration',function(){
                //         return 'registration!!';
                //     })->name('users.registration');
                
                // });
//* 미들웨어 
// 그룹 안의 모든 라우트에 미들웨어를 할당하기 위해서, 그룹을 정의하기전에 middleware 메서드 사용. 미들웨어는 배열에 나열된 순서대로 실행 
//! Route::middleware(['first', 'second'])->group(function () {
//     Route::get('/', function () {
//         // Uses first & second middleware...
//     });

//     Route::get('/user/profile', function () {
//         // Uses first & second middleware...
//     });
// });

// *컨트롤러 
// 라우트 그룹이 동일한 컨트롤러를 사용하는 경우 controller 메소드를 사용하여 라우트 그룹 안에 정의하는 모든 라우트에 대해 공통 컨트롤러를 정의 
// 컨트롤러 생성 : php artisan make:controller TestController
// use App\Http\Controllers\TestController;
// Route::get('/test',[TestController::class,'index'])->name('tests.index');

// 커맨드로 컨트롤러 생성
// php  artisan make:controller TasksController --resource

Route::get('/', function () {

    return view('welcome');
});

// resource는 restful api에 기준을 맞춰서 만들어짐
Route::resource('/boards',BoardsController::class);

// Users
// get은 화면에 띄울 때 
// post는 데이터베이스 갱신할 때 
Route::get('/users/login',[UserController::class,'login'])->name('users.login');
Route::post('/users/loginpost',[UserController::class,'loginpost'])->name('users.login.post');
Route::get('/users/registration',[UserController::class,'registration'])->name('users.registration');
Route::post('/users/registrationpost',[UserController::class,'registrationpost'])->name('users.registration.post');
// Route::post('/users/logoutpost',[UserController::class,'logoutpost'])->name('users.logout.post');
