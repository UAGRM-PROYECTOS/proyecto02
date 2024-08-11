<?php

namespace App\Http\Controllers\Utilidades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class LogsController extends Controller
{
    public static function guardar($nombreLog, \Throwable $th, $tlhistorial = false)
    {
        $getMessage = "<Message>" . PHP_EOL . "\t" . $th->getMessage() . PHP_EOL . "<\Message>" . PHP_EOL;
        $getCode = "<Code>" . PHP_EOL . "\t" . $th->getCode() . PHP_EOL . "<\Code>" . PHP_EOL;
        $getFile = "<File >" . PHP_EOL . "\t" . $th->getFile() . PHP_EOL . "<\File>" . PHP_EOL;
        $getLine = "<Line >" . PHP_EOL . "\t" . $th->getLine() . PHP_EOL . "<\Line>" . PHP_EOL;
        $fileName = date('dmY') . "_" . date('His') . "_" . $nombreLog . ".txt";
        $stringTrace = $th->getTraceAsString();
        $arrayTrace = explode("#", $stringTrace);
        $n = count($arrayTrace);
        $cadena = "";
        $trace = "";

        for ($i = 0; $i < $n; $i++) {
            $trace = $trace . $arrayTrace[$i] . PHP_EOL;
        }

        $getTrace = "<Stack Trace>" . $trace . "<\Stack Trace>";
        $cadena = $getMessage . PHP_EOL . $getCode . PHP_EOL . $getFile . PHP_EOL . $getLine . PHP_EOL . $getTrace;

        if ($tlhistorial) {
            Storage::disk('errores')->prepend($fileName, $cadena);
        } else {
            Storage::disk('errores')->put($fileName, $cadena);
        }
    }

    //recibe varios mensajes y los guarda en un archivo de log
    public static function guardarLog($tlhistorial = false, $tcNombre, ...$tcMensaje)
    {
        $tlhistorial = true;

        try {
            if ($tcMensaje === null) {
                $tcMensaje = "tcMensaje es NULL";
            }

            $fileName = "";

            if ($tlhistorial) {
                $fileName = $tcNombre;
            } else {
                $fileName = date('dmY') . "_" . date('His') . "_" . $tcNombre . ".txt";
            }

            $tcFinal = "";

            foreach ($tcMensaje as $n) {
                if (is_string($n)) {
                    $tcFinal = $tcFinal . $n . "\n\n";
                } else {
                    $tcFinal = $tcFinal . json_encode($n, JSON_PRETTY_PRINT) . "\n\n";
                }
            }

            if ($tlhistorial) {
                $cabecera = date('Y-m-d H:i:s:u :::::::::::::::::::::::::::::::::::::') . "$tcNombre \n";
                $tcFinal = $cabecera . $tcFinal . "\n\n";
                Storage::disk('LogNormal')->prepend($fileName, "\xEF\xBB\xBF" . $tcFinal);
            } else {
                Storage::disk('LogNormal')->put($fileName, "\xEF\xBB\xBF" . $tcFinal);
            }
        } catch (\Throwable $th) {
            LogsController::guardar("guardarLog", $th);
        }
    }

    //guardar response de una peticion     //nombre archivo , array mensaje
    public static function guardarResponse($tcNombre, ...$tcMensaje){

    }
}
