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
    protected static function boot()
{
    parent::boot();

    static::creating(function ($member) {
        // 既存の最大IDに+1し、それを3桁にゼロパディングして生成
        $lastId = Member::max('id') + 1;
        $member->employee_id = 'EMP-' . str_pad($lastId, 3, '0', STR_PAD_LEFT);
    });
}

}