<?php

namespace App\Repository;

use App\Models\Validador;
use Illuminate\Support\Facades\Storage;

class ValidadorRepository
{
    protected $remessa;
    protected $layout;
    protected $success;
    protected $error;
    protected $log;
    protected $successTotal = 1;
    protected $errorTotal = 1;

    public function processar(Validador $validador)
    {

        $validador->status = 1;
        $validador->save();
        $this->error = fopen(storage_path('app/validador/' . $validador->id . '/error'. $validador->id . '.txt'), "w+");
        $this->success = fopen(storage_path('app/validador/' . $validador->id . '/success'. $validador->id . '.txt'), "w+");
        $this->log = fopen(storage_path('app/validador/' . $validador->id . '/log'. $validador->id . '.txt'), "w+");

        //Carrega o layout
        $this->layout = new $validador->layout_entrada($validador);
        $massa = $this->open($validador);
        $foot = array_pop($massa);
        $head = array_shift($massa);

        $this->escrever($head, $this->error);
        $this->escrever($head, $this->success);


        $this->escrever($this->header($head), $this->error);

        $validador->status = 2;
        $validador->save();
        $this->detalhes($massa);

        $this->footer($foot);

        fclose($this->success);
        fclose($this->error);
        fclose($this->log);
        $validador->status = 3;
        $validador->save();
    }

    public function open(Validador $validador)
    {
        return  file(storage_path('app/validador/' . $validador->id . '/'. $validador->arquivo_entrada));
    }

    public function header($linha)
    {
        return $this->layout->header($linha);
    }

    public function detalhes($linhas)
    {
        unset($linhas[0]);

        foreach ($linhas as $key => $linha) {
            $l = $this->layout->detalhes($linha, $key);
            if(trim($l)){
                $this->escrever($linha, $this->error);
                $this->escrever($l, $this->log);
                $this->errorTotal++;
            }else{
                $this->escrever($linha, $this->success);
                $this->successTotal++;
            }
        }
    }

    public function footer($foot)
    {
        $l = $this->layout->footer($foot);
        if (trim($l)){
            $this->escrever($l, $this->log);
        }
        $this->escrever(substr_replace($foot, str_pad($this->errorTotal, 5, 0,STR_PAD_LEFT), 30, 5 ), $this->error);
        $this->escrever(substr_replace($foot, str_pad($this->successTotal, 5, 0,STR_PAD_LEFT), 30, 5 ), $this->success);
    }
    public function escrever($linha, $arquivo)
    {

        fwrite($arquivo, $linha );

    }

    public function downloadSuccess($id)
    {
        return  storage_path('app/validador/' . $id . '/success'. $id . '.txt');
    }
    public function downloadError($id)
    {
        return  storage_path('app/validador/' . $id . '/error'. $id . '.txt');
    }
    public function downloadLog($id)
    {
        return  storage_path('app/validador/' . $id . '/log'. $id . '.txt');
    }


}
