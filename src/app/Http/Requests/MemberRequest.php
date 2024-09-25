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
        return [
            'employee_id' => 'nullable|numeric|min:1',  // 数値を許容
            'name' => ['required', 'string', 'regex:/^[a-zA-Zぁ-んァ-ヶー一-龠]+$/u'], // 名前に数字や記号を含めない
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'], // メールアドレスは必須、一意
            'password' => ['required', 'string', 'min:8'], // パスワードは必須で8文字以上
        ];
    }

    public function messages()
    {
        return [
            'employee_id.numeric' => '社員IDは数字である必要があります。',
            'employee_id.min' => '社員IDは1以上の数値を入力してください。',
            'name.string' => '名前は文字列で入力してください。',
            'name.regex' => '名前には数字や記号を含めないでください。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'そのメールアドレスはすでに登録されています。',
            'password.required' => 'パスワードは必須です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
        ];
    }
}


