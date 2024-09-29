<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkDate; // モデルは WorkDate
use App\Models\Member; 
use App\Models\Breakk;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        // データを取得
        $employees = WorkDate::with('member')->paginate(5); // WorkDate を使用

        // ビューにデータを渡す
        return view('attendance', ['employees' => $employees]);
    }

    public function startWork()
    {
        // 勤務開始の処理
        $member = Auth::user();
        $date = new WorkDate([ // WorkDate を使用
            'member_id' => $member->id,
            'date' => Carbon::now()->toDateString(),
            'start_work' => Carbon::now(),
        ]);
        $date->save();

        return redirect()->back()->with('status', '勤務開始しました！');
    }

    public function startBreak()
    {
        $member = Auth::guard('web')->user();
        $date = $member->dates()->whereDate('date', Carbon::today()->toDateString())->first();

        if ($date && is_null($date->end_work)) {
            $date->breaks()->create([
                'start_break' => Carbon::now(),
            ]);
            return redirect()->back()->with('status', '休憩を開始しました！');
        }

        return redirect()->back()->with('error', '勤務が終了しているか、開始されていません。');
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

    public function showByDate($date = null)
    {
        // 日付が指定されていない場合は、現在の日付を使用
        $currentDate = $date ? Carbon::parse($date) : Carbon::today();

        // 前日と次日を計算
        $prevDate = $currentDate->copy()->subDay()->toDateString();
        $nextDate = $currentDate->copy()->addDay()->toDateString();

        // 指定された日付の従業員データと休憩時間を取得
        $employees = WorkDate::with(['member', 'breaks']) // WorkDate を使用
            ->whereDate('date', $currentDate->toDateString())
            ->paginate(5); // ページネーション付き

        // 勤務時間と休憩時間を計算
        foreach ($employees as $employee) {
            $employee->work_duration = $employee->end_work
                ? $employee->end_work->diffForHumans($employee->start_work)
                : null;

            $employee->total_break_time = $employee->breaks->reduce(function ($carry, $break) {
                return $carry + ($break->end_break ? $break->end_break->diffInMinutes($break->start_break) : 0);
            }, 0);
        }

        // ビューにデータを渡す
        return view('attendance', [
            'employees' => $employees,
            'currentDate' => $currentDate->toDateString(),
            'prevDate' => $prevDate,
            'nextDate' => $nextDate
        ]);
    }
}
