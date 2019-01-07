<?php


session_start();

//echo $_SESSION['user'];

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';


$id_sopralluogo= $_GET['id'];
$id_lavorazione= $_GET['l'];
$id_squadra=$_POST['uo'];
$id_squadra_old=$_POST['id_squadra_old'];
$squadra_old=$_POST['uo_old'];

echo "<br>Id sopralluogo:".$id_sopralluogo;
echo "<br>Id lavorazione:".$id_lavorazione;
echo "<br>Id_squadra_nuovo:".$id_squadra;
echo "<br>Id_squadra_old:".$id_squadra_old;
echo "<br>Descrizione squadra old:".$squadra_old;


echo "<br>Attualmente in lavorazione.. ci scusiamo per il disagio.<br>";
//exit;


$query="UPDATE segnalazioni.t_sopralluoghi_richiesta_cambi SET eseguito=null WHERE id_sopralluogo=".$id_sopralluogo." and eseguito = 'f'; ";
echo $query."<br>";
//exit;
$result=pg_query($conn, $query);


$query="UPDATE segnalazioni.join_sopralluoghi_squadra SET valido=null, data_ora_cambio=now() WHERE id_sopralluogo=".$id_sopralluogo." and valido='t' and id_squadra=".$id_squadra_old."; ";
echo $query."<br>";
//exit;
$result=pg_query($conn, $query);


/*$check_already_exist=0;
$query="SELECT * FROM segnalazioni.join_sopralluoghi_squadra WHERE id_sopralluogo=".$id_sopralluogo." and id_squadra=".$id_squadra."; ";
$result=pg_query($conn, $query);
while($r = pg_fetch_assoc($result)) {
	$check_already_exist=1;
}*/


/*if ($check_already_exist==1){
	$query="UPDATE segnalazioni.join_sopralluoghi_squadra SET valido='true' WHERE id_sopralluogo=".$id_sopralluogo." and id_squadra=".$id_squadra."; ";
	$result=pg_query($conn, $query);
	echo $query."<br>";
echo $query."<br>";
} else {*/
	$query="INSERT INTO segnalazioni.join_sopralluoghi_squadra (id_sopralluogo, id_squadra) VALUES (".$id_sopralluogo.",".$id_squadra."); ";
	$result=pg_query($conn, $query);
	echo $query."<br>";
//}


$query="UPDATE users.t_squadre SET id_stato=1 WHERE id=".$id_squadra.";";
echo $query;
//exit;
$result=pg_query($conn, $query);





//exit;


$query= "INSERT INTO segnalazioni.t_comunicazioni_sopralluoghi(id_sopralluogo, testo";

$query= $query .")VALUES (".$id_sopralluogo.", 'Cambio squadra in corso'" ;

$query= $query .");";


echo $query."<br>";
//exit;
$result=pg_query($conn, $query);
echo "Result:". $result."<br>";





$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('sopralluoghi','".$operatore ."', 'Cambio squadra per sopralluogo ".$id_sopralluogo." effettuato');";
echo $query_log."<br>";
$result = pg_query($conn, $query_log);


//exit;


header("location: ../dettagli_sopralluogo.php?id=".$id_sopralluogo);




?>