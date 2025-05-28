<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaiModel extends Model
{
    use HasFactory;
    protected $table = 'nilai';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nilai',
        'id_user',
        'id_artikel',
    ];
}
