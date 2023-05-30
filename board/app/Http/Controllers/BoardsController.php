<?php
/*************************************
 * 프로젝트명 : laravel_board
 * 디렉토리 : cotroller
 * 파일명 : BoardsController.php
 * 이력 : v001 0526 MH.KIM new
 *        v002 0530 MH.KIM 유효성 검사
 * ************************************ */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boards;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
 
class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Boards::select(['id','title','hits','created_at','updated_at'])->orderBy('hits','desc')->get();
        return view('list')->with('data',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('write');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //store() => 새로운 게시글 insert하는 메소드
    public function store( Request $req )   // post
    {
        // v002 add start
        // 결과를 담을 변수 선언
        $req->validate([
            // 유저한테 받아야 할 값 배열로 생성
            // 필수일 경우 'required'
            // 조건을 추가할 경우 | 
            // 최소 최대 하는 방법 => min,max 사용하거나, between 사용
            // 유효성 검사 
            // title => 필수항목, 3~30글자 
            'title'     =>  'required|between:3,30'
            // content => 필수항목, 최대 1000글자 
            ,'content'  =>  'required|max:1000'
        ]);

        // 에러가 나면 변수에 error를 생성해줌

        // v002 add end


        // 유효성 검증은 프론트, 백엔드 둘 다 해줘야 함 
        // 새로운 데이터를 만들기 때문에 새로운 객체를 인스턴스화해서 인서트 
        $boards = new Boards([
                            'title'     =>$req->input('title')
                            ,'content'  => $req->input('content') 
                        ]);
        $boards->save();    // 처음에 인서트하고 인서트 실패하면 update를 함
        return redirect('/boards');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )   //detail
    {
        $boards = Boards::find( $id ); //   기존 값 가져오고
        $boards->hits++;    //  조회수 1 증가하고
        $boards->save();    // 업데이트 완료

        // Boards::find( $id ); // 예외가 발생할 시 false로 나오고
        // Boards::findOrFail($id) // 리턴이 오는게 아니라 예외처리해서 오류페이지가 뜨게한다

        return view('detail')->with('data',Boards::findOrFail($id));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )   //edit GET
    {
        $boards = Boards::find( $id ); //  
        return view('edit')->with('data',$boards);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        
        // $boards = Boards::find( $id ); // 데이터베이스에 현재 있는 데이터를 가져오는거고
        // $result = $request->all();  // 값을 받아온거 포스트로 보낸 값을 가져온 거고 
        // var_dump($result);
        // $update = DB::update('update boards set title = ? , content = ? where id = ?', [$result['title'], $result['content'], $boards->id]);    // 업데이트하고
        // DB::update('update boards set title = :title , content = :content , updated_at = NOW() where id = :id', ['title'  => $request->title,'content' => $request->content,'id' => $id]);
        // DB::table('Boards')->where('id',$id)->update(['title'=>$request->input('title'),'content'=>$request->input('content')]);
        // DB::table('Boards')->where('id',$id)->update(['title'=>$request->title,'content'=>$request->content]);

        // $boards = Boards::find( $id ); // 다시 가져와서
        // $boards->save();    // 저장하고

        // return view('detail')->with('data',$boards);


        // return view('detail')->with('data',Boards::findOrFail($id));
        //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ모델 객체를 사용했느냐 안했느냐에 따라 ORM사용여부
        // DB 를 사용한다 => ORM이 아님
        // 모델 객체를 사용한다 => ORM을 사용했다. 

        // $arr = ['id' => $id ];
        // $requestResult = $request->all(); // array token, method, title, content

        // var_dump($requestResult);
        // $merged = $arr->merge($requestResult['id']);
        // $merged->all();
        // var_dump($merged);
        // $requestResult = $request->all();
        // $requestResult['id'] = $arr['id'];
        // var_dump($request);

        //ID를 리퀘스트 객체에 머지
        //! v002 add start
        //* 1번째 방법
        $arr = ['id' => $id ];
        //$request 객체 안에 $arr을 넣는다 merge()자체가 현재 request의 input 배열에 새로운 배열을 합치는 거
        $request->merge($arr);
        //! v002 add end
        //* 2번째 방법
        // $request->request->add($arr);

        // $request->request['id']=$arr['id'];

        
        
        //! v002 add start
        // $request->validate([
        //     'id'        => 'required|integer'
        //     ,'title'     =>  'required|between:3,30'
        //     ,'content'  =>  'required|max:1000'
        // ]);
        //! v002 add end

        //* 유효성 검사 2
        // 바로 리턴 안하고 validator에 정보를 담음 
        $validator = Validator::make(
            $request->only('id','title','content')
        ,[
            'id'        => 'required|integer'
            ,'title'     =>  'required|between:3,30'
            ,'content'  =>  'required|max:2000'
        ]);
        //fails() : 실패했을 경우 boolean으로 나옴
        if($validator->fails()){
            // 요청했던 페이지로 다시 이동 => edit페이지로 다시 이동 
            // withErrors () : 에러를 가져옴 
            // withInput() : 우리가 받은 request를 session에 등록하고 session을 가져옴 
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //! ORM 사용
        $result = Boards::find($id);
        $result->title = $request->title;
        $result->content = $request->content;
        $result->save();
        // Boards::find($id);

        //! URL이 바뀌어야 할 때 무조건 redirect 
        // 요청받은 url과 보여야할 url이 다를 때 redirect 일단 머리론 이해가 가는데....
        // view('detail')로 하게 되면 update show url이 됨.

        // url이 같을 때 => method를 보고 판단함
        // put이면 기존 데이터 업데이트. // delete면 기존 데이터 삭제 // get이면 기존데이터 보여줌.

        
        // return redirect('/boards/'.$id);
        return redirect()->route('boards.show',['board' => $id]);
        
        // 겉으로 봐서는 똑같지만 사실상 다름.   


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $delete = DB::delete('delete from boards where id = :id',['id' => $id] );
        // $id->delete();
        // $boards = Boards::find( $id );
        //*1
        // $update = DB::update('update boards set deleted_at = NOW() where id = :id' ,['id'=>$id] );

        //*2
        // 엘로퀀트 ORM을 사용하고 있기 때문에 softDelete기능 사용가능
        Boards::destroy($id);

        //*3
        // delete , update insert에서 트랜잭션 해주어야함.

        $board = Boards::find($id);
        $board->delete();
        // destroy는 PK를 받아야함. delete는 객체를 먼저 만들고 delete를 체이닝 해서 써야함 왜냐하면 인수가 없기 때문
        // 엘로퀀트를 사용하지 않고 delete할 경우 레코드가 사라짐 

        
        return redirect('/boards');
    }
}