<?php
//if(isset($_POST['submit']) && $_POST['submit'] == "Download"){
	
	//check tipo 
	// a = segnalazioni eventi aperti (o in chiusura)
	// c = segnalazioni eventi chiusi
	if ($_GET['t']=='a'){
		$segn="segnalazioni.v_segnalazioni_lista";
		$nome="segnalazioni";
	} else if ($_GET['t']=='c'){
		$segn="segnalazioni.v_segnalazioni_lista_eventi_chiusi";
		$nome="segnalazioni_ev_chiusi";
	}
	
	require(explode('emergenze-pcge',getcwd())[0].'emergenze-pcge/conn.php');
	$comando=escapeshellcmd('/usr/bin/ogr2ogr -f "KML" download/'.$nome.'.KML PG:"'.$ogr_conn.'" "'.$segn.'"');
	//echo $comando;
	$error = array();
	unset($error);
	//exit;
	// creo lo shapefile
	$error = shell_exec($comando);
	//echo "<script type='text/javascript'>alert('$error');</script>";
	//creo lo zip
	//$comando2= escapeshellcmd('/usr/bin/zip -9 -y -q download/'.$nome.'.zip download/');
	//$error_zip=shell_exec($comando2);
	//echo $comando2."<br>";
	//echo "Errore zip: ".$error_zip."<br>";
	
	//exit;
	//echo "output=" .$output ;
	if ($error=="") {
		header("Content-Type: application/zip");
		//header("Content-Length: ".filesize("download/segnalazioni".$nome. ".zip"));
		header ("Content-Disposition: attachment; filename=".$nome. ".KML");
		ob_clean();
		flush();
		//ob_end_clean();
		readfile("download/".$nome. ".KML");
	} else {
	$check=1;
	echo "Problema nel download (<a href='mailto:assistenzagis@gter.it'><b>assistenzagis@gter.it</b></a>) segnalando il problema";
	mail ("assistenzagis@gter.it", "Errore download", "errore durante il download dei dati", "From: assistenzagis@gter.it");
	echo "<br><br><br>ogr2ogr output error:\n|".$error."|\n";
	}
	//$pulisco= 'rm '. $nome.'.zip';
	//echo shell_exec($pulisco);

	$pulisco2= 'rm download/'. $nome.'.*';
	shell_exec($pulisco2);
//}
?>
