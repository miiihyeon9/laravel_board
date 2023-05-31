@extends('layout.layout')

@section('title','FindPassword')

@section('contents')
    <h2>FindPassword</h2>
    {{-- session()->has('success') => session에 success가 있을 경우에 true --}}
    <div>{!! session()->has('success') ? session('success') : "" !!}</div>
    <div>임시 비밀번호는 {{session('randompassword')}} 입니다. 로그인 해주세요</div>
    <a href="{{route('users.login')}}">로그인하러 가기</a>
@endsection