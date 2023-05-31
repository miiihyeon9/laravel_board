@extends('layout.layout')

@section('title','Login')

@section('contents')
    <h2>Login</h2>
        
    @include('layout.errors_validate')
    {{-- session()->has('success') => session에 success가 있을 경우에 true --}}
    <div>{!! session()->has('success') ? session('success') : "" !!}</div>
    <a href="{{route('users.findpassword')}}">비밀번호 찾기</a>
    <form action="{{route('users.login.post')}}" method="post">
        @csrf
        <label for="email">EMAIL : </label>
        <input type="text" name="email" id="email">
        <label for="password">PASSWORD : </label>
        <input type="password" name="password" id="password">
        <button type="submit">LOG IN</button>
        <button type="button" onclick="location.href = '{{route('users.registration')}}'">SIGN UP</button>
    </form>
@endsection