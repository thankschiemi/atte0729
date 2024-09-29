<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Member extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasFactory;

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
        'employee_id' => 'string', // employee_id を文字列としてキャスト（自動生成されるため）
    ];

    // dates リレーションを定義
    public function dates()
    {
        return $this->hasMany(WorkDate::class, 'member_id'); // Date::class を WorkDate::class に変更
    }

    // 社員IDを数字で自動生成する処理
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($member) {
            $lastEmployeeId = Member::whereNotNull('employee_id')
                ->orderByRaw('CAST(SUBSTRING(employee_id, 5) AS UNSIGNED) DESC')
                ->value('employee_id');

            $lastNumber = $lastEmployeeId ? (int) substr($lastEmployeeId, 4) : 0;
            $newEmployeeId = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            $member->employee_id = 'EMP-' . $newEmployeeId;
        });
    }
}

