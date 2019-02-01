<?php
//require('/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php');

$check_evento=0;
//require('/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php');

$query1="SELECT * From \"eventi\".\"t_eventi\" WHERE valido='TRUE' ORDER BY id;";
$result1 = pg_query($conn, $query1);
$contatore_eventi=0;

while($r1 = pg_fetch_assoc($result1)) {
	$check_evento=1; // controllo se evento in corso inizializzato a 1
	$contatore_eventi=$contatore_eventi+1;
	$eventi_attivi[]=$r1["id"];
	$start[]=$r1["data_ora_inizio_evento"];
	$query2="SELECT  b.descrizione From eventi.join_tipo_evento a,eventi.tipo_evento b  WHERE a.id_evento=".$r1["id"]." and a.id_tipo_evento=b.id;";
	//echo $query2;
	$result2 = pg_query($conn, $query2);
	while($r2 = pg_fetch_assoc($result2)) {
		$tipo_eventi_attivi[]=array($r1["id"],$r2["descrizione"]);
	}
	$query3="SELECT  b.nome_munic From eventi.join_municipi a,geodb.municipi b  WHERE a.id_evento=".$r1["id"]." and a.id_municipio::integer=b.codice_mun::integer;";
	//echo $query3;
	$result3 = pg_query($conn, $query3);
	while($r3 = pg_fetch_assoc($result3)) {
		$municipi[]=array($r1["id"],$r3["nome_munic"]);
	}
	
	
}

if($contatore_eventi==0) {
	$preview_eventi="Nessun evento in corso";
} else if ($contatore_eventi==1){
	$preview_eventi="Evento in corso";
} else{
	$preview_eventi="Eventi in corso";
}


$query1="SELECT count(id) as conto FROM eventi.t_eventi WHERE valido is null;";
$result1 = pg_query($conn, $query1);
while($r1 = pg_fetch_assoc($result1)) {
	$contatore_eventi_chiusura=$r1['conto'];
}
// allerta in corso
// RENDI INDIPENDENTI DA COLORI GLI IF


if($contatore_eventi>0) {
	$query="SELECT * FROM eventi.v_allerte WHERE data_ora_inizio_allerta < now() AND data_ora_fine_allerta > now();";
	$contatore_allerte=0;
	$descrizione_allerta='Nessuna allerta';
	$color_allerta='#5cb85c';
	$result = pg_query($conn, $query);
	while($r = pg_fetch_assoc($result)) {
		$contatore_allerte=$contatore_allerte+1;
		if ($descrizione_allerta=='Nessuna allerta' OR $descrizione_allerta=='Gialla'){
			$color_allerta=$r["rgb_hex"];
			$descrizione_allerta = $r["descrizione"];
		} else if($descrizione_allerta=='Rossa') { 
			// se rossa mantengo il colore tale
			$color_allerta='#ff0000';
			$descrizione_allerta = 'Rossa';
		} else if ($descrizione_allerta=='Arancione' AND $r["descrizione"]!= 'Gialla'){ 
			//se arancione prendo il colore dell'altra allerta che leggo a meno che non sia gialla
			$color_allerta=$r["rgb_hex"];
		}
	}	
}

if($contatore_allerte==0) {
	$contatore_allerte="-";
	$preview_allerte="Nessun allerta in corso";
} else if ($contatore_allerte==1){
	$preview_allerte="Allerta in corso";
} else{
	$preview_allerte="Allerte in corso";
}


