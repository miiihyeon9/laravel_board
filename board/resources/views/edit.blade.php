@extends('layout.layout')

@section('layout')
<link rel="stylesheet" href="{{asset('css/update.css')}}">
@endsection

@section('contents')
<main>
    <button type="button" class="mian_button_2" onclick="location.href='{{route('boards.index')}}'">뒤로 가...</button>
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
</main>
@endsection


