<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segmentacao extends Model
{
    use SoftDeletes,  StatusTrait;
    protected $table = 'segmentacoes';
    const AGUARDANDO = 0;
    const LEITURA = 1;
    const PROCESSAMENTO = 2;
    const FINALIZADO = 3;
    const ERRO = 99;

    protected $fillable = [
        'arquivo_txt',
        'data',
        'user_id',
        'status'
    ];

    protected $casts = [
        'data' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
