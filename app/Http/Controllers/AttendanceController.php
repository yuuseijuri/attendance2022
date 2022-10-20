<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceRequest;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;

class AttendanceController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('index', ['user' => $user]);
    }
}
