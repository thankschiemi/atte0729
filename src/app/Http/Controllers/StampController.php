<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StampController extends Controller
{
    public function index()
    {
        $member = Auth::user(); // ログイン中のメンバーを取得

        // メンバーの最後の勤務記録を取得
        $lastDate = $member->dates()->latest()->first();

        // ボタンの状態を設定
        $buttonsEnabled = [
            'startWork' => is_null($lastDate) || !is_null($lastDate->end_work),
            'endWork' => !is_null($lastDate) && is_null($lastDate->end_work),
            'startBreak' => !is_null($lastDate) && is_null($lastDate->end_work) && is_null($lastDate->breaks()->whereNull('end_break')->first()),
            'endBreak' => !is_null($lastDate) && !is_null($lastDate->breaks()->whereNull('end_break')->first())
        ];

        // ビューにデータを渡して表示
        return view('stamp', compact('buttonsEnabled'));
    }
}
