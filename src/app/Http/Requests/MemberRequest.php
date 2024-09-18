<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証は許可する
    }

    public function rules()
    {
        $memberId = $this->route('member'); // ルートからメンバーIDを取得

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email,' . $memberId,
            'employee_id' => 'required|unique:members,employee_id,' . $memberId,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前は必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'employee_id.required' => '社員IDは必須です。',
            'employee_id.unique' => 'この社員IDは既に使用されています。',
        ];
    }
}

