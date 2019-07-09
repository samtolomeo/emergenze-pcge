<?php

session_start();

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';
require('../check_evento.php');

$id_segnalazione_lav=$_GET["id_lav"];
$id=$_GET["id"];
$note= str_replace("'", "''", $_POST["note"]);




$query= "UPDATE segnalazioni.t_segnalazioni_in_lavorazione SET in_lavorazione='f'";
$query=$query.", descrizione_chiusura='".$note."' ";
if($_POST["invio"]=='man') {
	$query=$query.", invio_manutenzioni='t' ";
}
if($_POST["invio"]=='llpp') {
	$query=$query.", invio_llpp='t' ";
}

$query=$query." WHERE id=".$id_segnalazione_lav.";";
echo $query;
$result = pg_query($conn, $query);

echo "<br>";

if($_POST["invio"]=='man') {
	$query="INSERT INTO segnalazioni.t_storico_segnalazioni_in_lavorazione(id_segnalazione_in_lavorazione, log_aggiornamento) VALUES (";
	$query=$query."".$id_segnalazione_lav.",'Segnalazione risolta per la PC, ma problema ancora attivo e predispost flag per l'invio a \"Manutenzioni\"');";
	echo $query;
	$result = pg_query($conn, $query);
	echo "<br>";
}

if($_POST["invio"]=='llpp') {
	$query="INSERT INTO segnalazioni.t_storico_segnalazioni_in_lavorazione(id_segnalazione_in_lavorazione, log_aggiornamento) VALUES (";
	$query=$query."".$id_segnalazione_lav.",'Segnalazione risolta per la PC, ma problema ancora attivo e predispost flag per l'invio a \"LLPP\"');";
	echo $query;
	$result = pg_query($conn, $query);
	echo "<br>";
}


$query="INSERT INTO segnalazioni.t_storico_segnalazioni_in_lavorazione(id_segnalazione_in_lavorazione, log_aggiornamento) VALUES (";
$query=$query."".$id_segnalazione_lav.",'Chiusura delle segnalazioni. (id_lavorazione= ".$id_segnalazione_lav.")');";
echo $query;

//exit;
$result = pg_query($conn, $query);
echo "<br>";



$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('segnalazioni','".$operatore ."', 'La segnalazione in lavorazione con ".$id_segnalazione_lav." è stata chiusa');";
$result = pg_query($conn, $query_log);
echo "<br>";
echo $query_log;

//exit;
header("location: ../dettagli_segnalazione.php?id=".$id);


?>