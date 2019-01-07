<?php

session_start();

//echo $_SESSION['user'];

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';

$id_squadra=$_GET['s'];

$matricola_cf=$_GET['m'];

$query="DELETE FROM users.t_componenti_squadre 
WHERE matricola_cf= '".$matricola_cf."' AND id_squadra=".$id_squadra.";";
echo $query;
//exit;
$result=pg_query($conn, $query);


$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('users','".$operatore ."', 'Eliminato componente quadra con id: ".$id_squadra."');";
$result = pg_query($conn, $query_log);

//exit;
header("location: ../edit_squadra.php?id=".$id_squadra."");
?>