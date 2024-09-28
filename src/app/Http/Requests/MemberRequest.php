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
        // 検索用のバリデーション
        return [
            'employee_id' => 'nullable|numeric|min:1', // 数値を許容、空でもOK
            'name' => ['nullable', 'string', 'regex:/^[a-zA-Zぁ-んァ-ヶー一-龠]+$/u'],
        ];
    }

    public function messages()
    {
        return [
            'employee_id.numeric' => '社員IDは数字である必要があります。',
            'employee_id.min' => '社員IDは1以上の数値を入力してください。',
            'name.string' => '名前は文字列で入力してください。',
            'name.max' => '名前は255文字以内で入力してください。',
            'name.regex' => '名前には数字や記号を含めないでください。', 
        ];
    }
}



