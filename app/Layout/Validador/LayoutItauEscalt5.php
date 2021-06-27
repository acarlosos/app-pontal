<?php
namespace App\Layout\Validador;

use App\Models\Validador;
use Hamcrest\Type\IsNumeric;

class LayoutItauEscalt5
{
    private $validador;
    private $idS = ['01', '02', '03', '05', '06'];
    private $idN = ['PF', 'CT', 'VP', 'VT', 'IM','PE', 'IC', 'CD', 'SE', 'CO','IP', 'PJ', 'VJ', 'IJ', 'MC'];
    private $idF = ['F', 'J'];

    function __construct(Validador $validador)
    {
        $this->validador = $validador;
    }
    public function set( Validador $validador ){
        $this->validador = $validador;
    }

    public function get( ){
        return $this->validador;
    }

    public function header($linha)
    {
        $mensagem = '';
        $mensagem .= substr($linha, 0 ,1) == 0          ? '' : 'LINHA 1: Tipo do registro - Sempre igual a ‘0’ (zero) para identificação do Header - Posição inicial 1 tamanho 1 |';
        $mensagem .= is_numeric(substr($linha, 1 ,5) )  ? '' : 'LINHA 1: Código do Parceiro - Código de identificação do escritório ou fornecedor com o Itaú (XXXXX), dependendo de quem for postar o arquivo via bankline. - Posição inicial 2 tamanho 1 |';
        $mensagem .= is_numeric(substr($linha, 6 ,8) )  ? '' : 'LINHA 1: Data do lote - Data de geração do lote (AAAAMMDD) - Posição inicial 7 tamanho 8 |';
        $mensagem .= is_numeric(substr($linha, 14 ,4) ) ? '' : 'LINHA 1: Hora do lote - Hora de geração do lote (HHMM) - Posição inicial 15 tamanho 4 |';
        $mensagem .= is_numeric(substr($linha, 18 ,4) ) ? '' : 'LINHA 1: Agência - Agência de acesso ao Bankline (informar a agência de quem for postar o arquivo via bankine) - Posição inicial 19 tamanho 4 |';
        // $mensagem .= is_numeric(substr($linha, 22 ,1) ) ? '' : 'LINHA 1: Espaço Reservado - Preencher com zero - Posição inicial 23 tamanho 1 |';
        $mensagem .= is_numeric(substr($linha, 23 ,5) ) ? '' : 'LINHA 1: Preencher com zero - Conta de acesso ao Bankline (99999) sem o DAC (informar a conta de quem for postar o arquivo via bankine) - Posição inicial 24 tamanho 5 |';
        $mensagem .= substr($linha, 28 ,1) == '-'       ? '' : 'LINHA 1: Preencher " - " (traço) - Preencher com “-“ - Posição inicial 29 tamanho 1 |';
        $mensagem .= is_numeric(substr($linha, 29 ,1) ) ? '' : 'LINHA 1: DAC conta - DAC da conta de acesso ao Bankline (informar o DAC da conta de quem for postar via bankline) - Posição inicial 30 tamanho 1 |';
        // $mensagem .= is_numeric(substr($linha, 30 ,1170) ) ? '' : 'LINHA 1: Espaço Reservado - Preencher com zeros - Posição inicial 31 tamanho 1179 |';
        $mensagem .= trim(rtrim($mensagem, '|'));
        return $mensagem;
    }

