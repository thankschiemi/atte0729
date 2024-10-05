<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDate extends Model
{
    use HasFactory;

    protected $table = 'dates'; // テーブル名を明示的に設定

    protected $fillable = [
        'member_id',
        'date',
        'start_work',
        'end_work',
    ];

    protected $casts = [
        'start_work' => 'datetime',
        'end_work' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function breaks()
    {
        return $this->hasMany(Breakk::class, 'date_id');
    }
}






