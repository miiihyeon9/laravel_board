<h1><a class= "title" href="{{route('boards.index')}}">MINI BOARD</a></h1>

{{-- 로그인 중 --}}
@auth
    <div><a href="{{route('users.logout')}}">로그아웃</a></div>
    <div><a href="{{route('users.check')}}">회원정보 수정</a></div>
@endauth

{{-- 비로그인 상태 (인증이 되지 않은 상태)--}}
@guest
    <div><a href="{{route('users.login')}}">로그인</a></div>
@endguest
