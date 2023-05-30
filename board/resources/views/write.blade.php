@extends('layout.layout')



@section('contents')
    <main>
        @include('layout.errors_validate')
        <form action="{{route('boards.store')}}" method="post" class="listBox formGrid writeGrid" >
            @csrf
            <label for="title">Title</label>
            {{-- old('name') => 작성했을 경우 세션에 있을 경우 남아있고 아니면 블랭크로 남김 --}}
            <input type="text" name="title" id="title" value="{{old('title')}}">
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="10" class="contentsWrite" >{{old('content')}}</textarea>
            <button type="submit" class="listBtn">작성</button>
        </form>
    </main>
@endsection
