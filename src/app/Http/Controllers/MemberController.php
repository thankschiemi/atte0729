<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest; // MemberRequest をインポート
use App\Models\Member;

class MemberController extends Controller
{
    public function index(MemberRequest $request) // MemberRequest を受け取る
{
    $query = Member::query();

    // 名前検索 (部分一致)
    if ($request->has('name')) {
        $name = $request->input('name');
        $query->where('name', 'like', "%{$name}%");
    }

    // 社員IDの数値部分で5以上の検索
    if ($request->has('employee_id')) {
        $employee_id = $request->input('employee_id');

        // 社員IDが「EMP-XXX」の形式の場合、数値部分だけで比較する
        if (!empty($employee_id)) {
            $query->whereRaw('CAST(SUBSTRING(employee_id, 5) AS UNSIGNED) >= ?', [5]);
        }
    }

    // ページネーション
    $members = $query->paginate(5);

    return view('members.atte-member-page', compact('members'));
}

}

    


