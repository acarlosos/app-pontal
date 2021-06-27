<?php

namespace App\Repository;

use Illuminate\Support\Facades\Storage;
use App\Models\Segmentacao;

class SegmentacaoRepository
{
    protected $segmentacao;
    protected $layout;
    protected $data;


    public function processar(Segmentacao $segmentacao)
    {
        #Alterando o status
        $this->segmentacao = $segmentacao;
        $this->data = $this->segmentacao->data->format('dmY');
        $segmentacao->status = 1;
        $segmentacao->save();

        //Cria o arquivo de saída
        $saida = fopen(storage_path('app/segmentacao/' . $segmentacao->id . '/'. $segmentacao->id . '.txt'), "w+");

        //Abri o arquivo recebido
        $massa = $this->open($segmentacao);

        //Atualizando o status
        $this->escrever($this->header($massa), $saida);
        $segmentacao->status = 2;
        $segmentacao->save();

        $this->detalhes($massa, $saida);
        $this->footer($massa , $saida);

        fclose($saida);
        $segmentacao->status = 3;
        $segmentacao->save();
    }

    public function open(Segmentacao $segmentacao)
    {
        return  file(storage_path('app/segmentacao/' . $segmentacao->id . '/'. $segmentacao->arquivo_txt));
    }

    public function header(&$massa)
    {
        $header = $massa[0];
        unset($massa[0]);
        return $header;
    }

    public function detalhes($massa, $saida)
    {
        if(isset($massa[0]) && substr($massa[0], 0, 2 ) == '00'){
            unset($massa[0]);
        }
        $objeto = [];
        $procurarDebito = true;
        foreach ($massa as $key => $linha) {
            if( substr($linha, 0, 2 ) == '01'){
                unset($objeto);
                $objeto['01'] = $linha;
                unset($massa[$key]);
                continue;
            }
            if( substr($linha, 0, 2 ) == '02'){
                $objeto['02'] = $linha;
                unset($massa[$key]);
                continue;
            }
            if( substr($linha, 0, 2 ) == '03' && $procurarDebito ){
                if ( strtoupper(substr($linha, 24, 4 )) == 'PAGO'){
                    continue;
                }
                
                if (trim(substr($linha, 5, 8 ))  == $this->data ){
                    $objeto['03'] = $linha;
                    unset($massa[$key]);
                    $procurarDebito = false;
                    continue;
                }
            }

            if( substr($linha, 0, 2 ) == '04' && isset($objeto['03'])){
                $objeto['04'] = $linha;
                $this->escrever($objeto, $saida);
                $procurarDebito = true;
                unset($massa[$key]);
                unset($objeto);
                continue;
            }

            
        }
    }

    public function footer($massa , $saida)
    {
        $this->escrever(end($massa), $saida);
    }

    public function escrever($linha, $arquivo)
    {
        if ( is_array($linha )) {
            foreach($linha as $valor ) {
                fwrite($arquivo, $valor);
            }
        }else{
            fwrite($arquivo, $linha);
        }
    }

    

    public function download($id)
    {
        return  storage_path('app/segmentacao/' . $id . '/'. $id . '.txt');
    }
}
