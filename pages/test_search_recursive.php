<?php
//echo "Ricerca del file<br>";
 

$path = realpath('../../bollettini/');
echo $path;
echo "<br>";
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
{
	$bollettino='vigilanza_31217.pdf';
	$len=strlen($bollettino)*-1;
	//echo $bollettino;
	//echo "<br>";
	//echo $len;
	//echo "<br>";
	//echo substr($filename, -19);
	//echo "<br>";
	if (substr($filename, $len)==$bollettino){
		echo "$filename</br>";
		echo substr($filename, -19);
		echo "<br>";
	}

}
?>