<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Member extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id', // 追加: 社員IDフィールド
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // dates リレーションを定義
    public function dates()
    {
        return $this->hasMany(Date::class, 'member_id');
    }

     // 社員IDを数字で自動生成する処理
     protected static function boot()
{
    parent::boot();

    static::creating(function ($member) {
        // employee_idの数値部分を取り出して、最大値を計算する
        $lastEmployeeId = Member::whereNotNull('employee_id')
            ->orderByRaw('CAST(SUBSTRING(employee_id, 5) AS UNSIGNED) DESC')
            ->value('employee_id');
        
        // 最後のemployee_idの数値部分を取り出す
        $lastNumber = $lastEmployeeId ? (int) substr($lastEmployeeId, 4) : 0;
        
        // 次のemployee_idを生成し、3桁のゼロパディング
        $newEmployeeId = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        
        // 新しいemployee_idを設定
        $member->employee_id = 'EMP-' . $newEmployeeId;
    });
}


}