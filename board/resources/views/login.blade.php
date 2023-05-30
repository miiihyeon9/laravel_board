@extends('layout.layout')

@section('title','Login')

@section('contents')
    <h2>Login</h2>
        @if(isset($success))
        <div>{{$success}}</div>
        @else
        <div>{{""}}</div>
        @endif
    @include('layout.errors_validate')
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