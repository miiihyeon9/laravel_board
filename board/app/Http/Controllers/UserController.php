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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // ! 데이터베이스가 갱신이 되는 부분은 뒤로가기 막는게 좋음
    // redirect()->with() : session에 등록

    // view()->with() : 변수로 사용 가능 
    // !redirect와 view의 차이
    // redirect와 view는 요청을 하냐 안하냐의 차이 
    // redirect()는 url를 변경시키는 함수
    // view()는 특정 url 요청이 들어왔을 때, 특정 view페이지를 반환해서 화면에 띄워주고 싶을 때 사용

    // 
    function login(){
        // 배포 할 경우에는 warning이상만 경고
        // $arr['key'] ='test';
        // $arr['kim'] = 'park';
        // Log::emergency('emergency',$arr);
        // Log::alert('alert',$arr);
        // Log::critical('critical',$arr);
        // Log::error('error',$arr);
        // Log::warning('warning',$arr);   // 서비스할 때는 warning까지만
        // Log::notice('notice',$arr);
        // Log::info('info',$arr);
        // Log::debug('debug',$arr);   // 개발할 때는 Log::로 확인
        
        return view('login');
    }
    
    function loginpost(Request $request){
        // 유저 정보 습득 
        $user = Users::where('email',$request->email)->first();       
        // 유저 인증 작업
        Auth::login($user);// 알아서 토큰이나 세션을 넣어줌 
        if(Auth::check()){
            session($user->only('id')); // 세션에 인증된 회원 pk 등록
            
            if($user->password_flg === '1'){
                    return redirect()->route('users.edit');
                } 
            
            // 유효성 검사 
            $request->validate([
                'email'    => 'required|email|max:100'
                //한글자 이상의 영어, 특수문자, 숫자(필수)를 8~20자
                ,'password' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
            ]);

        // email이 request->email과 일치한 첫번째 데이터를 가져오겠다. 
        // $user가 존재하지 않거나, 비밀번호가 일치하지 않을 경우
        // (Hash::check($request->password, $user->password) : 해시화된 비밀번호와 요청된 비밀번호 체크
        if(!$user || !(Hash::check($request->password, $user->password))){
            $error = '아이디와 비밀번호를 확인해 주세요.';
            return redirect()
                    ->back()
                    // Illuminate\Support\Collection 클래스는 배열 데이터를 사용하기 위한 유연하고 편리한 래퍼(wrapper)를 제공
                    // collect 헬퍼를 사용하면 배열에서 새로운 컬렉션 인스턴스를 생성하고
                    ->with('error',$error);
        }




            //intended()는 완전 새로운 redirect이기 때문에 필요없는 데이터는 모두 정리해줌 

            // 유저 인증 작업을 완료하고 원래 접속하려고한 url에 접속하게 해주고 만약에 실패할 경우 intended()에 있는 url로 이동
            return redirect()->intended(route('boards.index'));
        }else{
            $error = '유저 인증 작업 에러. 잠시 후에 다시 입력해 주세요';
            return redirect()->back()->with('error',$error);
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
        // 패스워드 해시화
        $data['password'] = Hash::make($request->password);
        // create()는 laravel에서 지원해주는 method
        
        $user = Users::create($data);   // insert 
        if(!$user){
            $error = '시스템 에러가 발생하여, 회원가입에 실패했습니당.<br> 잠시 후에 다시 시도해 주세용';

            return redirect()
                    ->route('users.registration')
                    ->with('error',$error);
        } 

        // 회원가입 완료 로그인 페이지 이동
        return redirect()
                ->route('users.login')
                ->with('success','회원가입을 완료했습니다.<br>가입하신 아이디와 비밀번호로 로그인을 해 주세요.');
    }

    function logout(){
        // Auth::logoutOtherDevices();

        // Session::flash(); // 세션 파기
        Session::flush();
        Auth::logout();// 로그아웃 처리
        return redirect()->route('users.login');
    }

    function withdraw(){
        //원래는 post로 보내서 따로 아이디를 보내줘야함.
        $id = session('id');
        
        // 에러가 떴을 경우 어떻게 처리할지 해줘야함 
        // 에러가 떴을 경우,(Error 핸들링)
        // 정상적으로 처리했을 경우 
        $result = Users::destroy($id);
        Session::flush();
        Auth::logout();
        return redirect()->route('users.login');
    }

    function edit(){
        $id = session('id');
        $users = Users::find( $id ); 
        // $users = Users::find(Auth::User()->id);      // 권한으로 체크 security에서 이게 좋을 수 있음~! 121행과 같음 
        return view('useredit')->with('user',$users);
        // return view('useredit');
    }



    function editput(Request $request){
        // $id = session('id');
        // $arr = ['id' => $id ];
        //$request 객체 안에 $arr을 넣는다 merge()자체가 현재 request의 input 배열에 ($arr)을 합치는 거
        // $request->merge($arr);

        // $request->validate([
        //     'name'      => 'required|regex:/^[가-힣]+$/|min:2|max:30'
        //                                                                 //한글자 이상의 영어, 특수문자, 숫자(필수)를 8~20자
        //     ,'password' => 'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        // ]);

        $arrKey=[];
        //ㅡㅡㅡㅡㅡㅡ유효성 체크 하는 모든 항목 리스트 
        $chkList=[
            // 'id'        => 'required|integer'
            'email'    =>  'requuired|email|max:100'
            ,'name'     =>  'required|regex:/^[가-힣]+$/|min:2|max:30'
            // ,'beforePassword'  =>  'regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
            ,'password'  =>  'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ];
        $baseUsers = Users::find(Auth::User()->id); // 기존 데이터 가져옴 

        // if(!Hash::check($request->beforePassword, $baseUsers->password)){
        //     return redirect()->back()->with('error','기존 비밀번호를 확인해 주세요.');
        // }

        // 수정할 항목을 배열에 담는 처리
        if($request->name !== $baseUsers->name){
            $arrKey[]='name';
        }

        if($request->email !== $baseUsers->email){
            $arrKey[]='email';
        }
        if(isset($request->password)){
            $arrKey[]='password';
        }
        // var_dump($request,$arrKey);
        //ㅡㅡㅡㅡㅡ 수정할 항목을 배열에 담는 처리 end ㅡㅡㅡㅡㅡㅡㅡ
        // 유효성 체크할 항목 셋팅하는 처리 
        // $arrCheck['beforePassword'] = $chkList['beforePassword'];
        // 루프를 최대한 적게 돌리기 위해서
        //arrkey는 수정하고 싶은 항목만 들어있음
        // checklist는 수정뿐만 아니라 모든 항목이 들어가있음. 
        // 루프를 돌릴 때 모든 항목이 들어있는 checklist가 리소스를 더 먹기 때문에 
        // 루프를 최대한 적게 돌리기 위해 $arrKey 사용 
        foreach($arrKey as $val){
            $arrCheck[$val] = $chkList[$val]; 
        }

        // return var_dump($request);
        $request->validate($arrCheck);
        //todo: password_flg =1 인 경우 0으로 바꿔줘야함 
        foreach($arrKey as $val){
            if($val === 'password'){
                $baseUsers->$val = Hash::make($request->$val);
                continue;   // continue를 만나면 다음 코드를 넘어가고 루프시작 
            }

            $baseUsers->$val = $request->$val;
        }

        if($baseUsers->password_flg === '1'){
            $baseUsers->password_flg ='0';
        }
        $baseUsers->save(); // update


        Session::flush();
        Auth::logout();
        return redirect()->route('users.login');




        //! 내가 한거 
        // $validator = Validator::make(
        //     $request->only('id','name','password','passwordchk')
        //     // 유효성 검사 
        // ,[
        //     'id'        => 'required|integer'
        //     ,'name'     =>  'required|regex:/^[가-힣]+$/|min:2|max:30'
        //     ,'password'  =>  'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        // ]);

        // //fails() : 실패했을 경우 boolean으로 나옴
        // if($validator->fails()){
        //     // 요청했던 페이지로 다시 이동 => edit페이지로 다시 이동 
        //     // withErrors () : 세션에 에러메시지를 플래시함. 뷰에 old()메서드를 사용해서 오류메세지를 쉽게 출력할 수 있음 
        //     // withInput() : 우리가 받은 request를 session에 등록하고 session을 가져옴 
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // //! ORM 사용
        // $result = Users::find($id);
        // $result->name = $request->name;
        // $result->password = Hash::make($request->password);
        // $result->save();

        // Session::flush();
        // Auth::logout();
        // return redirect()->route('users.login')->with('success','정보 변경이 완료되었습니다. 다시 로그인 하세요');;
    }

    function check(){
        return view('check');
    }

    function checkpost(Request $request){
        // 비밀번호 입력한 값과 세션에 있는 비밀번호가 일치한지 확인
        // 기존 데이터 베이스에서 정보를 가져오고
        $baseUsers = Users::find(Auth::User()->id);
        // 요청된 패스워드와 데이터베이스의 패스워드가 일치할 경우 
        // user.edit으로 이동

        if(!(Hash::check($request->password, $baseUsers->password))){
            return redirect()->back()->with('error','비밀번호를 틀리셨습니다.');
        }else{
            return redirect()->route('users.edit');
        }
    }

    function findpassword(){
        return view('findpassword');
    }

    function findpasswordpost(Request $request){
        // 비밀번호 찾기 
        // 유저가 입력한 name과 email이 기존 데이터와 일치한지,
        // var_dump($request->all());
        // email은 유니크이기때문에 email로 확인 
        $baseUsers = Users::where('email',$request->email)->first();
        // 정보를 잘못 입력했을 경우 
        // return var_dump($baseUsers->name);
        if(!$baseUsers){
            return redirect()->back()->with('error','정보를 잘못 입력하셨습니다. 다시 입력해 주세요.');
        }
        // 요청된 이름과 이메일이 데이터베이스에 일치한 데이터가 있을 경우 
        if(($request->name === $baseUsers->name)&&($request->email === $baseUsers->email)){
            // 랜덤으로 문자8자리 알려줌 -> 랜덤문자는 비밀번호 -> password_flg 1로 변경 
            $baseUsers->password = Str::random(8);
            $baseUsers->password_flg = '1';
            $baseUsers->save();
            $randompassword = $baseUsers->password;
            // session($randompassword);
            // session(['randompassword' => $randompassword]);
            return redirect()->route('users.randompassword')->with('randompassword',$randompassword);
        }
    } 

    function randompassword(){
        // $randompassword = session('randompassword');
        // var_dump($randompassword);
        return view('randompassword');
    }
    

    // function joinquery(Request $request){
         // *쿼리를 직접 전달하는 방식 
    //     DB::statement('drop table users');

    //     //* SELECT 쿼리를 직접 전달하고 파라미터를 바인딩하는 호출 방식 
    //     DB::select('select * from users where email = ?' ,[$request->email]);

    //     //* 체이닝 방법을 사용하여 데이터 조회
    //     DB::table('users')->get();

    //     //* 다른 테이블과의 join구문을 체이닝으로 호출 
    //     DB::table('users')->join('boards',function($join){
    //         $join->on('users.id','=','boards.user_id')
    //         ->where('조건');
    //     })->get();
    // }
    // select,insert,update,delete를 써주는게 좋음 
    // update, delete는 쿼리를 실행한 후 영향을 받은 레코드 개수를 반환함. 
    
    
}