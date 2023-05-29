@extends('layout.layout')
    @section('contents')
        <div class="listBox">   
            <a href="{{route('boards.create')}}" class="writeBtn">글 쓰기</a>
            <table class="table">
            <thead>
                <tr>
                    <th>글번호</th>
                    <th>글제목</th>
                    <th>조회수</th>
                    <th>등록일</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>
                            <a href="{{route('boards.show',['board'=> $item->id])}}">{{$item->title}}</a>
                        </td>
                        <td>{{$item->hits}}</td>
                        <td>{{$item->created_at}}</td>
                    </tr>
            </tbody>
                @empty
                <tbody>
                    <tr>
                        <td>게시글 없음</td>
                    </tr>
                </tbody>
                @endforelse
            </table>
            {{-- <form action="" method="get">
                <input type="search">
                <button type="submit">검색</button>
            </form> --}}
        </div>
    @endsection
</body>
</html>