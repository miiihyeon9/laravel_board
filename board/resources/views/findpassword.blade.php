@extends('layout.layout')

@section('title','FindPassword')

@section('contents')
    <h2>FindPassword</h2>
        
    @include('layout.errors_validate')
    {{-- session()->has('success') => session에 success가 있을 경우에 true --}}
    <div>{!! session()->has('success') ? session('success') : "" !!}</div>
    <form action="{{route('users.findpassword.post')}}" method="post">
        @csrf
        <label for="name">name : </label>
        <input type="name" name="name" id="name">
        <label for="email">email : </label>
        <input type="email" name="email" id="email">
        <button type="submit">Find</button>
        <button type="button" onclick="location.href = '{{route('users.login')}}'">취소</button>
    </form>
@endsection