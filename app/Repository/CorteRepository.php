<?php

namespace App\Repository;

use Illuminate\Support\Facades\Storage;
use App\Models\Corte;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CortesImport;

class CorteRepository
{
    protected $corte;
    protected $layout;

    public function processar(Corte $corte)
    {
        $this->corte = $corte;
        $corte->status = 1;
        $corte->save();
        $saida = fopen(storage_path('app/corte/' . $corte->id . '/'. $corte->id . '.csv'), "w+");
        $massa = $this->open($corte);
        $this->corrigirArquivo($massa);
        $massa = file(storage_path('app/corte/' . $this->corte->id . '/'. $this->corte->id . '.txt'));
        $m = str_replace("\r", '', $massa[0]);
        $m = str_replace("\n", '', $m);
        $this->escrever($m, $saida);
        $corte->status = 2;
        $corte->save();

        $this->detalhes($massa, $saida);

        fclose($saida);
        $corte->status = 3;
        $corte->save();
    }

    public function corrigirArquivo($massa)
    {
        $novo = fopen(storage_path('app/corte/' . $this->corte->id . '/'. $this->corte->id . '.txt'), "w+");
        $x = $massa[1];
        $campos = explode(';', $x);
        $chave = $campos[0];
        $novaLinha = [];
        $m = str_replace("\r", '', $massa[0]);
        $m = str_replace("\n", '', $m);
        $nLinha = $m;
        unset($massa[0]);
        foreach ($massa as $key =>  $m) {
            $linha = explode(';', $m);
            if (sanitize($linha[0]) == sanitize($chave) || sanitize($linha[0]) == 'XXXX') {
                $m = str_replace("\r", '', $m);
                $m = str_replace("\n", '', $m);
                $nLinha .= PHP_EOL . $m ;
                continue;
            } else {
                $m = str_replace("\r", '', $m);
                $m = str_replace("\n", '', $m);
                $nLinha .= '|'. $m ;
            }
            unset($massa[$key]);
        }
        $this->escrever($nLinha, $novo);
    }

    public function open(Corte $corte)
    {
        return  file(storage_path('app/corte/' . $corte->id . '/'. $corte->arquivo_csv));
    }
    public function openCorte(Corte $corte)
    {
        $arquivo = storage_path('app/corte/' . $corte->id . '/'. $corte->arquivo_xls);
        $reader = \Excel::selectSheetsByIndex(0)->load($arquivo, 'UTF-8');
        $reader->noHeading(); //DESCONSIDERA O HEADER
        $arrData = [];
        $result = $reader->get();
        # Coloca Cada Linha Dentro de um Array
        foreach ($result as $key => $value) {
            if (!is_numeric($value[0])) {
                continue;
            }
            $arrData[sanitize((int)$value[0])] = $value[2];
            unset($result[$key]);
        }
        return $arrData;
    }

    public function header($linha)
    {
        return $this->layout->header($linha);
    }

    public function detalhes($linhas, $saida)
    {
        unset($linhas[0]);
        $corte = $this->openCorte($this->corte);
        $gravar = false;
        $ultimo = '';
        foreach ($linhas as $key => $linha) {
            $campos = explode(';', $linha);
            $campos_cpf = explode('|', $campos[37]);
            $campos[41] = ltrim(sanitize($campos_cpf[0]), '0');

            //04328241540
            if (array_key_exists(sanitize($campos[41]), $corte)) {
                $campos[15] = $corte[sanitize($campos[41])];
                $ultimo = implode(';', $campos);
                $ultimo = str_replace("\r", '', $ultimo);
                $ultimo = str_replace("\n", '', $ultimo);
                $this->escrever($ultimo, $saida);
            }
        }
        $campos = explode(';', $ultimo);
        $campos[0] = '"XXXX"';
        $ultimo = implode(';', $campos);
        $this->escrever($ultimo . PHP_EOL, $saida);
    }

    
    public function escrever($linha, $arquivo)
    {
        fwrite($arquivo, $linha . "\r\n");
    }

    public function downloadCorte($id)
    {
        return  storage_path('app/corte/' . $id . '/'. $id . '.csv');
    }
}
