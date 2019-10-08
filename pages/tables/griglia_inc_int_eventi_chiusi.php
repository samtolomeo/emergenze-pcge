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
	$query="SELECT id_stato_incarico, descrizione_stato, descrizione, id_evento, time_start, 
	time_preview, time_stop, id, id_segnalazione From segnalazioni.v_incarichi_interni_eventi_chiusi_last_update ".$filter." 
	UNION SELECT id_stato_incarico, descrizione, descrizione_stato, id_evento, time_start, 
	time_preview, time_stop, id, id_segnalazione From segnalazioni.v_incarichi_interni_last_update 
	where id_stato_incarico in (3,4) ".$filter." ORDER BY id_evento desc;";
    
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


