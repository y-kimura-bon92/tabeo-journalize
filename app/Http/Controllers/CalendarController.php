<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar_Recording;
use App\Models\Calendar;

class CalendarController extends Controller
{
    // カレンダーデータの作成画面
    public function getRecording(Request $request) {
        $data = new Calendar_Recording();
        // カレンダーの内容データ取得
        $list = Calendar_Recording::all();
        return view('calendar.recording', ['list' => $list, 'data' => $data]);
    }

    // カレンダーデータの作成画面 一覧表示
    public function getRecordingId($id) {
        // カレンダーの内容データ取得
        $data = new Calendar_Recording();
        if(isset($id)) {
            $data = Calendar_Recording::where('id', '=', $id)->first();
        }
        $list = Calendar_Recording::all();
        return view('calendar.recording', ['list' => $list, 'data' => $data]);
    }



    // カレンダーデータの新規登録画面のPOST処理
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
            $recording->title       = $request->title;
            $recording->description = $request->description;

            $recording->save();
        } else {
            $recording = new Calendar_Recording();
            $recording->day         = $request->day;
            $recording->title       = $request->title;
            $recording->description = $request->description;
            $recording->food_file_name = 'cnt=0';
            $recording->food_file_path = 'cnt=0';
            
            $recording->save();
        }
        
        $data = new Calendar_Recording();
        $list = Calendar_Recording::all();

        return view('calendar.recording', ['list' => $list, 'data' => $data]);
    }



    // カレンダー画面
    public function index(Request $request) {
        $list = Calendar_Recording::all();
        $calendar = new Calendar($list);
        $tag = $calendar->showCalendarTag($request->month,$request->year);

        return view('calendar.index', ['cal_tag' => $tag]);
    }



    // カレンダーデータ編集画面
    public function getDatails($id) {
        $calendars_id = Calendar_Recording::find($id);
        // dd($calendars_id);

        return view('calendar.datails', ['calendars_id' => $calendars_id]);
    }



    public function postUpdate(Request $request) {
        $inputs = $request->all();
        $update_calendar = Calendar_Recording::find($inputs['id']);

        // 選択された画像を取得
        $update_image    = $request->file('food_image');
        $path    = $update_image->store('temp',"public");

        //アップロードされた画像をtempディレクトリに保存する
        if($update_calendar) {
            $update_calendar->fill([
                'day'            => $inputs['day'],
                'food_file_name' => $inputs['food_image']->getClientOriginalName(),
                'food_file_path' => $path,
                'title'          => $inputs['title'],
                'description'    => $inputs['description'],
            ]);

            $update_calendar->save();
            \Session::flash('err_msg', 'データを更新しました');
        }
        
        return redirect(route('getDatails', ['id' => $inputs['id'],]));
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
