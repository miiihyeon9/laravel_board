<?php
/**************************************
 * 프로젝트명 : laravel_board
 * 디렉토리   : cotroller
 * 파일명     : UserController.php
 * 이력       : v001 0530 MH.KIM new
 * *********************************** */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    function login(){
        return view('login');
    }

    function loginpost(Request $request){
        $request->validate([
            'email'    => 'required|email|max:100'
                                                          //한글자 이상의 영어, 특수문자, 숫자(필수)를 8~20자
            ,'password' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);

        // 유저 정보 습득 
        // email이 request->email과 일치한 첫번째 데이터를 가져오겠다. 
        $user = Users::where('email',$request->email)->first();
        if(!$user || !(Hash::check($request->password, $user->password))){
            $errors[] = '아이디와 비밀번호를 확인해 주세요.';
            return redirect()
                    ->back()
                    ->with('errors',collect($errors));
        }
        // 유저 인증 작업
        
        Auth::login($user);// 알아서 토큰이나 세션을 넣어줌 
        if(Auth::check()){
            session([$user->only('id')]); // 세션에 인증된 회원 pk 등록
            //intended()는 완전 새로운 redirect이기 때문에 필요없는 데이터는 모두 정리해줌 
            return redirect()->intended(route('boards.index'));
        }else{
            $errors[] = '유저 인증 작업 에러. 잠시 후에 다시 입력해 주세요';
            return redirect()->back()->with('errors',collect($errors));
        }

    }

    function registration(){
        return view('registration');
    }

    function registrationpost(Request $request){
        // 유효성 체크 
        $request->validate([
            'name'      => 'required|regex:/^[가-힣]+$/|min:2|max:30'
            ,'email'    => 'required|email|max:100'
                                                                        //한글자 이상의 영어, 특수문자, 숫자(필수)를 8~20자
            ,'password' => 'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);

        $data['name']   = $request->name;
        // 둘 다 똑같음 
        $data['email']  = $request->input('email');
        $data['password'] = Hash::make($request->password);

        $user = Users::create($data);   // 인서트 
        if(!$user){
            $errors[] = '시스템 에러가 발생하여, 회원가입에 실패했습니당.';
            $errors[] = '잠시 후에 다시 시도해 주세용';
            return redirect()
                    ->route('users.registration')
                    ->with('errors',collect($errors));
        } 

        // 회원가입 완료 로그인 페이지 이동
        return redirect()
                ->route('users.login')
                ->with('success','회원가입을 완료했습니다.<br>가입하신 아이디와 비밀번호로 로그인을 해 주세요.');
    }


}

