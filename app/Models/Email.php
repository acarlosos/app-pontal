<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes,  StatusTrait;
    protected $table = 'emails';
    const AGUARDANDO = 0;
    const LEITURA = 1;
    const PROCESSAMENTO = 2;
    const FINALIZADO = 3;
    const ERRO = 99;

    protected $fillable = [
        'csv_mala',
        'arquivo_complementar',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
