@extends('layout.layout')





    @section('contents')
        <main>
            <button type="button" onclick="location.href='{{route('boards.index')}}'">뒤로 가...</button>
            <div class="listBox formGrid writeGrid">
                <div class="board_number">게시글 번호</div>
                <div class="board_number" >{{$data->id}}</div>
                <div>작성일</div> 
                <div>{{$data->created_at}}</div>
                <div>게시글 제목</div> 
                <div>{{$data->title}}</div>
                <div>조회 수</div>
                <div>{{$data->hits}}</div>
                <div>게시글 내용</div> 
                <textarea readonly class="contents_write">{{$data->content}}</textarea>
            </div>
            <button type="button" onclick="location.href='{{route('boards.edit',[$data->id])}}'">수정하기</button>
            <form action="{{route('boards.destroy',[$data->id])}}" method="post">
                {{-- url이 똑같아도 메소드가 달라서 boards.show나 boards.update로 적어도 삭제가 됨 --}}
                {{-- boards.destroy  /  boards.show  / boards.update의 url이 boards/{board}이기 때문에 다른 url을 사용해도 method가 delete기 때문에 삭제가 됨 --}}
                @csrf
                @method('DELETE')
                    <button type="submit" class="main_button_2">삭제하기</button>
            </form>
        </main>  
    @endsection
