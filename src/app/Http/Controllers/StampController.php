<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StampController extends Controller
{
    public function startWork()
{
    $member = Auth::user();
    $today = Carbon::today()->toDateString();

    // 今日の勤務が既に存在するか確認
    $existingDate = $member->dates()->whereDate('date', $today)->first();

    if (is_null($existingDate)) {
        $date = new Date([
            'member_id' => $member->id,
            'date' => $today,
            'start_work' => Carbon::now(),
        ]);
        $date->save();
    }

    return redirect()->back()->with('status', '勤務開始しました！');
}
public function endWork()
{
    $member = Auth::user();
    $date = $member->dates()->whereNull('end_work')->first();

    if ($date) {
        $date->end_work = Carbon::now();
        $date->save();
    }

    return redirect()->back()->with('status', '勤務終了しました！');
}
    public function index()
{
    $member = Auth::user(); // ログイン中のメンバーを取得

    // メンバーの最後の勤務記録を取得
    $lastDate = $member->dates()->latest()->first();
    $today = Carbon::today()->toDateString();



    // デフォルトですべてのボタンを無効化
    $buttonsEnabled = [
        'startWork' => false,
        'endWork' => false,
        'startBreak' => false,
        'endBreak' => false
    ];

    if (is_null($lastDate) || Carbon::parse($lastDate->created_at)->toDateString() != $today) {
        // 勤務開始前、または新しい日
        $buttonsEnabled['startWork'] = true;
    } elseif (is_null($lastDate->end_work)) {
        // 勤務中
        $ongoingBreak = $lastDate->breaks()->whereNull('end_break')->first();

        if (!is_null($ongoingBreak)) {
            // 休憩中
            $buttonsEnabled['endBreak'] = true;
        } else {
            // 勤務中かつ休憩していない、または休憩終了後
            $buttonsEnabled['endWork'] = true;
            $buttonsEnabled['startBreak'] = true;
        }
    }


    // ビューにデータを渡して表示
    return view('stamp', compact('buttonsEnabled'));
}

}

