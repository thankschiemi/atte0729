<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Date;
use App\Models\Member; // Member モデルを追加
use Carbon\Carbon;

class StampController extends Controller
{
    // 勤務開始
    public function startWork()
    {
        $member = Auth::guard('web')->user(); // Memberモデルを取得
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

    // 打刻ページの表示
    public function index()
    {
        $member = Auth::guard('web')->user(); // Member モデルを取得
        $lastDate = $member->dates()->latest()->first(); // 最新の勤務データを取得
        $today = Carbon::today()->toDateString(); // 今日の日付

        // デフォルトですべてのボタンを無効化
        $buttonsEnabled = [
            'startWork' => false,
            'endWork' => false,
            'startBreak' => false,
            'endBreak' => false
        ];

        if (is_null($lastDate) || Carbon::parse($lastDate->date)->toDateString() != $today) {
            // 勤務開始前、または新しい日 -> 勤務開始のみ有効
            $buttonsEnabled['startWork'] = true;
        } elseif (is_null($lastDate->end_work)) {
            // 勤務中の場合
            $ongoingBreak = $lastDate->breaks()->whereNull('end_break')->first(); // 進行中の休憩

            if (!is_null($ongoingBreak)) {
                // 休憩中の場合 -> 休憩終了を有効
                $buttonsEnabled['endBreak'] = true;
            } else {
                // 休憩していない、または休憩終了後 -> 勤務終了と休憩開始を有効
                $buttonsEnabled['endWork'] = true;
                $buttonsEnabled['startBreak'] = true;
            }
        }

        // ビューにボタンの状態を渡して表示
        return view('stamp', compact('buttonsEnabled'));
    }
}





