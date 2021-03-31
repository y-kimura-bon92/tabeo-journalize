<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Carbon\Carbon;

class ApiTestController extends Controller
{
    public function google_calendar() {
        $events = Event::get(); // 未来の全イベントを取得する

        dd($events->name);

        $dt = new Carbon('2020-01-01');
        
        $event = new Event;
        $event->name = '新しいイベント名';
        $event->startDateTime = $dt;
        $event->endDateTime = $dt->addHour();   // 1時間後
        $event->description = "テスト説明文\nテスト説明文\nテスト説明文";
        $new_event = $event->save();

        dd($new_event->id); // 新しく作成したイベントのID


    }

    //
    public function test() {
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);

        /////////////
        // getSummary();

        $calendarId = env('GOOGLE_CALENDAR_ID');

        $event = new Google_Service_Calendar_Event(array(
            //タイトル
            'summary' => 'テスト',
            'start' => array(
                // 開始日時
                'dateTime' => '2020-08-23T11:00:00+09:00',
                'timeZone' => 'Asia/Tokyo',
            ),
            'end' => array(
                // 終了日時
                'dateTime' => '2020-08-23T12:00:00+09:00',
                'timeZone' => 'Asia/Tokyo',
            ),
        ));
        

        $event = $service->events->insert($calendarId, $event);
        // $event = $service->events->get($event, $calendarId);
        dd($event);
        echo "イベントを追加しました";
    }

    private function getClient() {
        $client = new Google_Client();

        //アプリケーション名
        $client->setApplicationName('GoogleCalendarAPIのテスト');
        //権限の指定
        $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
        //JSONファイルの指定
        $client->setAuthConfig(storage_path('app/api-key/tabeo-journalize-285589c12b93.json'));

        return $client;
    }




    public function calender() {
        return view('post.calender');
    }

    public function sample() {
        return view('sample.view');
    }

}
