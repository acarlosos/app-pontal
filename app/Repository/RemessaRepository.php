<?php

namespace App\Repository;

use App\Models\Remessa;
use Illuminate\Support\Facades\Storage;

class RemessaRepository
{
    protected $remessa;
    protected $layout;

    public function processar(Remessa $remessa)
    {
        $remessa->status = 1;
        $remessa->save();
        $saida = fopen(storage_path('app/remessa/' . $remessa->id . '/'. $remessa->id . '.rem'), "w+");
        $this->layout = new $remessa->layout_entrada;
        $this->layout->setRemessa($remessa);

        $massa = $this->open($remessa);
        //Validação do Header
        $this->escrever($this->header($massa[1]), $saida);

        $remessa->status = 2;
        $remessa->save();

        $this->detalhes($massa, $saida);
        $this->footer($saida);

        fclose($saida);
        $remessa->status = 3;
        $remessa->save();
    }

    public function open(Remessa $remessa)
    {
        return  file(storage_path('app/remessa/' . $remessa->id . '/'. $remessa->arquivo_entrada));
    }

    public function header($linha)
    {
        return $this->layout->header($linha);
    }

    public function detalhes($linhas, $saida)
    {
        unset($linhas[0]);

        foreach ($linhas as $key => $linha) {
            $linha = explode(';', $linha);
            if (strtoupper($linha[0]) == 'XXXX') {
                continue;
            }
            $l = $this->layout->detalhes($linha);
            $this->escrever($l, $saida);
        }
    }

    public function footer($saida)
    {
        $l = $this->layout->footer();
        $this->escrever($l, $saida);
    }
    public function escrever($linha, $arquivo)
    {
        fwrite($arquivo, $linha . "\r\n");
    }

    public function downloadRemessa($id)
    {
        return  storage_path('app/remessa/' . $id . '/'. $id . '.rem');
    }
}
