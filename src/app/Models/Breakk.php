<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breakk extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_id',
        'start_break',
        'end_break',
    ];

    public function date()
    {
        return $this->belongsTo(Date::class, 'date_id');
    }
}

