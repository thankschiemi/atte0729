<?php

namespace App\Http\Controllers;

use App\Models\Member; // Memberモデルを使用
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * メンバーの一覧表示
     */
    public function index()
    {
        // ページネーションでメンバーを5件ずつ取得
        $members = Member::paginate(5);

        // 'atte-member-page' というBladeテンプレートにデータを渡して表示
        return view('atte-member-page', compact('members'));
    }

    /**
     * 特定のメンバー詳細表示
     */
    public function show($id)
    {
        // IDをもとにメンバーを取得
        $member = Member::findOrFail($id);

        // メンバー詳細表示用のビューにデータを渡す
        return view('member-show', compact('member'));
    }

    /**
     * メンバー編集フォームの表示
     */
    public function edit($id)
    {
        // IDをもとにメンバーを取得
        $member = Member::findOrFail($id);

        // メンバー編集用フォームにデータを渡す
        return view('member-edit', compact('member'));
    }

    /**
     * メンバーの情報を更新する
     */
    public function update(Request $request, $id)
    {
        // バリデーションを行う
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email,' . $id,
        ]);

        // メンバーを取得し、更新する
        $member = Member::findOrFail($id);
        $member->update($request->all());

        // 成功メッセージとともに一覧ページにリダイレクト
        return redirect()->route('members.index')->with('success', 'メンバー情報が更新されました。');
    }

    /**
     * メンバーを削除する
     */
    public function destroy($id)
    {
        // メンバーをIDで取得して削除する
        $member = Member::findOrFail($id);
        $member->delete();

        // 成功メッセージとともに一覧ページにリダイレクト
        return redirect()->route('members.index')->with('success', 'メンバーが削除されました。');
    }
}

