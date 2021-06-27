<?php

namespace App\Repository;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Email;

class EmailRepository
{
    protected $email;
    protected $layout;

    public function processar(Email $email)
    {
        $this->email = $email;
        $email->status = 1;
        $email->save();

        $saida = fopen(storage_path('app/email/' . $email->id . '/'. $email->id . '.csv'), "w+");

        $massa = $this->open($email);
        $this->corrigirArquivo($massa);
        unset($massa);
        $massa = file(storage_path('app/email/' . $this->email->id . '/'. $this->email->id . '.txt'));
        $m = str_replace("\r", '', $massa[0]);
        $m = str_replace("\n", '', $m);

        $this->escrever($m, $saida);
        $email->status = 2;
        $email->save();
        $this->detalhes($massa, $saida);

        fclose($saida);
        $email->status = 3;
        $email->save();
    }

    public function corrigirArquivo($massa)
    {
        $novo = fopen(storage_path('app/email/' . $this->email->id . '/'. $this->email->id . '.txt'), "w+");
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
        unset($nLinha);
    }

    public function open(Email $email)
    {
        return  file(storage_path('app/email/' . $email->id . '/'. $email->csv_mala));
    }
    public function openEmail(Email $email)
    {
        $arquivo = file(storage_path('app/email/' . $email->id . '/'. $email->arquivo_complementar));
        $arrData = [];
        unset($arquivo[0]);
        # Coloca Cada Linha Dentro de um Array
        foreach ($arquivo as $key => $value) {
            $value = explode(';', $value);
            $arrData[sanitize((int)$value[0])] = $value[1];
            unset($arquivo[$key]);
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
        $emails = $this->openEmail($this->email);
        $gravar = false;
        $ultimo = '';
        foreach ($linhas as $key => $linha) {
            $campos = explode(';', $linha);
            // $campos_cpf = explode('|', $campos[37]);
            $campos[41] = ltrim(sanitize($campos[41]), '0');
            if (array_key_exists(sanitize($campos[41]), $emails)) {
                $campos[15] = $emails[sanitize($campos[41])];
                $ultimo = implode(';', $campos);
                $ultimo = str_replace("\r", '', $ultimo);
                $ultimo = str_replace("\n", '', $ultimo);
                $this->escrever($ultimo, $saida);
            }
            unset($linhas[$key]);
        }
        unset($emails);
        unset($linhas);
        $campos = explode(';', $ultimo);
        $campos[0] = '"XXXX"';
        $ultimo = implode(';', $campos);
        $this->escrever($ultimo . PHP_EOL, $saida);
    }


    public function escrever($linha, $arquivo)
    {
        fwrite($arquivo, $linha . "\r\n");
    }

    public function download($id)
    {
        return  storage_path('app/email/' . $id . '/'. $id . '.csv');
    }
}
