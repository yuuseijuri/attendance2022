<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\RestRequest;
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

        $times = Carbon::now()->format('y-m-d');
        

        return view('date', ['pages' => $pages, 'users' => $users, 'times' => $times]);
    }

    public function jobIn(AttendanceRequest $request) {

        $users = Auth::user();
        
        $times = Attendance::where('user_id', $users->id)->latest()->first();
        
        if($times) {
            $timesJobIn = new Carbon($times->start_time);
            $timesDay = $timesJobIn->startOfDay();
        }
        $newTimesDay = Carbon::today();

        if(($timesDay == $newTimesDay) && (empty($times->end_time))) {
            return redirect()->back()->with('既に出勤打刻がされています。');
        }

        $timestamp = Attendance::create([
            'user_id' => $user->id,
            'start_time' => Carbon::now()
        ]);
        dd($timestamp);
        return redirect()->back()->with('出勤打刻が完了しました。');
    }

    public function jobOut(AttendanceRequest $request) {

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
    
    public function restIn(RestRequest $request) {

        $users = Auth::user();

        $form = $request->only([
            'attendance_id',
            'start_time'
        ]);
        Rest::create($form);
        dd($form);
        return redirect();
    }

    public function restOut(RestRequest $request) {

        $users = Auth::user();

        $form = $request->only([
            'attendance_id',
            'end_time'
        ]);
        Rest::create($form);
        
        return redirect();
    }
    
}