<?php

namespace App\Layout\Entrada;

use Carbon\Carbon;

class LayoutMala extends LayoutPadrao
{
    public function header($linha)
    {
        $linha = explode(';', $linha);
        $header = '0'; #tipo_de_registro 001 001
        $header .= '1'; #operacao = '1'; #002 002
        $header .= getTexto('remessa', 7, true) ;#literal_de_remessa = 'remessa'; #003 009
        $header .= '01'; #coodigo_do_servico = '01'; #010 011
        $header .= getTexto('COBRANCA', 15, 1) ; #literal_do_servico = 'cobranca'; #012 026
        $header .= getNumero($linha[22], 4) ;#agencia =  #026 030
        $header .= '00';#zeros = '00'; #031 032
        $header .= getNumero($linha[23], 6) ;#CONTA + DAC #033 038
        $header .= getTexto('', 8); #brancos = ''; #039 046
        $header .= getTexto($linha[34], 30, true) ; #nome_da_empresa = ''; #039 046
        $header .= getNumero($linha[89], 3) ;#CÓDIGO DO BANCO #077 079
        $header .= getTexto('BANCO ITAU SA', 15, true) ; #nome_do banco = ''; #080 094
        $header .= getData($linha[1], 'dmy') ; #data geracao
        $header .= getTexto('', 294) ; #brancos 294
        $header .= getNumero(++$this->total, 6) ;#CÓDIGO DO BANCO #077 079
        return $header;
    }

    public function detalhes($linha)
    {
        $detalhe = '1';
        $detalhe .= '02';
        $detalhe .= getNumero($linha[183], 14);
        $detalhe .= getNumero($linha[22], 4) ;
        $detalhe .= '00';
        $detalhe .= getNumero($linha[23], 6) ;
        $detalhe .= getTexto('', 4);
        $detalhe .= getNumero('0', 4);

        $identificacao = trim($linha[27], '"') . '/' . ltrim(trim($linha[28], '"'), '0');
        $detalhe .= getTexto($identificacao, 25);
        $detalhe .= getNumero($linha[21], 8);
        $detalhe .= getNumero(0, 13);
        $detalhe .= getNumero(109, 3);
        $detalhe .= getTexto('', 21);
        $detalhe .= getTexto('i', 1, true);
        $detalhe .= getTexto('11', 2, true);
        $detalhe .= getTexto($identificacao, 10);
        $detalhe .= getData($linha[24], 'dmy') ; #data vencimento
        $detalhe .= getNumero($linha[213], 13) ;
        $detalhe .= getNumero('341', 3);
        $detalhe .= getNumero('0', 5);
        $detalhe .= getTexto('01', 2);
        $detalhe .= getTexto('N', 1);
        $detalhe .= getData($linha[24], 'dmy') ; #data vencimento
        $detalhe .= getTexto('00', 2);
        $detalhe .= getTexto('00', 2);
        $detalhe .= getNumero('0', 13);
        $detalhe .= getNumero('0', 6);
        $detalhe .= getNumero('0', 13);
        $detalhe .= getNumero('0', 13);
        $detalhe .= getNumero('0', 13);
        $detalhe .= getTexto('01', 2);
        $detalhe .= getNumero($linha[41], 14);
        $detalhe .= getTexto($linha[3], 40);
        $detalhe .= getTexto($linha[4], 40);
        $detalhe .= getTexto($linha[87], 12);
        $detalhe .= getTexto($linha[5], 8);
        $detalhe .= getTexto($linha[6], 15);
        $detalhe .= getTexto($linha[7], 2);
        $detalhe .= getTexto('', 34);
        $detalhe .= getNumero('0', 6);
        $detalhe .= getNumero('0', 2);
        $detalhe .= getTexto('', 1);
        $detalhe .= getNumero(++$this->total, 6);
        $detalhe .= "\r\n";

        $detalhe .= "2";
        $detalhe .= "0";
        $data = Carbon::parse($linha[24])->addDay();
        $detalhe .= getData($linha[24], 'dmY');
        $detalhe .= getNumero('33', 13);
        $detalhe .= getTexto('', 371);
        $detalhe .= getNumero(++$this->total, 6) ;
        return $detalhe;
    }

    public function footer()
    {
        $footer = '9';
        $footer .= getTexto('', 393);
        $footer .= getNumero(++$this->total, 6);
        return $footer;
    }
}
