<?php

namespace App\Traits;

/**
 *
 */
trait LayoutTrait
{
    public $entrada = [
        'Itau'=>'App\Layout\Entrada\LayoutMala',
        'Bradesco'=>'App\Layout\Entrada\LayoutBradesco',
    ];
    protected $saida = [
        'Layout Itau'=>'App\Layout\Saida\LayoutMala',
        'Layout Bradesco'=>'App\Layout\Saida\LayoutBradesco',
    ];

    public $validador = [
        'Itau Escalt 5.0'=>'App\Layout\Validador\LayoutItauEscalt5'
    ];

    public function entrada()
    {
        return $this->entrada;
    }

    public function saida()
    {
        return $this->saida;
    }

    public function validador(){
        return $this->validador;
    }
}
