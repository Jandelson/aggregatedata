<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'host',
        'database',
        'port',
        'user',
        'password',
        'table_name',
        'if_exists',
        'enable'
    ];
}
