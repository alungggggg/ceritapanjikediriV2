<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikelModel extends Model
{
    use HasFactory;
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'artikel_link',
        'image',
    ];
}
