<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breakk extends Model
{
    use HasFactory;

    protected $table = 'breakks'; // テーブル名を明示的に設定

    protected $fillable = [
        'date_id',
        'start_break',
        'end_break',
    ];

    protected $casts = [
        'start_break' => 'datetime',
        'end_break' => 'datetime',
    ];

    public function workDate()
    {
        return $this->belongsTo(WorkDate::class, 'date_id');
    }
}


