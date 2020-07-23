
<?php
$check_turni=0;
// qua va messo un ciclo su tabelle
//$table='t_coordinamento';


$array_monodimensionale = array('t_coordinamento', 't_monitoraggio_meteo', 't_operatore_anpas', 't_operatore_nverde', 't_operatore_volontari', 't_presidio_territoriale', 't_tecnico_pc');



foreach ($array_monodimensionale as $table) {
	echo "<br>";
	echo $table;
	$condizione="matricola_cf='".$cf."') and 
	(
	(data_start < '".$data_fine."' and data_start > '".$data_inizio."') OR
	(data_end < '".$data_fine."' and data_end > '".$data_inizio."') OR
	(data_start < '".$data_inizio."' and data_end > '".$data_fine."')";

	$query= "select matricola_cf
	from report.".$table."
	where 
	(".$condizione.");";
	$result = pg_query($conn, $query);
	echo "<br>";
	//echo $query;
	while($r = pg_fetch_assoc($result)) {
		$check_turni=1;
		echo "Sono dentro<br>";
		$query2="update report.".$table." SET warning_turno='t' where (".$condizione.");";
		echo $query2;
		$result2 = pg_query($conn, $query2);
	}
}

echo "<br>Check_turni=".$check_turni."<br>";
if($check_turni==1){
	$wt='t';
} else {
	$wt='f';
}
//exit;
?>