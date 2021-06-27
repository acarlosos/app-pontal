<?php

namespace App\Models;

use Carbon\Carbon;

/**
 *
 */
trait StatusTrait
{
    public function getCor()
    {
        switch ($this->status) {
            case 0:
                return $this->validaCor('bg-secondary');
            case 1:
                return $this->validaCor('bg-warning');
            case 2:
                return $this->validaCor('bg-primary');
            case 3:
                return 'bg-success';
            default:
                return 'bg-danger';
        }
    }
    public function validaCor($cor)
    {
        $prazo = Carbon::now()->subMinutes(20);
        if ($this->created_at > $prazo) {
            return $cor;
        }
        return 'bg-danger';
    }

    public function validaTexto($texto)
    {
        $prazo = Carbon::now()->subMinutes(20);
        if ($this->created_at > $prazo) {
            return $texto;
        }
        return 'erro';
    }


    public function getPorcentagem()
    {
        switch ($this->status) {
            case 0:
                return $this->validaTexto('10');
            case 1:
            return $this->validaTexto('30');
            case 2:
                return $this->validaTexto('60');
            case 3:
                return '100';
            default:
                return 'erro';
        }
    }
}
