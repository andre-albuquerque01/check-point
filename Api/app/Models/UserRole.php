<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasUlids;

    protected $table = "user_roles";
    protected $fillable = [
        'role',
        'description',
    ];
}
