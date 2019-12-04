<?php

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';

$getfiltri=$_GET["f"];
$filtro_evento_attivo=$_GET["a"];
$filtro_municipio=$_GET["m"];
$filtro_from=$_GET["from"];
$filtro_to=$_GET["to"];
$resp=$_GET["r"];

$pagina=$_POST["pagina"];
$filtro_from=$_POST["startdate"];
$filtro_to=$_POST["todate"];



#echo $filter; 
#exit;
header("Location: ../".$pagina."?r=".$resp."&m=".$filter."&a=".$filtro_evento_attivo."&from='".$filtro_from."'&to='".$filtro_to."'&f=".$getfiltri."");



?>