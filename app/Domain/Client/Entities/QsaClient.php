<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QsaClient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_id',
        'qsa_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function qsa()
    {
        return $this->belongsTo(Qsa::class);
    }
}
