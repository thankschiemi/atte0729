<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\MemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * メンバーの一覧表示
     */
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
        }

        $members = $query->paginate(5);

        return view('members.atte-member-page', compact('members'));

    }

    /**
     * 特定のメンバー詳細表示
     */
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('members.member-show', compact('member'));
    }

    /**
     * メンバー作成フォームの表示
     */
    public function create()
    {
        return view('member-create');
    }

    /**
     * 新しいメンバーを作成
     */
    public function store(MemberRequest $request)
    {
        Member::create($request->validated());
        return redirect()->route('members.index')->with('success', '新しいメンバーが作成されました。');
    }

    /**
     * メンバー編集フォームの表示
     */
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('members.member-edit', compact('member'));
    }

    /**
     * メンバーの情報を更新する
     */
    public function update(MemberRequest $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->validated());
        return redirect()->route('members.index')->with('success', 'メンバー情報が更新されました。');
    }

    /**
     * メンバーを削除する
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return redirect()->route('members.index')->with('success', 'メンバーが削除されました。');
    }
}


