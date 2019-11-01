<?php

session_start();

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';
//require('../check_evento.php');


$uo=$_GET["s"];
$telefono=$_POST["tel"];
$matricola_cf=$_GET["cf"];

echo $matricola_cf;

echo "<br>";

$query="INSERT INTO users.t_telefono_squadre(cod, telefono ";
if ($matricola_cf!=''){
	$query=$query.", matricola_cf ";
}

$query=$query.") VALUES (";
$query=$query." '".$uo."', '".$telefono."' ";
if ($matricola_cf!=''){
	$query=$query.",'" .$matricola_cf. "'";
}
$query=$query.");";
echo $query;
//exit;
$result = pg_query($conn, $query);
echo "<br>";


$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('users','".$_SESSION["operatore"] ."', 'Aggiunta telefono ".$telefono." per la squadra ".$uo."');";
$result = pg_query($conn, $query_log);
echo "<br>";
echo $query_log;

//exit;
//header("location: ../edit_squadra.php?id=".$uo);


?>