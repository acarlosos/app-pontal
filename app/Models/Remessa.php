<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LayoutTrait;
use App\User;

class Remessa extends Model
{
    use SoftDeletes,StatusTrait, LayoutTrait;

    protected $table = 'remessas';
    const AGUARDANDO = 0;
    const LEITURA = 1;
    const PROCESSAMENTO = 2;
    const FINALIZADO = 3;
    const ERRO = 99;

    protected $fillable = [
        'arquivo_entrada',
        'layout_entrada',
        'layout_saida',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
