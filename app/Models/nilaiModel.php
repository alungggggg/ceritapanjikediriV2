<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function artikel(): HasMany
    {
        return $this->hasMany(artikelModel::class, 'id', 'id_artikel');
    }
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'id_user');
    }
}
