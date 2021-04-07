@extends('layouts.layout')
@section('title', 'カレンダー入力')
@section('content')
    <h1>カレンダー入力</h1>

    {{-- バリデーションエラーメッセージ --}}
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- 休日入力フォーム -->
    <form method="POST" action="{{ route('getRecording') }}"> 
      <div class="form-group">
        {{csrf_field()}}
        <label for="day">日付[YYYY/MM/DD] </label>
        <input type="text" name="day" class="form-control" id="day" value="{{$data->day}}">
        <label for="title">タイトル</label>
        <input type="text" name="title" class="form-control" id="title" value="{{$data->title}}">
        <label for="description">説明</label>
        <input type="text" name="description" class="form-control" id="description" value="{{$data->description}}"> 
      </div>
      <button type="submit" class="btn btn-primary">登録</button>
      <input type="hidden" name="id" value="{{$data->id}}">
    </form> 

    <!-- 休日一覧表示 -->
    <table class="table">
      <thead>
        <tr>
          <th scope="col">日付</th>
          <th scope="col">タイトル</th>
          <th scope="col">説明</th>
          <th scope="col">作成日</th>
          <th scope="col">更新日</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
      @foreach($list as $val)
        <tr>
          <th scope="row"><a href="/tabeo-journalize/public/recording/{{$val->id}}">{{$val->day}}</a></th>
          <td>{{$val->title}}</td>
          <td>{{$val->description}}</td>
          <td>{{$val->created_at}}</td>
          <td>{{$val->updated_at}}</td>
          {{-- 削除ボタン --}}
          <td>
            <form action="{{ route('getRecording') }}" method="post">
              <input type="hidden" name="id" value="{{$val->id}}">
              {{ method_field('delete') }}
              {{csrf_field()}} 
              <button class="btn btn-default" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
    <a href="{{ url('/') }}">カレンダーに戻る</a>

    <script>
      $( function() {
        $( "#day" ).datepicker({dateFormat: 'yy-mm-dd'});
      } );
    </script>
@endsection