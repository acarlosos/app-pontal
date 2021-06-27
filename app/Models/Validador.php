<?php

namespace App\Models;

use App\Traits\LayoutTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Validador extends Model
{
    use SoftDeletes,  StatusTrait, LayoutTrait;

    protected $table = 'validadors';
    const AGUARDANDO = 0;
    const LEITURA = 1;
    const PROCESSAMENTO = 2;
    const FINALIZADO = 3;
    const ERRO = 99;

    protected $fillable = [
        'arquivo_entrada',
        'layout_entrada',
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
