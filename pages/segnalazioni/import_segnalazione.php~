<?php

session_start();

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';

//$id=$_GET["id"];
$id=str_replace("'", "", $id);

echo "La gestione della segnalazione e' attualmente in fase di sviluppo. Ci scusiamo per il disagio<br>";
#segnalante

$query_max= "SELECT max(id) FROM segnalazioni.t_segnalanti;";
$result_max = pg_query($conn, $query_max);
while($r_max = pg_fetch_assoc($result_max)) {
	if ($r_max["max"]>0) {
		$id_segnalante=$r_max["max"]+1;
	} else {
		$id_segnalante=1;	
	}
}

echo $id_segnalante;
echo "<br>";


$query= "INSERT INTO segnalazioni.t_segnalanti( id, id_tipo_segnalante, nome_cognome";
if ($_POST["altro"]!=''){
	$query= $query .", altro_tipo";
}
if ($_POST["telefono"]!=''){
	$query= $query .", telefono";
}
if ($_POST["note_segnalante"]!=''){
	$query= $query .", note";
}
//values
$query=$query.") VALUES (".$id_segnalante.", ".$_POST["tipo_segn"].", '".$_POST["nome"]."' ";
if ($_POST["altro"]!=''){
	$query= $query .", '".$_POST["altro"]."'";
}
if ($_POST["telefono"]!=''){
	$query= $query .", '".$_POST["telefono"]."'";
}
if ($_POST["note_segnalante"]!=''){
	$query= $query .", '".$_POST["note_segnalante"]."'";
}

$query=$query.");";

echo $query;
$result=pg_query($conn, $query);

echo "<br>";
//exit;

//**************************************************************
// INSERIMENTO SEGNALAZIONI


$query_max= "SELECT max(id) FROM segnalazioni.t_segnalazioni;";
$result_max = pg_query($conn, $query_max);
while($r_max = pg_fetch_assoc($result_max)) {
	if ($r_max["max"]>0) {
		$id_segnalazione=$r_max["max"]+1;
	} else {
		$id_segnalazione=1;	
	}
}

echo $id_segnalazione;
echo "<br>";


//************************************
// DEMO da rimuovere quando ci sarà le gestione utenti
$operatore="MRZRRT84B01D969U";
//*************************************

$id_oggetto=''; // inizializzazione
$descrizione= str_replace("'", "''", $_POST["descrizione"]);


echo "id_civico: ". $_POST["id_civico"];
echo "Latitudine: ". $_POST["lat"];

echo "<br>";

