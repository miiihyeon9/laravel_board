@extends('layout.layout')

@section('title','Check')

@section('contents')
    <h2>Check</h2>
        
    @include('layout.errors_validate')
    {{-- session()->has('success') => session에 success가 있을 경우에 true --}}
    <div>{!! session()->has('success') ? session('success') : "" !!}</div>
    <form action="{{route('users.check.post')}}" method="post">
        @csrf

        <label for="password">PASSWORD : </label>
        <input type="password" name="password" id="password">
        <button type="submit">Check</button>
        <button type="button" onclick="location.href = '{{route('boards.index')}}'">취소</button>
    </form>
@endsection