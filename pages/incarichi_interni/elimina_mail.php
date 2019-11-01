<?php

session_start();

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';

$uo=$_GET["cod"];
$mail=$_GET["mail"];


echo "<br>";

$query="DELETE FROM users.t_mail_incarichi WHERE cod='".$uo."' AND mail='".$mail."';";

echo $query;
//exit;
$result = pg_query($conn, $query);
echo "<br>";


$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('users','".$_SESSION["operatore"] ."', 'Elimina mail ".$mail." dall'Unità Operativa ".$uo."');";
$result = pg_query($conn, $query_log);
echo "<br>";
echo $query_log;

//exit;
header("location: ../edit_mail_uo.php?id=".$uo);


?>