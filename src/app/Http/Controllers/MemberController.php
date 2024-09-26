<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest; // MemberRequest をインポート
use App\Models\Member;

class MemberController extends Controller
{
    public function index(\Illuminate\Http\Request $request) 
{
    $query = Member::query();

    // 名前検索 (部分一致)
    if ($request->has('name')) {
        $name = $request->input('name');
        $query->where('name', 'like', "%{$name}%");
    }

    // 社員IDの数値部分で100以上の検索
    if ($request->has('employee_id')) {
        $employee_id = $request->input('employee_id', 100); // 100をデフォルト値に設定
    
        // 社員IDが「EMP-XXX」の形式の場合、数値部分だけで比較する
        if (!empty($employee_id)) {
            $query->whereRaw('CAST(SUBSTRING(employee_id, 5) AS UNSIGNED) >= ?', [(int)$employee_id]);
        }
    }

    // ページネーション
    $members = $query->paginate(5);

    // リクエストがJSONを期待している場合、JSONを返す
    if ($request->wantsJson()) {
        return response()->json($members);
    }

    // それ以外の場合はHTMLビューを返す
    return view('members.atte-member-page', compact('members'));
}


public function store(MemberRequest $request)
{
    $validatedData = $request->validated();
    $validatedData['password'] = bcrypt($request->password);

    // メンバーを作成し、結果を返す
    $member = Member::create($validatedData);

    // 作成されたメンバー情報をデバッグ出力
     // dd($member->toArray());

    return response()->json(['message' => 'Member created successfully'], 201);
}

}

    


