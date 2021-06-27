<?php

namespace App\Layout\Entrada;

use Carbon\Carbon;

class LayoutBradesco extends LayoutPadrao
{
    public function header($linha)
    {
        $linha = explode(';', $linha);
        $header = '0'; #001 a 001 Identificação do Registro 001 0 X
        $header .= '1'; #002 a 002 Identificação do Arquivo Remessa 001 1 X
        $header .= getTexto('remessa', 7, true) ;#003 a 009 Literal Remessa 007 REMESSA X
        $header .= '01'; #010 a 011 Código de Serviço 002 01 X
        $header .= getTexto('COBRANCA', 15, true) ; #012 a 026 Literal Serviço 015 COBRANCA X
        $header .= getNumero('7885591', 20) ;#027 a 046 Código da Empresa 020 Será fornecido pelo Bradesco, quando do Cadastramento Vide Obs. Pág.16 X
        $header .= getTexto($linha[34], 30, true) ; #047 a 076 Nome da Empresa 030 Razão Social X
        $header .= '237';#077 a 079 Número do Bradesco na Câmara de Compensação 003 237 X
        $header .= getTexto('Bradesco', 15, true) ; #080 a 094 Nome do Banco por Extenso 015 Bradesco X
        $header .= getData($linha[0], 'dmy') ; #data geracao#095 a 100 Data da Gravação do Arquivo 006 DDMMAA Vide Obs. Pág.16 X
        $header .= getTexto('', 8, true) ; #101 a 108 Branco 008 Branco X
        $header .= getTexto('MX', 2, true) ; #109 a 110 Identificação do sistema 002 MX Vide Obs. Pág.16 X
        $header .= getNumero($this->remessa->id, 7) ; #111 a 117 Nº Seqüencial de Remessa 007 Sequencial Vide Obs. Pág.16 X
        $header .= getTexto('', 277); #118 a 394 Branco 277 Branco X
        $header .= getNumero(++$this->total, 6) ;#CÓDIGO DO BANCO #077 079
        return $header;
    }

