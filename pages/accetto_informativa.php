<?php

session_start();

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';


$cf=$_GET['id'];

$query="UPDATE users.utenti_sistema SET privacy='t' WHERE matricola_cf='".$cf."';";

$result = pg_query($conn, $query);

echo $query;

//exit;

header('Location: ' . $_SERVER['HTTP_REFERER']);


?>