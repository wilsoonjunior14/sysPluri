<?php

namespace sysPluri;

class config
{
    public static function formataData($data){
        if( strlen($data) > 10 ){
            $data = substr($data, 0, 10);
        }
        $data = explode("-",explode(" ",$data)[0]);
        return $data[2]."/".$data[1]."/".$data[0];
    }
    
    public static function formataDataBase($data){
        if( strlen($data) > 10 ){
            $data = substr($data, 0, 10);
        }
        $data = explode("/",explode(" ",$data)[0]);
        return $data[2]."-".$data[1]."-".$data[0];
    }
    
    public static function formataHora($data){
        return substr($data, 10, strlen($data));
    }

    public static function validarData($data){
        if (strlen($data) <= 0 || strlen($data) > 10) return false;

        $ano = date('Y');
        $data = explode("/", $data);
        if ($data[2] <= 0 || $data[2] > $ano ) return false;
        if ($data[1] <= 0 || $data[1] > 12) return false;
        if ($data[0] <= 0 || $data[0] > 31) return false;

        return true;
    }
}
