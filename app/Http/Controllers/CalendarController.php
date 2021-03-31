<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar_Recording;
use App\Models\Calendar;

class CalendarController extends Controller
{
    //
    public function getRecording(Request $request) {
        $data = new Calendar_Recording();
        // カレンダーの内容データ取得
        $list = Calendar_Recording::all();
        return view('calendar.recording', ['list' => $list, 'data' => $data]);
    }

    public function getRecordingId($id) {
        // カレンダーの内容データ取得
        $data = new Calendar_Recording();
        if(isset($id)) {
            $data = Calendar_Recording::where('id', '=', $id)->first();
        }
        $list = Calendar_Recording::all();
        return view('calendar.recording', ['list' => $list, 'data' => $data]);
    }

    public function postRecording(Request $request) {
        // バリデーション
        $validatedData = $request->validate([
            'day' => 'required|date_format:Y-m-d',
            'description' => 'required',
        ]);

        // POSTで受け取ったカレンダーデータの登録
        if(isset($request->id)) {
            $recording = Calendar_Recording::where('id', '=', $request->id)->first();
            $recording->day         = $request->day;
            $recording->description = $request->description;
            $recording->save();
        } else {
            $recording = new Calendar_Recording();
            $recording->day         = $request->day;
            $recording->description = $request->description;
            
            $recording->save();
        }
        
        $data = new Calendar_Recording();
        $list = Calendar_Recording::all();

        return view('calendar.recording', ['list' => $list, 'data' => $data]);
    }



    public function index(Request $request) {
        $list = Calendar_Recording::all();
        $calendar = new Calendar($list);
        $tag = $calendar->showCalendarTag($request->month,$request->year);

        return view('calendar.index', ['cal_tag' => $tag]);
    }



    public function deleteRecording(Request $request) {
         // DELETEで受信した休日データの削除
        if (isset($request->id)) {
            $recording = Calendar_Recording::where('id', '=', $request->id)->first();        
            $recording->delete();
        }
        // 休日データ取得
        $data = new Calendar_Recording();
        $list = Calendar_Recording::all();
        return view('calendar.recording', ['list' => $list, 'data' => $data]);
    }
}
