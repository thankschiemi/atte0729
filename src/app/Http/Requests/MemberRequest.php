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
        'employee_id' => 'nullable|numeric|min:1', // 数値で、0以上の値のみ
        'name' => ['nullable', 'string', 'regex:/^[a-zA-Zぁ-んァ-ヶー一-龠]+$/u'], // 記号や数字を含めない

    ];
}

public function messages()
{
    return [
        'employee_id.numeric' => '社員IDは数字である必要があります。',
        'employee_id.min' => '社員IDは1以上の数値を入力してください。',
        'name.string' => '名前は文字列で入力してください。',
        'name.regex' => '名前には数字を含めないでください。',
    ];
}

}

