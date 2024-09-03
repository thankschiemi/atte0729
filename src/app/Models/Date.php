<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $fillable = [
        'member_id',
        'date',
        'start_work',
        'end_work'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Breakkモデルとのリレーションを定義
    public function breaks()
    {
        return $this->hasMany(Breakk::class, 'date_id');
    }

    protected $table = 'dates';


}


