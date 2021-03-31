@extends('layouts.layout')
@section('title', 'カレンダー')
@section('content')
  {!!$cal_tag!!}
  <a href="{{ route('getRecording') }}">カレンダー入力</a>
@endsection