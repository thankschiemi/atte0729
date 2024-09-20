<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Date;
use App\Models\Member; 
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

    public function showByDate($date = null)
    {
    // 日付が指定されていない場合は、現在の日付を使用
    $currentDate = $date ? Carbon::parse($date) : Carbon::today();

    // 前日と次日を計算
    $prevDate = $currentDate->copy()->subDay()->toDateString();
    $nextDate = $currentDate->copy()->addDay()->toDateString();

    // 指定された日付の従業員データと休憩時間を取得
    $employees = Date::with(['member', 'breaks'])
        ->whereDate('date', $currentDate->toDateString())
        ->paginate(5); // ページネーション付き

    // ビューにデータを渡す
    return view('attendance', [
        'employees' => $employees,
        'currentDate' => $currentDate->toDateString(),
        'prevDate' => $prevDate,
        'nextDate' => $nextDate
    ]);
    }

    //勤怠表
    public function showTimesheet($userId)
    {
        // 現在の日付を取得
        $currentDate = Carbon::today();
        $prevDate = $currentDate->copy()->subDay()->toDateString();
        $nextDate = $currentDate->copy()->addDay()->toDateString();
    
        // ユーザー情報を取得
        $user = Member::findOrFail($userId);
    
        // 勤怠情報を取得
        $timesheets = Date::where('member_id', $userId)->paginate(5);
    
        // ビューにデータを渡す
        return view('atte-attendance-page', compact('user', 'timesheets', 'currentDate', 'prevDate', 'nextDate'));
    }
}

