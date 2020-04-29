<?php

include explode('emergenze-pcge',getcwd())[0].'emergenze-pcge/conn.php';

$pagina=$_POST["pagina"];
$filtro_from=$_POST["startdate"];
$filtro_to=$_POST["todate"];

//echo $pagina ."<br>";
//echo $filtro_from ."<br>";
//echo $filtro_to ."<br>";
#echo $filter; 
//exit;
header("Location: ../".$pagina."?from='".$filtro_from."'&to='".$filtro_to."'");
?>