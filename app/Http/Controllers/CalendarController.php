<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar_Recording;
use App\Models\Calendar;

class CalendarController extends Controller
{
    //
    public function getRecording(Request $request) {
        // カレンダーの内容データ取得
        $list = Calendar_Recording::all();
        return view('calendar.recording', ['list' => $list]);
    }

    public function postRecording(Request $request) {
        
        // Calendar_Recording::create([
        //     'day'      => $request->day,
        //     'description'   => $request->description,
        // ]);
        
        // POSTで受け取ったカレンダーデータの取得
        $recording = new Calendar_Recording();
        $recording->day         = $request->day;
        $recording->description = $request->description;
        
        $recording->save();

        $list = Calendar_Recording::all();
        return view('calendar.recording', ['list' => $list]);
    }

    public function index(Request $request) {
        $list = Calendar_Recording::all();
        $calendar = new Calendar($list);
        $tag = $calendar->showCalendarTag($request->month,$request->year);

        return view('calendar.index', ['cal_tag' => $tag]);
    }
}
