<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
</head>
<body>
    <button type="button" onclick="location.href='{{route('boards.index')}}'">뒤로 가...</button>
    <button type="button" onclick="location.href='{{route('boards.edit',[$data->id])}}'">수정하기</button>
    <form action="{{route('boards.destroy',[$data->id])}}" method="post">
    {{-- url이 똑같아도 메소드가 달라서 boards.show나 boards.update로 적어도 삭제가 됨 --}}
    {{-- boards.destroy  /  boards.show  / boards.update의 url이 boards/{board}이기 때문에 다른 url을 사용해도 method가 delete기 때문에 삭제가 됨 --}}
    @csrf
    @method('DELETE')
        <button type="submit" >삭제하기</button>
    </form>
    <div>
        글 번호 : {{$data->id}}
        <br>
        제목 : {{$data->title}}
        <br>
        내용 :{{$data->content}}
        <br>
        등록일자 :{{$data->created_at}}
        <br>
        수정일자 :{{$data->updated_at}}
        <br>
        조회수 :{{$data->hits}}
    </div>
</body>
</html>