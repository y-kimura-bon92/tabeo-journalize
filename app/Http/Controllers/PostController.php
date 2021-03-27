<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar\CalendarView;

class PostController extends Controller
{
    //
    public function show() {
        // time()を使って現在時刻を渡し、今月のカレンダーを用意。
        $calendar = new CalendarView(time());

        return view('calendar.calendar', ['calendar' => $calendar]);
    }
}
