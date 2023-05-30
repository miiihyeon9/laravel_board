@extends('layout.layout')



@section('contents')
<main>
    @if( count($errors) > 0 )
        {{-- erros->all() $errors객체에서 필요한 것만 가져와줌 --}}
        @foreach($errors->all() as  $error)
            <div>{{$error}}</div>
        @endforeach
    @endif
    <button type="button" class="mian_button_2" onclick="location.href='{{route('boards.index')}}'">뒤로 가...</button>
    <form action="{{route('boards.update',['board' => $data->id])}}" method="post" class="listBox formGrid writeGrid">
        @csrf
        @method('put')
        <label for="title">Title : </label>
        <input type="text" name="title" id="title" value="{{ count($errors) > 0 ? old('title') : $data->title }}">
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="30" rows="10" >{{count($errors) > 0 ? old('content') : $data->content}}</textarea>
        <button type="submit">수정</button>
        <button type="button" onclick="location.href='{{route('boards.show', ['board' => $data->id])}}'">취소</button>
    </form>
</main>
@endsection