if($contatore_eventi>0) {
	$query="SELECT * FROM eventi.v_foc WHERE data_ora_inizio_foc < now() AND data_ora_fine_foc > now();";
	$contatore_foc=0;
	$descrizione_foc='-';
	$color_foc='#5cb85c';
	$result = pg_query($conn, $query);
	while($r = pg_fetch_assoc($result)) {
		$contatore_foc=$contatore_foc+1;
		if ($descrizione_foc=='-' OR $descrizione_foc=='Attenzione'){
			$color_foc=$r["rgb_hex"];
			$descrizione_foc = $r["descrizione"];
		} else if($descrizione_foc=='Allarme') { 
			// se rossa mantengo il colore tale
			$color_foc='#ff0000';
			$descrizione_allerta = 'Allarme';
		} else if ($descrizione_foc=='Pre-allarme' AND $r["descrizione"]!= 'Attenzione'){ 
			//se arancione prendo il colore dell'altra allerta che leggo a meno che non sia gialla
			$color_foc=$r["rgb_hex"];
			$descrizione_foc=$r["descrizione"];
		}
	}	
}


$query1="SELECT * From \"eventi\".\"t_eventi\" WHERE valido IS NULL ORDER BY id;";
$result1 = pg_query($conn, $query1);
$contatore_eventi_c=0;
while($r1 = pg_fetch_assoc($result1)) {
	$check_evento_c=1; // controllo se evento in corso inizializzato a 1
	$contatore_eventi_c=$contatore_eventi_c+1;
	$eventi_attivi_c[]=$r1["id"];
	$start_c[]=$r1["data_ora_inizio_evento"];
	$query2="SELECT  b.descrizione From eventi.join_tipo_evento a,eventi.tipo_evento b  WHERE a.id_evento=".$r1["id"]." and a.id_tipo_evento=b.id;";
	//echo "<br>".$query2;
	$result2 = pg_query($conn, $query2);
	while($r2 = pg_fetch_assoc($result2)) {
		$tipo_eventi_c[]=array($r1["id"],$r2["descrizione"]);
	}
	$query3="SELECT  b.nome_munic From eventi.join_municipi a,geodb.municipi b  WHERE a.id_evento=".$r1["id"]." and a.id_municipio::integer=b.codice_mun::integer;";
	//echo "<br>".$query3;
	$result3 = pg_query($conn, $query3);
	while($r3 = pg_fetch_assoc($result3)) {
		$municipi_c[]=array($r1["id"],$r3["nome_munic"]);
	}
	
	
}




# chiamata alla funzione per la raccolta dei request headers 
$headers = getallheaders();
# visualizzazione dei valori dell'array tramite ciclo
foreach ($headers as $name => $content)
{
	# chiamata alla funzione per la raccolta dei request headers 
$headers = getallheaders();
# visualizzazione dei valori dell'array tramite ciclo
foreach ($headers as $name => $content)
{
  //echo "[$name] = $content<br>";
	if ($name=='comge_codicefiscale'){
		$CF=$content;
	}

}
	if ($name=='comge_codicefiscale'){
		$CF=$content;
	}
	

}




