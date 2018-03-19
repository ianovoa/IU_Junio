<?php
//funcion que da la fecha exacta del sistema (dia-mes-año-hora-minuto-segundo) en un array

function fecha(){
    $toret= getdate();
    
    $fecha=array(
        "dia"=>$toret["mday"],
        "mes"=>$toret["mon"],
        "año"=>$toret["year"],
        "hora"=>$toret["hours"],
        "minuto"=>$toret["minutes"],
        "segundo"=>$toret["seconds"]
        );
    return $fecha;
}