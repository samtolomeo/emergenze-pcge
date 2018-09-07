<?php

$check_evento=0;
//require('/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php');

$query1="SELECT * From \"eventi\".\"t_eventi\" WHERE valido='TRUE';";
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



?>       