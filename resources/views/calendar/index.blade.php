@extends('layouts.layout')
@section('title', 'カレンダー')
@section('content')
    {!!$cal_tag!!}
    <a href="{{ route('getRecording') }}">休日設定</a>
@endsection