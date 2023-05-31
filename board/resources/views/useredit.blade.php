@extends('layout.layout')


@section('title','UserEdit')
@section('contents')
<main>
    @if( count($errors) > 0 )
        {{-- erros->all() $errors객체에서 필요한 것만 가져와줌 --}}
        @foreach($errors->all() as  $error)
            <div>{{$error}}</div>
        @endforeach
    @endif
    @include('layout.errors_validate')
    <div>{!! session()->has('success') ? session('success') : "" !!}</div>
    <button type="button" onclick="location.href='{{route('boards.index')}}'">뒤로 가...</button>
    <form action="{{route('users.edit.put')}}" method="post" class="listBox formGrid writeGrid">
        @csrf
        @method('put')
        <label for="email">email : </label>
        <input type="text" name="email" id="email" value="{{$user->email}}" readonly>

        <label for="name">name : </label>
        <input type="text" name="name" id="name" value="{{$user->name}}" >

        {{-- <label for="beforePassword">Before Password</label>
        <input type="password" name="beforePassword" id="beforePassword" > --}}

        <label for="password">New Password</label>
        <input type="password" name="password" id="password" >

        <label for="passwordchk">passwordChk</label>
        <input type="password" name="passwordchk" id="passwordchk" >

        <button type="submit">수정</button>
        <button type="button" onclick="location.href='{{route('boards.index')}}'">취소</button>
    </form>
</main>
@endsection
