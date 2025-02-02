<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historyModel extends Model
{
    use HasFactory;
    protected $table = 'history';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_dongeng',
    ];
}
