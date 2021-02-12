<?php

/**
 * 
 */
class Funciones
{

    function __construct()
    {
        date_default_timezone_set("America/Mexico_City");
    }
    function validaCodigo($codigo)
    {
        $var = explode('-', $codigo);
        $fecha = (intval($var[0])) ? intval($var[0]) : false;
        $increment = (intval($var[1])) ? intval($var[1]) : false;
        $code = (intval($var[2])) ? intval($var[2]) : false;
        if ($fecha != false && $increment != false && $code != false) {
            return $fecha . '-' . $increment . '-' . $code;
        } else {
            return false;
        }
    }
    function ValidaFechaPDF($fecha)
    {
        //$end = '2019-02-05 09:50:05';
        $fecha_actual = strtotime(date("Y-m-d H:i:s"));
        $fecha_nacimiento = strtotime($fecha);
        if ($fecha_actual > $fecha_nacimiento) {
            return true;
        } else {
            return false;
        }
    }
    function validaFechaInsert($fecha)
    {
        if ($fecha == date('ymd')) {
            return true;
        } else {
            return false;
        }
    }
    function IncrementCode($codes)
    {
        //$codes = 'PDF-190211-000';
        $arr_codes = explode('-', $codes);

        if (date('ymd') == $arr_codes[1]) {
            $secuencia = intval($arr_codes[2]) + 1;
            return 'PDF-' . date('ymd') . '-' . $secuencia;
        } else {
            return 'PDF-' . date('ymd') . '-1';
        }
    }
    function extractFecha($dato)
    {
        $var = explode('-', $dato);
        return $var[1];
    }
    function genKey($user)
    {
        $alphabeth = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890";
        $code = "";
        $fecha = date('Y-m-d');
        $hora = date('h:i:s');
        for ($i = 0; $i < 4; $i++) {
            $code .= $alphabeth[rand(0, strlen($alphabeth) - 1)];
        }
        //return $code.'&'.$user.'&'.$hora.'&'.$fecha;
        return $code . base64_encode($user . $fecha . $hora);
        //return $code;
    }
}