    public function detalhes($linha)
    {
        $detalhe = '1'; #001 a 001 Identificação do Registro 001 1 X
        // $detalhe .= getNumero('02027', 5); #002 a 006 Agência de Débito (opcional) 005 Código da Agência do Pagador Exclusivo para Débito em Conta Vide Obs. Pág. 17 X
        // $detalhe .= getNumero('7', 1); #007 a 007 Dígito da Agência de Débito (opcional) 001 Dígito da Agência do Pagador Vide Obs.Pág. 17 X
        // $detalhe .= getNumero('43171', 5); #008 a 012 Razão da Conta Corrente (opcional) 005 Razão da Conta do Pagador Vide Obs. Pág. 17 X
        // $detalhe .= getNumero('1616', 7); #013 a 019 Conta Corrente (opcional) 007 Número da Conta do Pagadora Vide Obs. Pág. 17 X
        // $detalhe .= getNumero('2', 1); #020 a 020 Dígito da Conta Corrente (opcional) 001 Dígito da Conta do Pagador Vide Obs. Pág. 17 X
        // $detalhe .= gettexto('002' . trim($linha[22]) . trim($linha[23]), 17, true); #021 a 037 Identificação da Empresa Beneficiária no Banco 017 Zero, Carteira, Agência e Conta - Corrente Vide Obs. Pág. 17 X

        $detalhe .= getNumero('', 5); #002 a 006 Agência de Débito (opcional) 005 Código da Agência do Pagador Exclusivo para Débito em Conta Vide Obs. Pág. 17 X
        $detalhe .= getNumero('', 1); #007 a 007 Dígito da Agência de Débito (opcional) 001 Dígito da Agência do Pagador Vide Obs.Pág. 17 X
        $detalhe .= getNumero('', 5); #008 a 012 Razão da Conta Corrente (opcional) 005 Razão da Conta do Pagador Vide Obs. Pág. 17 X
        $detalhe .= getNumero('', 7); #013 a 019 Conta Corrente (opcional) 007 Número da Conta do Pagadora Vide Obs. Pág. 17 X
        $detalhe .= getNumero('', 1); #020 a 020 Dígito da Conta Corrente (opcional) 001 Dígito da Conta do Pagador Vide Obs. Pág. 17 X
        $detalhe .= getTexto('0009' . getNumero($linha[22], 5) . getNumero($linha[23], 7) . '8', 17, true); #021 a 037 Identificação da Empresa Beneficiária no Banco 017 Zero, Carteira, Agência e Conta - Corrente Vide Obs. Pág. 17 X
        $detalhe .= getTexto($linha[27], 25); #038 a 062 Nº Controle do Participante 025 Uso da Empresa Vide Obs. Pág. 17 X
        $detalhe .= getNumero('237', 3); #063 a 065 Código do Banco a ser debitado na Câmara de Compensação 003 Nº do Banco “237” Vide Obs. Pág.17 X
        $detalhe .= getNumero(0, 1) ; #066 a 066 Campo de Multa 001 Se = 2 considerar percentual de multa. Se = 0, sem multa. Vide Obs. Pág. 17 X
        $detalhe .= getNumero(0, 4) ; #067 a 070 Percentual de multa 004 Percentual de multa a ser considerado vide Obs. Pág. 17 X
        $detalhe .= getNumero($linha[21], 11) ; #071 a 081 Identificação do Título no Banco 11 Número Bancário para Cobrança Com e Sem Registro Vide Obs. Pág. 17 X
        $detalhe .= getDigito($linha[21], true) ; #082 a 082 Digito de Auto Conferencia do Número Bancário. 001 Digito N/N Vide Obs. Pág. 17 X
        $detalhe .= getNumero(0, 10) ; #083 a 092 Desconto Bonificação por dia 010 Valor do desconto bonif./dia. X
        $detalhe .= getNumero(2, 1) ; #093 a 093 Condição para Emissão da Papeleta de Cobrança 001 1 = Banco emite e Processa o registro. 2 = Cliente emite e o Banco somente processa o registro – Vide obs. Pág. 19
        $detalhe .= getTexto('N', 1, true) ; #094 a 094 Ident. se emite Boleto para Débito Automático 001 N= Não registra na cobrança. Diferente de N registra e emite Boleto. Vide Obs. Pág. 19 X
        $detalhe .= getTexto('', 10, true) ; #095 a 104 Identificação da Operação do Banco 010 Brancos X
        $detalhe .= getTexto('', 1, true) ; #105 a 105 Indicador Rateio Crédito (opcional) 001 “R”Vide Obs. Pág. 19 X
        $detalhe .= getNumero('2', 1) ; #106 a 106 Endereçamento para Aviso do Débito Automático em Conta Corrente (opcional) 001 Vide Obs. Pág. 19 X
        $detalhe .= getTexto('', 2, true) ; #107 a 108 Quantidade possíveis de pagamento 002 Vide Obs. Pág.20 X
        $detalhe .= getNumero('1', 2) ; #109 a 110 Identificação da ocorrência 002 Códigos de ocorrência Vide Obs. Pág. 20 X
        $detalhe .= getTexto($linha[21], 10, true) ; #111 a 120 Nº do Documento 010 Documento X
        $detalhe .= getData($linha[24], 'dmy') ; #121 a 126 Data do Vencimento do Título 006 DDMMAA Vide Obs. Pág. 20 X
        $detalhe .= getNumero($linha[213], 13) ; #127 a 139 Valor do Título 013 Valor do Título (preencher sem ponto e sem vírgula) X
        $detalhe .= getNumero(0, 3) ; #140 a 142 Banco Encarregado da Cobrança 003 Preencher com zeros X
        $detalhe .= getNumero(0, 5) ; #143 a 147 Agência Depositária 005 Preencher com zeros X
        $detalhe .= getNumero(99, 2) ; #148 a 149
            #Espécie de Título 002
            #01-Duplicata
            #02-Nota Promissória
            #03-Nota de Seguro
            #04-Cobrança Seriada
            #05-Recibo
            #10-Letras de Câmbio
            #11-Nota de Débito
            #12-Duplicata de Serv.
            #31-Cartão de Crédito
            #32-Boleto de Proposta
            #99-Outros
            #X
        
        $detalhe .= getTexto('N', 1, true);
        $detalhe .= getData($linha[0], 'dmy') ; #121 a 126 Data do Vencimento do Título 006 DDMMAA Vide Obs. Pág. 20 X
        $detalhe .= getNumero('0', 2); #157 a 158 1ª instrução 002 Vide Obs. Pág. 20 X
        $detalhe .= getNumero('0', 2); #159 a 160 2ª instrução 002 Vide Obs. Pág. 20 X
        $detalhe .= getNumero('0', 13); #161 a 173 Valor a ser cobrado por Dia de Atraso 013 Mora por Dia de Atraso Vide obs. Pág. 21 X
        $detalhe .= getNumero(0, 6) ; #174 a 179 Data Limite P/Concessão de Desconto 006 DDMMAA X
        $detalhe .= getNumero('0', 13); #180 a 192 Valor do Desconto 013 Valor Desconto X
        $detalhe .= getNumero('0', 13); #193 a 205 Valor do IOF 013 Valor do IOF – Vide Obs. Pág. 21 X
        $detalhe .= getNumero('0', 13); #206 a 218 Valor do Abatimento a ser concedido ou cancelado 013 Valor Abatimento X
        $detalhe .= getNumero('01', 2); #219 a 220 Identificação do Tipo de Inscrição do Pagador 002 01-CPF 02-CNPJ X
        $detalhe .= getNumero($linha[41], 14); #221 a 234 Nº Inscrição do Pagador 014 CNPJ/ CPF - Vide Obs. Pág. 21 (Preenchimento obrigatório) X
        $detalhe .= getTexto($linha[3], 40, true); #235 a 274 Nome do Pagador 040 Nome do Pagador X
        $detalhe .= getTexto($linha[4], 40, true); #275 a 314 Endereço Completo 040 Endereço do Pagador X
        $detalhe .= getTexto('', 12, true); #315 a 326 1ª Mensagem 012 Vide Obs. Pág. 22 X
        $detalhe .= getNumero(substr($linha[5], 0, 5), 5); #327 a 331 CEP 005 CEP Pagador X
        $detalhe .= getNumero(substr($linha[5], -3), 3); #332 a 334 Sufixo do CEP 003 Sufixo X
        $detalhe .= getTexto('', 60, true); #335 a 394 Sacador/Avalista ou 2ª Mensagem 060 Decomposição Vide Obs. Pág. 22 X
        $detalhe .= getNumero(++$this->total, 6);
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
