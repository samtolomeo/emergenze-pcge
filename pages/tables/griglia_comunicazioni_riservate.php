<?php
session_start();
//require('../validate_input.php');
include explode('emergenze-pcge',getcwd())[0].'emergenze-pcge/conn.php';

//require('../check_evento.php');
$filtro_from='';
$filtro_to='';

// Filtro per tipologia di criticità
$getfiltri=pg_escape_string($_GET["f"]);
$filtro_evento_attivo=pg_escape_string($_GET["a"]);
$filtro_municipio=pg_escape_string($_GET["m"]);
$filtro_from=pg_escape_string($_GET["from"]);
$filtro_to=pg_escape_string($_GET["to"]);
$resp=pg_escape_string($_GET["r"]);

//echo $getfiltri;

if ($filtro_from!='' or $filtro_to!=''){
	$filtro= ' WHERE ';
}
if ($filtro_from!=''){
	$filtro= $filtro." data_ora_stato > $1";;
}
if ($filtro_from!='' and $filtro_to!=''){
	$filtro= $filtro.' AND ';
}
if ($filtro_to!=''){
	$filtro= $filtro." data_ora_stato < $2";;
}

if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	//$query="SELECT id, id as id2, data_ora, descrizione, criticita, 
    //   rischio, id_evento, tipo_evento, 
    //   note, id_lavorazione, in_lavorazione, localizzazione, nome_munic, st_x(geom) as lon, st_y(geom) as lat FROM segnalazioni.v_segnalazioni_lista ".$filter[0]." ".$filter_r.";";
    
	$query= "select 
		'segnalazione' as tipo,
		c.id_segnalazione as id,
		c.testo,
		to_char(c.data_ora_stato, 'YYYY/MM/DD HH24:MI'::text) as data_ora_stato,
		case 
		when c.allegato is not null then 'y' end
		as allegato
		from segnalazioni.t_comunicazioni_segnalazioni_riservate c
		LEFT JOIN 
		(SELECT min(id_segnalazione) as id, id_segnalazione_in_lavorazione 
		FROM segnalazioni.join_segnalazioni_in_lavorazione GROUP BY id_segnalazione_in_lavorazione) 
		as s ON s.id_segnalazione_in_lavorazione=c.id_segnalazione
		 ".$filtro." ORDER BY data_ora_stato desc;";
	
	
    //echo $query."<br>";
	//$result = pg_query($conn, $query);
	// imposto i required nel form del filtro data per evitare che uno dei 2 sia nullo
	$result = pg_prepare($conn,"myquery0", $query);
	if ($filtro_from!='' and $filtro_to!=''){
		$result = pg_execute($conn,"myquery0", array($filtro_from, $filtro_to));
	/*} else if ($filtro_from!='' and $filtro_to =='' ){
		$result = pg_execute($conn,"myquery0", array($filtro_from));
	} else if ($filtro_to!='' and $filtro_from ==''  ){
		$result = pg_execute($conn,"myquery0", array($filtro_to));*/
	} else {
		$result = pg_execute($conn,"myquery0", array());
	} 
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
		echo $query;
		echo "<br>[{\"NOTE\":'No data'}]";
	}
}

?>


