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

    public function show(Request $request) {

        $users = Auth::user();

        $pages = Attendance::Paginate(10);

        $days = Carbon::now()->format('y-m-d');

        $starts = Attendance::create([
            'user_id' => $users->id,
            'start_time' => Carbon::now()
        ]);

        $times = Attendance::where('user_id', $users->id)->latest()->first();
        $ends = $times->update([
            'end_time' => Carbon::now()
        ]);
        
        return view('date', ['pages' => $pages, 'users' => $users, 'days' => $days, 'starts' => $starts, 'ends' => $ends]);
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
            return redirect()->back()->with('既に出勤打刻がされています。');
        }

        $timestamp = Attendance::create([
            'user_id' => $users->id,
            'start_time' => Carbon::now()
        ]);

        return redirect()->back()->with('出勤打刻が完了しました。');
    }

    public function jobOut(Request $request) {

        $users = Auth::user();

        $times = Attendance::where('user_id', $users->id)->latest()->first();

        if(!empty($times->end_time)) {
            return redirect()->back()->with('既に退勤の打刻がされているか、出勤打刻されていません');
        }

        $times->update([
            'end_time' => Carbon::now()
        ]);
        
        return redirect()->back()->with('退勤打刻が完了しました。');
    }
    
    public function restIn(Request $request) {

        $users = Auth::user();

        $times = Rest::where('attendance_id', $users->id)->latest()->first();

        $timesTime = null;

        if($times) {
            $timesRestIn = new Carbon($times->start_time);
        }
        $newTimesTime = Carbon::today();

        if(($timesTime == $newTimesTime) && (empty($times->end_time))) {
            return redirect()->back()->with('既に休憩開始打刻がされています。');
        }

        $timestamp = Rest::create([
            'attendance_id' => $users->id,
            'start_time' => Carbon::now()
        ]);
        return redirect()->back()->with('休憩開始打刻が完了しました。');

    }

    public function restOut(Request $request) {

        $users = Auth::user();

        $times = Rest::where('attendance_id', $users->id)->latest()->first();

        if(!empty($times->end_time)) {
            return redirect()->back()->with('既に休憩終了の打刻がされているか、休憩開始打刻されていません');
        }

        $times->update([
            'end_time' => Carbon::now()
        ]);
        
        return redirect()->back()->with('退勤打刻が完了しました。');

    }
    
}