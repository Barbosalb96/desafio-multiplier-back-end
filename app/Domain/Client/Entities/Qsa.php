<?php

namespace App\Domain\Client\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Qsa extends Model
{
    use HasFactory;

    protected $fillable = [
        "nome",
        "qualificacao",
    ];

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'qsa_clients')
            ->withPivot('id')
            ->withTimestamps();
    }
}
