<?php 
//Main functions
require_once("functions.php");

//////
//Manipular formatos de fecha
//////
//llegada
$dia = substr($_POST["llegada"], 0,2);
$mes = substr($_POST["llegada"], 3,2);
$anio = substr($_POST["llegada"], 6,4);
//fecha checkout
$diaP = substr($_POST["partida"], 0,2);
$mesP = substr($_POST["partida"], 3,2);
$anioP = substr($_POST["partida"], 6,4);


//lang
$lang = $_POST["lang"];

//hostel
$hostel = $_POST["destino"];

if($hostel == "suites"){
	procesarHQ();
}else if($hostel == "ezee"){
	procesarEzee($lang);
}else{
	procesarHW();	
}



?>