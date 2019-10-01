<?php
session_start();
include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';

//require('../check_evento.php');

// Filtro per tipologia di criticità
$getfiltri=$_GET["f"];
//echo $getfiltri;

require('./filtri_segnalazioni.php'); //contain the function filtro used in the following line
$filter=filtro($getfiltri);



if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	$query="SELECT p.id_stato_sopralluogo, p.id_evento, p.descrizione, p.time_preview, p.time_start,p.time_stop, 
		p.id, p.id_segnalazione, s.componenti, s.nome From segnalazioni.v_sopralluoghi_last_update p
		left join users.v_squadre s ON s.id=p.id_squadra where id_stato_sopralluogo < 3 ".$filter." ;";
    
   //echo $query;
	$result = pg_query($conn, $query);
	#echo $query;
	#exit;
	$rows = array();
	while($r = pg_fetch_assoc($result)) {
    		$rows[] = $r;
    		//$rows[] = $rows[]. "<a href='puntimodifica.php?id=" . $r["NAME"] . "'>edit <img src='../../famfamfam_silk_icons_v013/icons/database_edit.png' width='16' height='16' alt='' /> </a>";
	}
	pg_close($conn);
	#echo $rows ;
	if (empty($rows)==FALSE){
		//print $rows;
		print json_encode(array_values(pg_fetch_all($result)));
	} else {
		echo "[{\"NOTE\":'No data'}]";
	}
}

?>


