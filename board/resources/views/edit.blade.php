<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{route('boards.update',['board' => $data->id])}}" method="post" >
        @csrf
        @method('put')
        <label for="title">Title : </label>
        <input type="text" name="title" id="title" value="{{$data->title}}" >
        <br>
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="30" rows="10" >{{$data->content}}</textarea>
        <br>
        <button type="submit">수정</button>
        <button type="button" onclick="location.href='{{route('boards.show', ['board' => $data->id])}}'">취소</button>
    </form>
</body>
</html>