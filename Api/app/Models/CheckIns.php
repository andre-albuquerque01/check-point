<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class CheckIns extends Model
{
    use HasUlids;

    protected $table = "check_ins";

    protected $fillable = [
        'check_in_time',
        'check_out_time',
        'check_date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
