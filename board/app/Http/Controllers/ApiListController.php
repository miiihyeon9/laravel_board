<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boards;

class ApiListController extends Controller
{
    function getlist($id){
        $boards = Boards::find($id);
        return response()->json([$boards],200);
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

        // 
    }
}
