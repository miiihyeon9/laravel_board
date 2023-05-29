<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @yield('key','부모 타이틀') --}}
    {{-- 자식 템플릿에 해당하는 section에게 자리를 양도, 만약에 자식 템플릿에 해당 section이 없으면 2번째 인수 사용 --}}
    <title>@yield('title','Board')</title>
    {{-- 왜 적용이 안되는거니...왜그러니... 알고보니 public파일에 넣었어야 했음--}}
    <link href="{{asset('css/common.css')}}" rel="stylesheet" >
    {{-- <link href="{{mix.postCss('resources/css/common.css', 'public/css');}}" rel="stylesheet" > --}}
    @section('layout')
    <link rel="stylesheet" href="{{asset('css/list.css')}}">
    @show

    

</head>
<body>
    {{-- 다른 템플릿을 포함하는 방법 --}}
    {{-- view가 있는 위치에서 어디에 있는지 작성하면 됨 --}}
    @include('layout.inc.header')
    @section('lowTitle')
    <h2>List</h2>
    @show
    @yield('contents')

    {{-- 자식 템플릿에 해당 section이 정의 되어 있지 않으면 부모의 것이 실행 --}}
    {{-- @section으로 시작하고 @show로 끝남 --}}
    {{-- @section('test')
        <h2>부모의 섹션입니다.</h2>
        <p>아아아아아아</p>
        <p>끝</p>
        @show --}}
    {{-- 2번째 인수로 값을 셋팅하고, 해당 파일에서 변수로써 사용 가능 --}}
    {{-- @include('layout.inc.footer',['key1'=>'key1로셋팅'])
    @yield('if') --}}

</body>
</html>