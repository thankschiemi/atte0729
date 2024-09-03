<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Date;
use App\Models\Breakk;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        // データを取得
        $employees = Date::with('member')->paginate(5); // ページごとに5件表示

        // ビューにデータを渡す
        return view('attendance', ['employees' => $employees]);
    }

    public function startWork()
    {
        // 勤務開始の処理
        $member = Auth::user();
        $date = new Date([
            'member_id' => $member->id,
            'date' => Carbon::now()->toDateString(),
            'start_work' => Carbon::now(),
        ]);
        $date->save();

        return redirect()->back()->with('status', '勤務開始しました！');
    }

    public function startBreak()
    {
        // 休憩開始の処理
        $member = Auth::user();
        $date = $member->dates()->whereNull('end_work')->first();
        if ($date) {
            $breakk = new Breakk([
                'date_id' => $date->id,
                'start_break' => Carbon::now(),
            ]);
            $breakk->save();
        }

        return redirect()->back()->with('status', '休憩開始しました！');
    }

    public function endBreak()
    {
        // 休憩終了の処理
        $member = Auth::user();
        $date = $member->dates()->whereNull('end_work')->first();
        if ($date) {
            $breakk = $date->breaks()->whereNull('end_break')->first();
            if ($breakk) {
                $breakk->end_break = Carbon::now();
                $breakk->save();
            }
        }

        return redirect()->back()->with('status', '休憩終了しました！');
    }

    public function endWork()
    {
        // 勤務終了の処理
        $member = Auth::user();
        $date = $member->dates()->whereNull('end_work')->first();
        if ($date) {
            $date->end_work = Carbon::now();
            $date->save();
        }

        return redirect()->back()->with('status', '勤務終了しました！');
    }
}

