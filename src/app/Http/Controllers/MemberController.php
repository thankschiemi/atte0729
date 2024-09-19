<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\MemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();
    
        // 名前検索 (部分一致)
        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where('name', 'like', "%{$name}%");
        }
    
        // 社員IDが100以上の検索
        if ($request->has('employee_id')) {
            $employee_id = $request->input('employee_id');
            $query->where('employee_id', '>=', 100);
            
            // 特定の社員IDでの検索
            if (!empty($employee_id)) {
                $query->where('employee_id', $employee_id);
            }
        }
    
        // ページネーション
        $members = $query->paginate(5);
    
        return view('members.atte-member-page', compact('members'));
    }
    
}

