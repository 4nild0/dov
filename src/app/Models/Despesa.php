<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Despesa extends Model
{
    protected $fillable = [
        'deputado_id',
        'tipo_despesa',
        'valor',
        'data',
        'fornecedor'
    ];

    public function deputado(): BelongsTo
    {
        return $this->belongsTo(Deputado::class);
    }
}
