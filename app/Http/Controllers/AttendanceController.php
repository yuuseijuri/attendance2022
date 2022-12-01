<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index() {
        $users = Auth::user();
        return view('index', ['users' => $users]);
    }

    public function show(Request $request, $date) {

        $users = Auth::user();

        // $days_ye = Carbon::yesterday()->format('y-m-d');

        // $days = Carbon::now()->format('y-m-d');

        //パラメータから取得
        $days = $date;

        if($date == 'today') {
        $days = Carbon::now()->format('Y-m-d');
        }
        $time = strtotime($date);
        
        $days_ye = date('Y-m-d', strtotime('-1 day', $time));
        $days_to = date('Y-m-d', strtotime('+1 day', $time));

        // $days_to = Carbon::tomorrow()->format('y-m-d');

        $pages = Attendance::Paginate(10);

        // $attendance_time = Attendance::where('user_id', $users->id)->latest()->first();
        $attendance_time = Attendance::where('created_at', '>=', $days . ' 00:00:00')->where('created_at', '<', $days_to . ' 00:00:00')->get();

        // $attendance_time_all = Attendance::select(Attendance::raw('timediff(end_time, start_time) as attendancetime'))->where('id', $attendance_time->id)->value('attendancetime');

        $attends = array();

        foreach($attendance_time as $element) {
            $name = User::find($element->user_id)->name;

            $value = Attendance::select(Attendance::raw('timediff(end_time, start_time) as attendancetime'))->where('id', $element->id)->value('attendancetime');

            $rests = Rest::where('attendance_id', $element->id)->get();

            $rest_sum = Rest::select(Rest::raw('sum(timediff(end_time, start_time)) as rest_sum'))->where('attendance_id', $element->id)->value('rest_sum');
            // 秒数
            $seconds = $rest_sum % 60;
            // 分数
            $minutes = (($rest_sum - $seconds) / 60) % 60;
            // 時間数
            $hours = ($rest_sum - $seconds - 60 * $minutes) / 60;
            $rest_sum_str = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            // $rest_sum = 0;

            // foreach($rests as $rest_element) {
            //     $rest_value = Rest::select(Rest::raw('timediff(end_time, start_time) as resttime'))->where('id', $rest_element->id)->value('$rest_time');
            //     $rest_sum += $rest_value;
            // }

            $merged = array('attendance' => $element, 'all_time' => $value, 'rest_sum' => $rest_sum, 'rest_sum_str' => $rest_sum_str, 'name' => $name);
            array_push($attends, $merged);

        }



        // $rest_time = Rest::where('attendance_id', $users->id)->latest()->first();

        // $rest_time_all = Rest::select(Rest::raw('timediff(end_time, start_time) as resttime'))->where('id', $rest_time->id)->value('resttime');

        
        return view('date', ['users' => $users, 'days' => $days, 'days_ye' => $days_ye, 'days_to' => $days_to, 'pages' => $pages, 'attendance_time' => $attendance_time, 'attends' => $attends]);
    }

    public function jobIn(Request $request) {

        $users = Auth::user();
        
        $times = Attendance::where('user_id', $users->id)->latest()->first();

        $timesDay = null;

        if($times) {
            $timesJobIn = new Carbon($times->start_time);
            $timesDay = $timesJobIn->startOfDay();
        }

        $newTimesDay = Carbon::today();

        if(($timesDay == $newTimesDay) && (empty($times->end_time))) {
            return redirect()->back()->withErrors('※既に出勤打刻がされています。');
        }

        $timestamp = Attendance::create([
            'user_id' => $users->id,
            'start_time' => Carbon::now()
        ]);

        return redirect()->back()->withErrors('◎出勤打刻が完了しました。');
    }

    public function jobOut(Request $request) {

        $users = Auth::user();

        $times = Attendance::where('user_id', $users->id)->latest()->first();

        if(!empty($times->end_time)) {
            return redirect()->back()->withErrors('※既に退勤の打刻がされているか、出勤打刻されていません');
        }

        $times->update([
            'end_time' => Carbon::now()
        ]);
        
        return redirect()->back()->withErrors('◎退勤打刻が完了しました。');
    }
    
    public function restIn(Request $request) {

        $users = Auth::user();

        $attendance = Attendance::where('user_id', $users->id)->latest()->first();

        $times = Rest::where('attendance_id', $attendance->id)->latest()->first();


        $timesTime = null;

        // if($times) {
        //     $timesRestIn = new Carbon($times->start_time);
        // }
        $newTimesTime = Carbon::today();

        if(($times !== null) && (empty($times->end_time))) {
            return redirect()->back()->withErrors('※既に休憩開始打刻がされています。');
        }

        $timestamp = Rest::create([
            'attendance_id' => $attendance->id,
            'start_time' => Carbon::now()
        ]);
        return redirect()->back()->withErrors('◎休憩開始打刻が完了しました。');

    }

    public function restOut(Request $request) {

        $users = Auth::user();

        $attendance = Attendance::where('user_id', $users->id)->latest()->first();

        $times = Rest::where('attendance_id', $attendance->id)->latest()->first();
        // $times = Rest::where('attendance_id', $users->id)->latest()->first();

        if(!empty($times->end_time)) {
            return redirect()->back()->withErrors('※既に休憩終了の打刻がされているか、休憩開始打刻されていません');
        }

        $times->update([
            'end_time' => Carbon::now()
        ]);
        
        return redirect()->back()->withErrors('◎退勤打刻が完了しました。');

    }
}