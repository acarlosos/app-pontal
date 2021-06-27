<?php

use Carbon\Carbon;

function teste()
{
    return 'teste ok ';
}

function layoutsEntrada()
{
    return $entrada;
}

function brancos($string = '', $tamanho = 0)
{
    return str_pad($string, $tamanho);
}

function getTexto($string, $tamanho, $str = false)
{
    $string = sanitize(trim($string));
    if (strlen($string) > $tamanho) {
        $string = substr($string, 0, $tamanho);
    } else {
        // $diff = strlen($string) - mb_strlen($string);
        $string = str_pad($string, $tamanho);
    }
    return $str ? strtoupper($string) : $string;
}

function getNumero($string, $tamanho)
{
    $string = sanitize(trim($string));
    $string = soNumeros($string);
    if (strlen($string) > $tamanho) {
        return  substr($string, 0, $tamanho);
    } else {
        return  str_pad($string, $tamanho, '0', STR_PAD_LEFT);
    }
}

function sanitize($string)
{
    while (strpos($string, '"') !== false) {
        $string = str_replace('"', '', $string);
    }
    return $string;
}

function getData($data, $formato)
{
    $data = Carbon::parse($data);
    return $data->format($formato);
}


function soNumeros($valor)
{
    return preg_replace('/[^0-9]/', '', $valor);
}

function getDigito($string, $str = false)
{
    $string = sanitize(trim($string));

    $string = substr($string, -1);

    return $str ? strtoupper($string) : $string;
}

function validateDate($date, $format = 'd/m/Y')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
