@if( count($errors) > 0 )
    {{-- erros->all() $errors객체에서 필요한 것만 가져와줌 --}}
    @foreach($errors->all() as  $error)
        <div>{{$error}}</div>
    @endforeach
@endif