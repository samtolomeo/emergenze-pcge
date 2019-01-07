<?php

session_start();

//echo $_SESSION['user'];

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';


echo "<h2> La gestione degli incarichi e' attualmente in fase di test and debug. Ci scusiamo per il disagio</h2>";


//$id=$_GET["id"];
$id=str_replace("'", "", $_GET['id']); //sopralluogo


$id_lavorazione=$_POST["id_lavorazione"];



$note= str_replace("'", "''", $_POST["note"]);
$uo=$_POST["uo"];
$id_evento=$_POST["id_evento"];


echo "sopralluogo:".$id. "<br>";
echo "Note:".$note. "<br>";

//exit;



// per prima cosa verifico che il file sia stato effettivamente caricato
if (!isset($_FILES['userfile']) || !is_uploaded_file($_FILES['userfile']['tmp_name'])) {
  echo 'Non hai inviato nessun file...';    
} else {

	//percorso della cartella dove mettere i file caricati dagli utenti


	$uploaddir0="../../../emergenze_uploads/";

	$uploaddir1= $uploaddir0. "e_".$id_evento."/";

	if (file_exists($uploaddir1)) {
		echo "The file $uploaddir1 exists <br>";
	} else {
		echo "The file $uploaddir1 does not exist <br>";
		$crea_folder="mkdir ".$uploaddir1;
		exec($crea_folder);
	}

	$uploaddir= $uploaddir1. "s_".$id."/";

	if (file_exists($uploaddir)) {
		echo "The file $uploaddir exists <br>";
	} else {
		echo "The file $uploaddir does not exist <br>";
		$crea_folder="mkdir ".$uploaddir;
		exec($crea_folder);
	}

	//Recupero il percorso temporaneo del file
	$userfile_tmp = $_FILES['userfile']['tmp_name'];

	//recupero il nome originale del file caricato e tolgo gli spazi
	//$userfile_name = $_FILES['userfile']['name'];
	$userfile_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES['userfile']["name"]));


	$datafile=date("YmdHis");
	$allegato=$uploaddir .$datafile."_". $userfile_name;

	echo $allegato."<br>";

	//copio il file dalla sua posizione temporanea alla mia cartella upload
	if (move_uploaded_file($userfile_tmp, $allegato)) {
	  //Se l'operazione è andata a buon fine...
	  echo 'File inviato con successo.';
	}else{
	  //Se l'operazione è fallta...
	  echo 'Upload NON valido!'; 
	}


	$allegato=str_replace("../../../", "", $allegato); //allegato database
}



//exit;





$query= "INSERT INTO segnalazioni.t_comunicazioni_sopralluoghi(id_sopralluogo, testo";
if ($allegato!=''){
	$query= $query . ", allegato";
}
$query= $query .")VALUES (".$id.", '".$note."'";
if ($allegato!=''){
	$query= $query . ",'". $allegato."'";
}
$query= $query .");";


echo $query."<br>";
//exit;
$result=pg_query($conn, $query);
echo "Result:". $result."<br>";



$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('segnalazioni','".$operatore ."', 'Inviata comunicazione a PC (sopralluogo ".$id.")');";
echo $query_log."<br>";
$result = pg_query($conn, $query_log);


echo "Result:". $result."<br>";



//exit;
header("location: ../dettagli_sopralluogo.php?id=".$id);


?>