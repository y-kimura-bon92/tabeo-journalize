@extends('layouts.layout')
@section('title', 'カレンダー編集')
@section('content')


<div class="container">

  {{-- 更新時のflash --}}
  @if (session('err_msg'))
  <p class="alert alert-info">
    {{ session('err_msg') }}
  </p>
  @endif


  <form action="{{ route('postUpdate') }}" method="post" enctype="multipart/form-data" onSubmit="return checkSubmit()">
    @csrf
    <input type="hidden" name="id" value="{{ $calendars_id->id }}">

    <table class="table">
      <tbody>
        <tr>
          <th scope="col">日付</th>
          <th scope="row" colspan="3"><input type="text" name="day" value="{{$calendars_id->day}}" class="form-control"></th>
        </tr>
        <tr>
          <th scope="col">画像</th>
          <td scope="row">
            <img src="{{ asset("storage/{$calendars_id->food_file_path}") }}" class="w-25"/>
            <input type="file" name="food_image" accept="image/png, image/jpeg ,image/jpg" class="form-control" value="{{ $calendars_id->food_file_name }}">
          </td>
          
        </tr>
        <tr>
          <th scope="col">タイトル</th>
          <td scope="row"><input type="text" name="title" value="{{ $calendars_id->title }}" class="form-control"></td>
        </tr>
        <tr>
          <th scope="col">説明</th>
          <td scope="row">
            <textarea name="description" cols="30" rows="10" class="form-control">{{ $calendars_id->description }}</textarea>
          </td>
        </tr>
        <tr>
          <th scope="col">作成日</th>
          <td scope="row">{{$calendars_id->created_at}}</td>
        </tr>
        <tr>
          <th scope="col">更新日</th>
          <td scope="row">{{$calendars_id->updated_at}}</td>
        </tr>
      </tbody>
    </table>

    <input type="submit" value="更新する" class="btn btn-success" onSubmit="return checkSubmit()">
    {{-- 戻るボタン --}}
    <a href="#" onClick="history.back(); return false;" class="btn btn-primary">前のページにもどる</a>
    <a href="{{ url('/') }}" class="btn btn-primary">カレンダーページにもどる</a>
    

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