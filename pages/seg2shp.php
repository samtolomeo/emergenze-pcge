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
	
	
	//$message = "wrong answer";
	//echo "<script type='text/javascript'>alert('$message');</script>";
	
	require(explode('emergenze-pcge',getcwd())[0].'emergenze-pcge/conn.php');
	$comando=escapeshellcmd('/usr/bin/ogr2ogr -f "ESRI Shapefile" download/'.$nome.'.shp PG:"'.$ogr_conn.'" "'.$segn.'"');
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

	// Get real path for our folder
	$rootPath = realpath('download');

	// Initialize archive object
	$zip = new ZipArchive();
	$zip->open('download/'.$nome.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

	// Create recursive directory iterator
	/** @var SplFileInfo[] $files */
	$files = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($rootPath),
		RecursiveIteratorIterator::LEAVES_ONLY
	);

	foreach ($files as $name => $file)
	{
		// Skip directories (they would be added automatically)
		if (!$file->isDir())
		{
			// Get real and relative path for current file
			$filePath = $file->getRealPath();
			echo $filePath;
			$relativePath = substr($filePath, strlen($rootPath) + 1);

			// Add current file to archive
			$zip->addFile($filePath, $relativePath);
		}
	}

	// Zip archive will be created only after closing object
	$zip->close();
	//exit;
	//echo "output=" .$output ;
	if ($error=="") {
		
		header("Content-Type: application/zip");
		//header("Content-Length: ".filesize("download/segnalazioni".$nome. ".zip"));
		header ("Content-Disposition: attachment; filename=".$nome. ".zip");
		ob_clean();
		flush();
		//ob_end_clean();
		readfile("download/".$nome. ".zip");
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

	<!--form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<button id="saveForm" class="btn btn-success" type="submit" name="submit" value="Download" /> 
		<i class="fa fa-download"></i> Download Shapefile
		</button>			
	</form-->

<?php

?>

