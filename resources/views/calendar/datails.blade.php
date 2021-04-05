@extends('layouts.layout')
@section('content')



<div class="container">

  {{-- 更新時のflash --}}
  @if (session('err_msg'))
  <p class="alert alert-info">
    {{ session('err_msg') }}
  </p>
  @endif


  <form action="{{ route('postUpdate') }}" method="post" onSubmit="return checkSubmit()">
    @csrf
    <input type="hidden" name="id" value="{{ $calendars_id->id }}">

    <table class="table">
      <thead>
        <tr>
          <th scope="col">日付</th>
          <th scope="col">説明</th>
          <th scope="col">作成日</th>
          <th scope="col">更新日</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row"><input type="text" name="day" value="{{$calendars_id->day}}" class="form-control"></th>
          <td><input type="text" name="description" value="{{$calendars_id->description}}" class="form-control"></td>
          <td>{{$calendars_id->created_at}}</td>
          <td>{{$calendars_id->updated_at}}</td>
        </tr>
      </tbody>
    </table>

    <input type="submit" value="更新する" class="btn btn-success" onSubmit="return checkSubmit()">
    {{-- 戻るボタン --}}
    <a href="#" onClick="history.back(); return false;" class="btn btn-primary">前のページにもどる</a>
    

  </form>
  {{-- 削除ボタン --}}
  <form action="{{ route('getRecording') }}" method="post" onSubmit="return checkDelete()">
    <input type="hidden" name="id" value="{{$calendars_id->id}}">
    {{ method_field('delete') }}
    {{csrf_field()}} 
    <button class="btn btn-danger" type="submit">削除</button>
  </form>

</div>

<script>
  $( function() {
    $( "#day" ).datepicker({dateFormat: 'yy-mm-dd'});
  } );

  // 更新のウィンドウダイアログ
  function checkSubmit(){
    if(window.confirm('更新してよろしいですか？')){
      return true;
    } else {
      return false;
    }
  }

  // 削除のウィンドウダイアログ
  function checkDelete(){
    if(window.confirm('削除してよろしいですか？')){
      return true;
    } else {
      return false;
    }
  }
</script>



@endsection