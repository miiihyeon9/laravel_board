@extends('layout.layout')
@section('layout')
<link rel="stylesheet" href="{{asset('css/insert.css')}}">
@endsection


@section('contents')
    <main>
        <form action="{{route('boards.store')}}" method="post" >
            @csrf
            <label for="title">Title : </label>
            <input type="text" name="title" id="title" >
            <br>
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="10" class="contentsWrite"></textarea>
            <br>
            <button type="submit">작성</button>
            
        </form>
    </main>
@endsection