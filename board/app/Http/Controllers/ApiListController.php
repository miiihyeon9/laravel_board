<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boards;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
class ApiListController extends Controller
{
    function getlist($id){
        $boards = Boards::find($id);
        return response()->json([$boards],200);
        // response() html형태로  reponse 
    //json은 우리가 가지고 있는 데이터를 외부에 보내는 것이기 때문에 필요한 데이터만 보내주어야 함
    }

    function postlist(Request $request){
        // 처음에 유저인증을 해줘야함 
        // 토큰을 가져와서 요청한 유저와 토큰이 저장된 유저와 일치한지(?)
        // 확인을 하고 가져옴? 맞나? 이게? 

        //! 유효성 체크 필요 
        // new 해서 새로운 validate를 생성 
        // 강제로 리턴이 되는 상황을 막음 
        $boards = new Boards([
            'title' =>$request->title 
            ,'content' =>$request->content
        ]);

        $boards->save();

        $arr['errorcode'] = '0';
        $arr['msg'] = 'success';
        $arr['data'] = $boards->only('id','title');
        // return response()->json([$boards],200);
        return $arr;
    }
        //method('put') : 정보 수정
        function putlist(Request $request, $id){
            // ! Get이외에는 postman에서 body로 체크해야함
            // $arr = [ 'id' => $id];

            // $request->merge($arr);
            
            
            // $validator = Validator::make($request->only('id','title','content'), [
            //     'id'        => 'required|integer'    
            //     ,'title'     =>  'required|between:3,30'
            //     ,'content'  =>  'required|max:2000'
            // ]);

            // $request->validate([
                // 'id'        => 'required|integer'    


            //! 내가한거
            $arr = [ 'id' => $id];

            $request->merge($arr);
            $validator = Validator::make($request->only('id','title','content'),[
                'id'        => 'required|integer'  
                ,'title'    =>  'required|between:3,30'
                ,'content'  =>  'required|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->messages()],Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $boards = Boards::find($id);
                $boards->title = $request->title;
                $boards->content = $request->content;
                $boards->save();

                $result['errorcode'] = '0';
                $result['msg'] = 'success';
                $result['data'] = $boards->only('id','title','content');

                return response()->json($result,Response::HTTP_OK);
                // return $result;
            }

            //! Teacher
            // api를 보낼 때 어떤 형식으로 보낼지 작성을 해놔야함
            // $arrData = [
            //     'code'      => '0'
            //     ,'msg'  => ''
            //     // ,'errmsg'   => []
            //     // ,'org_data' => []
            //     // ,'udt_data' => []
            // ];


            // $data = $request->only('title','content');
            // // 세그먼트를 넣어줌 
            // $data['id'] = $id;
            // $validator = Validator::make($data,[
            //     // exists는 데이터베이스에 질의를 하기 때문에 사용할 때 고려해봐야할사항
            //     'id'    => 'required|integer|exists:boards'
            //     ,'title'     =>  'required|between:3,30'
            //     ,'content'  =>  'required|max:2000'
            // ]);

            // if ($validator->fails()) {
            //     $arrData['code']    = 'E01';
            //     $arrData['msg']     = 'Validate Error';
            //     $arrData['errmsg']  = $validator->errors()->all();
            //     return $arrData;    // array형태지만 실제로 json형태로 보내짐 라라벨에서 배열을 리턴했을 때 자동으로 json으로 보내줌 
            //    // return response()->json(['errors'=>$validator->messages()],Response::HTTP_UNPROCESSABLE_ENTITY);
            // }else{

            //     // 업데이트 처리 
            //     $board = Boards::find($id);
            //     $board->title = $request->title;
            //     $board->content = $request->content;
            //     $board->save();

            //     $arrData['code'] = '0';
            //     $arrData['msg'] = 'Update Completed';
            //     return $arrData;

            // }

        }
        // method('delete') : 정보 삭제 
    function deletelist($id){
        // $boards = Boards::find($id)->delete();
        // $result['errorcode']= '0';
        // $result['msg'] ='success';
        // // return $result;
        // return response()->json($result,Response::HTTP_OK);
        $arrData=[
            'code'  => '0'
            ,'msg'  => 'success'
        ];
        $data['id'] =  $id;
        $validator = Validator::make($data,[
            'id'=> 'required|integer|exists:boards,id'
        ]);
        if($validator->fails()){
            $arrData['code'] = 'E01';
            $arrData['msg'] = 'Error';
            $arrData['errmsg'] = 'id not found';
        }else{
            $board = Boards::find($id);
            if($board){
                $board->delete();
            }else{
                $arrData['code'] = 'E02';
                $arrData['msg'] = 'Error';
                $arrData['errmsg'] = 'Already Deleted';
            }
        }
        return $arrData;
    }

}