if ($_POST["id_civico"]!=''){
 	$query_civico= 'SELECT st_transform (geom,4326) as geom FROM geodb.civici where id='.$_POST["id_civico"].';';
 	echo $query_civico;
 	echo "<br>";
 	// se ci fossero problemi con il valore 'geom' controlla l record corrispondente nella tabella geodb.m_tables, 
	// che gestisce il trasferimento dati da Oracle a postgis
 	$result_civico=pg_query($conn, $query_civico);
	while($rc = pg_fetch_assoc($result_civico)) {
		$geom="'".$rc["geom"]."'"; // messo fra apici per poi includerlo nella successiva query	
	}
	echo "Civico a rischio:" .$_POST["civrischio"]."<br>";
	if($_POST["civrischio"]=='t') {
		// se ci fossero problemi controlla che la descrizione sia effettivamente 'Civici'
		$query2="SELECT * FROM segnalazioni.tipo_oggetti_rischio WHERE valido='t' AND descrizione='Civici';";
      echo $query2;
      $result2 = pg_query($conn, $query2);
      //echo $query1;    
      while($r2 = pg_fetch_assoc($result2)) { 
      	$tipo_oggetto= $r2['id'];	
 		}
 		$id_oggetto= $_POST["id_civico"];
	}
} else if($_POST["lat"]!='') {
	$geom="ST_GeomFromText('POINT(".$_POST["lon"]." ".$_POST["lat"].")',4326)";
	echo "Oggetto a rischio?:" .$_POST["oggrischio"]."<br>";
	if($_POST["oggrischio"]=='t') {
		// devo cercare l'oggetto più vicino
		// 1 . id tipo oggetto da form
		$tipo_oggetto=$_POST["tipo_oggetto"];
		// 2. id oggetto lo devo cercare come quello più vicino al punto individuato sulla mappa
		$query2="SELECT * FROM segnalazioni.tipo_oggetti_rischio WHERE valido='t' AND id=".$tipo_oggetto.";";
      echo $query2;
      echo "<br>";
      $result2 = pg_query($conn, $query2);
      //echo $query1;    
      while($r2 = pg_fetch_assoc($result2)) { 
      	$campo_identificativo= $r2['campo_identificativo'];
      	$nome_tabella=$r2['nome_tabella'];
 		}
		$query_closest_object="select ".$campo_identificativo." as ident from ".$nome_tabella." order by st_distance(st_transform(geom,4326),".$geom.") limit 1;";
		echo $query_closest_object;
      echo "<br>";
      $result_closest = pg_query($conn, $query_closest_object);
      //echo $query1;    
      while($r_closest = pg_fetch_assoc($result_closest)) { 
      	$id_oggetto= $r_closest['ident'];
 		}
	}
	
	
		
} else {
	echo "ERROR: geometria non definita<br>";
	exit;
}

echo "<br>";
/* INSERT INTO segnalazioni.t_segnalazioni(
            id, data_ora, id_segnalante, descrizione, id_criticita, rischio, 
            id_evento, id_civico, geom, id_municipio, id_operatore, note, 
            tipo_oggetto)
    VALUES (?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, 
            ?);*/

$query="INSERT INTO segnalazioni.t_segnalazioni(id, id_segnalante, descrizione, id_criticita, id_evento, geom, id_operatore";


if ($_POST["rischio"]!=''){
	$query=$query. ", rischio";
}
if ($_POST["id_civico"]!=''){
	$query=$query. ", id_civico";
}
if ($_POST["note_geo"]!=''){
	$query=$query. ", note";
}
/*if ($id_oggetto!=''){
	$query=$query. ", tipo_oggetto";
}*/ 
$query=$query.") VALUES ("; 

//valori obbligatori
$query=$query." ".$id_segnalazione.", ".$id_segnalante.",'".$descrizione."',".$_POST["crit"].",".$_POST["evento"].",".$geom.",'".$operatore."'";

if ($_POST["rischio"]!=''){
	$query=$query. ",'". $_POST["rischio"]."'";
}
if ($_POST["id_civico"]!=''){
	$query=$query. ", ".$_POST["id_civico"];
}
if ($_POST["note_geo"]!=''){
	$query=$query. ",'".$_POST["note_geo"]."'";
}
/*if ($id_oggetto!=''){
	$query=$query. ",". $id_oggetto;
}*/

$query=$query.");";
echo $query;
//exit;
$result = pg_query($conn, $query);
echo "<br>";


// Eventuale oggetto a rischio
if ($id_oggetto!=''){
	$query_oggetto="INSERT INTO segnalazioni.join_oggetto_rischio(
            id_segnalazione, id_tipo_oggetto, id_oggetto)
    VALUES (".$id_segnalazione.", ".$tipo_oggetto.",".$id_oggetto.");";
   $result_oggetto = pg_query($conn, $query_oggetto);
	echo $query_oggetto;
	echo "<br>";	
}

$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('users','".$operatore ."', 'Creazione segnalazione ".$id_segnalazione."');";
$result = pg_query($conn, $query_log);



//$idfascicolo=str_replace('A','',$idfascicolo);
//$idfascicolo=str_replace('B','',$idfascicolo);
echo "<br>";
echo $query_log;

//exit;
header("location: ../dettagli_segnalazione.php?id=".$id_segnalazione);


?>