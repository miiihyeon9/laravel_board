@extends('layout.layout')

@section('title','Registration')

@section('contents')
    @include('layout.errors_validate')
    <form action="{{route('users.registration.post')}}" method="post">
        @csrf
        <label for="name">NAME : </label>
        <input type="text" name="name" id="name">
        <label for="email">EMAIL : </label>
        <input type="text" name="email" id="email">
        <label for="password">PASSWORD : </label>
        <input type="password" name="password" id="password">
        <label for="passwordchk">PW CHECK : </label>
        <input type="password" name="passwordchk" id="passwordchk">
        <button type="submit">SIGN UP</button>
        <button type="button" onclick="location.href = '{{route('users.login')}}'">CANCEL</button>
    </form>
@endsection