//utenti esterni
	$query= "SELECT * FROM users.v_utenti_esterni WHERE cf='".$CF."';";
	$result = pg_query($conn, $query);
	while($r = pg_fetch_assoc($result)) {
		$nome = $r['nome'];
		$cognome = $r['cognome'];
		$codfisc = $r['cf'];
		$matricola_cf=$codfisc;
		$livello1=$r['livello1'];
		$livello2=$r['livello2'];
		$livello3=$r['livello3'];
		
	}

	//dipendenti
	$query= "SELECT * FROM varie.dipendenti WHERE codice_fiscale='".$CF."';";
	$result = pg_query($conn, $query);
	while($r = pg_fetch_assoc($result)) {
		$nome = $r['nome'];
		$cognome = $r['cognome'];
		$matricola = $r['matricola'];
		$matricola_cf=$matricola;
		$livello1=$r['direzione_area'];
		$livello2=$r['settore'];
		$livello3=$r['ufficio'];
	}
	
	
	$_SESSION['user']=$matricola_cf;
	$operatore=$matricola_cf;
	
	
	$query= "SELECT * FROM users.v_utenti_sistema WHERE matricola_cf ='".$matricola_cf."' and valido='t';";
	$result = pg_query($conn, $query);
	while($r = pg_fetch_assoc($result)) {
		$profilo_sistema = $r['id_profilo'];
		$descrizione_profilo = $r['descrizione'];
		$profilo_cod_munic = $r['cod_municipio'];
		$profilo_nome_munic = $r['nome_munic'];
		
	}
	$query= "SELECT * FROM users.v_componenti_squadre WHERE matricola_cf ='".$matricola_cf."';";
	$result = pg_query($conn, $query);
	while($r = pg_fetch_assoc($result)) {
		$id_squadra_operatore = $r['id'];
		$nome_squadra_operatore = $r['nome_squadra'];
	}
	
	//notifiche
	if ($profilo_sistema == 0 and basename($_SERVER['PHP_SELF'])!='divieto_accesso.php'){
		header("location: ./divieto_accesso.php");
	}
	
	//notifiche
	if ($profilo_sistema>0 and $profilo_sistema<=3){
		$profilo_ok=3;
	}
	
	
	// segnalazioni da elaborare (il resto dei conteggi serve solo alla dashboard)
	$query= "SELECT count(id) FROM segnalazioni.v_segnalazioni WHERE in_lavorazione is null;";
	$result = pg_query($conn, $query);
	while($r = pg_fetch_assoc($result)) {
		$segn_limbo = $r['count'];	
	}

	// Conteggi incarichi
	$query= "SELECT  id, descrizione FROM segnalazioni.v_incarichi_last_update where id_stato_incarico=1 and id_profilo='".$profilo_ok."' GROUP BY id,descrizione;";
	//echo $query;
	$result = pg_query($conn, $query);
	$id_i_assegnati_resp=array();
	$descrizione_i_assegnati_resp=array();
	while($r = pg_fetch_assoc($result)) {
		$id_i_assegnati_resp[] = $r['id'];
		$descrizione_i_assegnati_resp[] = $r['descrizione'];
	}
	$i_assegnati_resp = count($id_i_assegnati_resp);


	// Conteggi incarichi interni
	$query= "SELECT  id, descrizione FROM segnalazioni.v_incarichi_interni_last_update where id_stato_incarico=1 and id_profilo='".$profilo_ok."' GROUP BY id,descrizione;";
	//echo $query;
	$result = pg_query($conn, $query);
	$id_ii_assegnati_resp=array();
	$descrizione_ii_assegnati_resp=array();
	while($r = pg_fetch_assoc($result)) {
		$id_ii_assegnati_resp[] = $r['id'];
		$descrizione_ii_assegnati_resp[] = $r['descrizione'];
	}
	$ii_assegnati_resp = count($id_ii_assegnati_resp);


	// Conteggi sopralluoghi
	$query= "SELECT  id, descrizione FROM segnalazioni.v_sopralluoghi_last_update where id_stato_sopralluogo=1 and id_profilo='".$profilo_ok."' GROUP BY id,descrizione;";
	//echo $query;
	$result = pg_query($conn, $query);
	$id_s_assegnati_resp=array();
	$descrizione_s_assegnati_resp=array();
	while($r = pg_fetch_assoc($result)) {
		$id_s_assegnati_resp[] = $r['id'];
		$descrizione_s_assegnati_resp[] = $r['descrizione'];
	}
	$s_assegnati_resp = count($id_s_assegnati_resp);


	// Conteggi provvedimenti cautelari
	$query= "SELECT  id, tipo_provvedimento FROM segnalazioni.v_provvedimenti_cautelari_last_update where id_stato_provvedimenti_cautelari=1 and id_profilo='".$profilo_ok."';";
	
	$result = pg_query($conn, $query);
	$id_pc_assegnati_resp=array();
	$tipo_pc_assegnati_resp=array();
	while($r = pg_fetch_assoc($result)) {
		$id_pc_assegnati_resp[] = $r['id'];
		$tipo_pc_assegnati_resp[] = $r['tipo_provvedimento'];
	}
	$pc_assegnati_resp = count($id_pc_assegnati_resp);
	
	
	$count_resp=$i_assegnati_resp + $ii_assegnati_resp + $s_assegnati_resp + $pc_assegnati_resp;
	
	
	//******************************************************
	//notifiche squadra
	
	
	// Conteggi incarichi
	$query= "SELECT  * FROM users.v_squadre_notifica WHERE id=".$id_squadra_operatore.";";
	
	$result = pg_query($conn, $query);
	$id_ii_assegnati_squadra=array();
	$id_s_assegnati_squadra=array();
	$id_pc_assegnati_squadra=array();
	$descrizione_i_assegnati_squadra=array();
	while($r = pg_fetch_assoc($result)) {
		if($r['id_incarico_interno'] > 0 ) {
			$id_ii_assegnati_squadra[] = $r['id_incarico_interno'];
		}
		if($r['id_sopralluogo'] > 0 ) {
			$id_s_assegnati_squadra[] = $r['id_sopralluogo'];
		}
		if($r['id_pc'] > 0 ) {
			$id_pc_assegnati_squadra[] = $r['id_pc'];
		}
	}
	$ii_assegnati_squadra = count($id_ii_assegnati_squadra);
	$s_assegnati_squadra = count($id_s_assegnati_squadra);
	$pc_assegnati_squadra = count($id_pc_assegnati_squadra);  
	// Conteggi incarichi
	/*$query= "SELECT  id, tipo_provvedimento FROM segnalazioni.v_incarichi_last_update where id_stato_incarichi<=2 and id_squadra=".$id_squadra_operatore.";";
	
	$result = pg_query($conn, $query);
	$id_i_assegnati_squadra=array();
	$descrizione_i_assegnati_squadra=array();
	while($r = pg_fetch_assoc($result)) {
		$id_i_assegnati_squadra[] = $r['id'];
		$descrizione_i_assegnati_squadra[] = $r['descrizione'];
	}
	$i_assegnati_squadra = count($id_i_assegnati_squadra);


	// Conteggi incarichi interni
	$query= "SELECT  id, tipo_provvedimento FROM segnalazioni.v_incarichi_interni_last_update where id_stato_incarichi<=2 and id_squadra=".$id_squadra_operatore.";";
	//echo $query;
	$result = pg_query($conn, $query);
	$id_ii_assegnati_squadra=array();
	$descrizione_ii_assegnati_squadra=array();
	while($r = pg_fetch_assoc($result)) {
		$id_ii_assegnati_squadra[] = $r['id'];
		$descrizione_ii_assegnati_squadra[] = $r['descrizione'];
	}
	$ii_assegnati_squadra = count($id_ii_assegnati_squadra);


	// Conteggi sopralluoghi
	$query= "SELECT  id, tipo_provvedimento FROM segnalazioni.v_sopralluoghi_last_update where id_stato_sopralluoghi<=2 and id_squadra=".$id_squadra_operatore.";";
	
	$result = pg_query($conn, $query);
	$id_s_assegnati_squadra=array();
	$descrizione_s_assegnati_squadra=array();
	while($r = pg_fetch_assoc($result)) {
		$id_s_assegnati_squadra[] = $r['id'];
		$descrizione_s_assegnati_squadra[] = $r['descrizione'];
	}
	$s_assegnati_squadra = count($id_s_assegnati_squadra);


	// Conteggi provvedimenti cautelari
	$query= "SELECT  id, tipo_provvedimento FROM segnalazioni.v_provvedimenti_cautelari_last_update where id_stato_provvedimenti_cautelari<=2 and id_squadra=".$id_squadra_operatore.";";
	
	$result = pg_query($conn, $query);
	$id_pc_assegnati_squadra=array();
	$tipo_pc_assegnati_squadra=array();
	while($r = pg_fetch_assoc($result)) {
		$id_pc_assegnati_squadra[] = $r['id'];
		$tipo_pc_assegnati_squadra[] = $r['tipo_provvedimento'];
	}
	$pc_assegnati_squadra = count($id_pc_assegnati_squadra);*/
	
	
	$count_squadra = $ii_assegnati_squadra + $s_assegnati_squadrap + $pc_assegnati_squadra;
?>       