    public function detalhes($linha, $key){
        $key++;
        $mensagem =  strlen( rtrim($linha, "\r\n") ) != 1200 ? 'LINHA '. $key . ': Tamanho diferente de 1200': '';
        $mensagem .= substr($linha, 0 ,1) == 'C'            ? '' : 'LINHA '. $key . ': Tipo do registro - Sempre igual a ‘C’ para identificação do registro - Posição inicial 1 tamanho 1 |';
        $mensagem .= is_numeric(substr($linha, 1 ,5) )      ? '' : 'LINHA '. $key . ': Código do Parceiro - Código de identificação do fornecedor ou escritório com o Itaú (deve informar o código de quem efetuou o disparo da ação) - Posição inicial 2 tamanho 1 |';
        $mensagem .= is_numeric(substr($linha, 6 ,8) )      ? '' : 'LINHA '. $key . ': Data do lote - Data de geração do lote (AAAAMMDD) - Posição inicial 7 tamanho 8 |';
        $mensagem .= is_numeric(substr($linha, 14 ,4) )     ? '' : 'LINHA '. $key . ': Hora do lote - Hora de geração do lote (HHMM) - Posição inicial 15 tamanho 4 |';
        $mensagem .= substr($linha, 18 ,2) == 59            ? '' : 'LINHA '. $key . ': Status do registro - Sempre igual a 59 para identificação do registro - Posição inicial 19 tamanho 2 |';
        $mensagem .= in_array(substr($linha, 20 ,2), $this->idS)  ? '' : 'LINHA '. $key . ': ID Serviço - Identificação do tipo de serviço enviado - 01 - Boletagem / 02 - Email Marketing / 03 - SMS Marketing / 05- Email Boletagem / 06- SMS com código de barras - Posição inicial 21 tamanho 2 |';
        $mensagem .= strlen(trim(substr($linha, 22 ,30))) > 0  ? '' : 'LINHA '. $key . ': Nome do Fornecedor - Nome do Fornecedor responsável pelo envio do boleto / SMS / E-mail. Caso o disparo da ação tenha sido feito pelo próprio escritório informar o nome do escritório. - Posição inicial 23 tamanho 30 |';
        $mensagem .= is_numeric(substr($linha, 52 ,5)) ? '' : 'LINHA '. $key . ': Código do escritório - Código do Escritório que solicitou o envio do boleto / SMS/ E-mail. - Posição inicial 53 tamanho 5 |';
        $mensagem .= is_numeric(substr($linha, 57 ,10)) ? '' : 'LINHA '. $key . ': Lote - Número interno do fornecedor que identifica o recebimento dos arquivos dos escritórios (JOB) - Posição inicial 58 tamanho 10 |';
        $mensagem .= substr($linha, 67 ,10) == '01/01/0001' ? '' : 'LINHA '. $key . ': Data recebimento Fornecedor - Sempre preencher com 01/01/0001. Obs: incluir as barras. - Posição inicial 68 tamanho 10 |';
        $mensagem .= validateDate(substr($linha, 77 ,10)) ? '' : 'LINHA '. $key . ': Data postagem - Data da postagem do Boleto/SMS/E- mail (DD/MM/AAAA). Obs: incluir as barras. - Posição inicial 78 tamanho 10 |';
        $mensagem .= in_array(substr($linha, 87 ,2), $this->idN)  ? '' : 'LINHA '. $key . ': ID Negócio - Informar um dentre os seguintes domínios: PF (Banco PF), CT (Cartões), VP (Veículos Banco PF), VT (Veículos Itaucred), IM (Imobiliário), PE (Person), IC (Consignado), CD (CDC Magazine Luiza), SE (Seguradora), CO (Consórcio), IP(IPVA), PJ (Pessoa Jurídica), Veículos BPJ (VJ), Veículos ITC PJ (IJ), MC(microcrédito) - Posição inicial 88 tamanho 2 |';
        $mensagem .= substr($linha, 89 ,2) == '01' ? '' : 'LINHA '. $key . ': Código Empresa - Sempre preencher com 01 - Posição inicial 90 tamanho 2 |';
        $mensagem .= is_numeric(substr($linha, 91 ,5)) ? '' : 'LINHA '. $key . ': PRODUTO - Número da Operação (CPRODLIM). Para IPVA: 00109. CDC: 90465. Consórcio e Seguradora: 51001 Itaú Veículos; 51002 – Itaú Imóveis; 51003 – GM; 51004 – VW; 62500 – FIAT. Microcrédito: 33333. - Posição inicial 92 tamanho 5 |';
        $mensagem .= is_numeric( substr($linha, 96 ,15) ) ? '' : 'LINHA '. $key . ': CONTRATO - Número do Contrato (NUMCTROR) - Posição inicial 97 tamanho 15 |';
        $mensagem .= is_numeric( substr($linha, 111 ,14) ) ? '' : 'LINHA '. $key . ': CGC /CPF do Cliente - CPF do cliente completo (com dac) ou CGC da empresa com dac. Preencher com zeros à esquerda. - Posição inicial 112 tamanho 14 |';
        $mensagem .= strlen( trim( substr($linha, 125 ,60) ) ) > 1 ? '' : 'LINHA '. $key . ': Nome do Cliente - Nome Completo do cliente - Posição inicial 126 tamanho 60 |';
        $mensagem .= in_array(substr($linha, 185 ,1), $this->idF) ? '' : 'LINHA '. $key . ': Tipo de Pessoa - Preencher com: F - Física J - Jurídica - Posição inicial 186 tamanho 1 |';
        $mensagem = trim(rtrim($mensagem, '|'));

        return $mensagem . "\r\n";
    }

    public function footer($linha){
        return strlen( rtrim($linha, "\r\n") ) != 1200 ? 'FOOTER : Tamanho diferente de 1200': '';;
    }
}
