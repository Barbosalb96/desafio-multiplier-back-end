<?php

namespace App\Domain\Client\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($client) {
            $client->id_public = Str::uuid();
        });
    }

    protected $fillable = [
        'nome_fantasia',
        'email',
        'cnpj',
        'endereco',
        'cidade',
        'estado',
        'pais',
        'telefone',
        'area_atuacao_cnae',
    ];

    public function qsas(): BelongsToMany
    {
        return $this->belongsToMany(Qsa::class, 'qsa_clients', 'client_id', 'qsa_id')
            ->withPivot('id')
            ->withTimestamps();
    }
}
