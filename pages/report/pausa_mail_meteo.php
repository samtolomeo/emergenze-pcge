<?php

session_start();

echo $_SESSION['user']. "<br>";

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';


$id=$_GET['id'];



$query= "UPDATE users.t_mail_meteo SET valido = 'f' ";
$query=$query."where id=".$id.";";

echo $query;
//exit;
$result=pg_query($conn, $query);


$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('users','".$_SESSION['user']."', 'Mail ".$id." per il monitoraggio meteo disattivata');";
$result = pg_query($conn, $query_log);






//exit;
header("location: ../lista_mail_meteo.php");


?>
