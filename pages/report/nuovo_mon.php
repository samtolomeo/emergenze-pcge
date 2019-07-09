<?php

session_start();

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';
require('../check_evento.php');

$id=$_GET["id"];
//$id=str_replace("'", "", $id);


$data_inizio=$_POST["data_inizio"].' '.$_POST["hh_start"].':'.$_POST["mm_start"];
//$d1 = new DateTime($data_inizio);
//$d2 = new DateTime($data_fine);
$d1 =  strtotime($data_inizio);

$aggiornamento= str_replace("'", "''", $_POST["aggiornamento"]);




//$d1 = DateTime::createFromFormat('Y-m-d H:M', strtotime($data_inizio));
//$d2 = DateTime::createFromFormat('Y-m-d H:M', $data_fine);
echo $data_inizio;
echo "<br>";
echo $d1;
echo "<br>";



$query="INSERT INTO report.t_aggiornamento_meteo (id_evento,data,aggiornamento) VALUES";
$query= $query." ('".$id."','".$data_inizio."','".$aggiornamento."');"; 
echo $query;
//exit;
$result = pg_query($conn, $query);
echo "<br>";





//exit;



$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('report','".$operatore ."', 'Inserito aggiornamento meteo (evento ".$id."');";
$result = pg_query($conn, $query_log);



//$idfascicolo=str_replace('A','',$idfascicolo);
//$idfascicolo=str_replace('B','',$idfascicolo);
echo "<br>";
echo $query_log;

//exit;
//header("location: ../reportistica.php");
header('Location: ' . $_SERVER['HTTP_REFERER']);


?>