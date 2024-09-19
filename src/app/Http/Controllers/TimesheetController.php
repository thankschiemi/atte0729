<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Date;  // 勤務日モデル

class TimesheetController extends Controller
{
    public function show($userId)
    {
        $timesheets = Date::where('member_id', $userId)->paginate(5);

        return view('atte-attendance-page', compact('timesheets'));
    }
}

