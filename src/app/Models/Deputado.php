<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deputado extends Model
{
    public $incrementing = false; // 👈 importante: id não auto-incrementa
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'nome',
        'partido',
        'uf',
        'foto_url',
        'email',
        'idLegislatura'
    ];

    public function despesas(): HasMany
    {
        return $this->hasMany(Despesa::class);
    }
}
