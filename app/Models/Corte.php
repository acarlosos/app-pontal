<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corte extends Model
{
    use SoftDeletes,  StatusTrait;
    protected $table = 'cortes';
    const AGUARDANDO = 0;
    const LEITURA = 1;
    const PROCESSAMENTO = 2;
    const FINALIZADO = 3;
    const ERRO = 99;

    protected $fillable = [
        'arquivo_csv',
        'arquivo_xls',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
