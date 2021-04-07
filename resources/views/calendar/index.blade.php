@extends('layouts.layout')
@section('title', 'カレンダー')
@push('css')
  <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
@endpush
@section('content')

  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="item1-tab" data-toggle="tab" href="#month" role="tab" aria-controls="item1" aria-selected="true">月</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="item2-tab" data-toggle="tab" href="#item2" role="tab" aria-controls="item2" aria-selected="false">Item#2</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="item3-tab" data-toggle="tab" href="#item3" role="tab" aria-controls="item3" aria-selected="false">Item#3</a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane show fade active in" id="month" role="tabpanel" aria-labelledby="item1-tab">{!!$cal_tag!!}</div>
    <div class="tab-pane fade" id="item2" role="tabpanel" aria-labelledby="item2-tab">This is a text of item#2.</div>
    <div class="tab-pane fade" id="item3" role="tabpanel" aria-labelledby="item3-tab">This is a text of item#3.</div>
  </div>

  
  {{-- {!!$cal_tag!!} --}}
  <a href="{{ route('getRecording') }}">カレンダー入力</a>
@endsection