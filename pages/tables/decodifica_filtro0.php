<?php

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';

$query='SELECT * FROM segnalazioni.tipo_criticita where valido=\'t\';';
$result = pg_query($conn, $query);
#echo $result;
//exit;
//$rows = array();
$filter='';
while($r = pg_fetch_assoc($result)) {
    $name='filter'.$r['id'];
    if ($_POST["$name"]==1) {
        $filter=$filter.'1';
    } else {
         $filter=$filter.'0';
    }
}

header("Location: ../elenco_segnalazioni.php?f=$filter");
echo $filter; 



?>
