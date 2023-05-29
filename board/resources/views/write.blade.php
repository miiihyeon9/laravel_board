@extends('layout.layout')



@section('contents')
    <main>
        <form action="{{route('boards.store')}}" method="post" class="listBox formGrid writeGrid" >
            @csrf
            <label for="title">Title</label>
            <input type="text" name="title" id="title" >

            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="10" class="contentsWrite"></textarea>
            <button type="submit" class="listBtn">작성</button>
            
        </form>
    </main>
@endsection