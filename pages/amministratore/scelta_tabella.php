<?php


$str= $_POST["table"];


$table0 = explode(".", $str);

$schema=$table0[0];

$table=$table0[1];


//echo $schema;
//echo "<br>";
//echo $table;


// redirect verso pagina interna
header("location: ../elenco_amm.php?s=".$schema."&t=".$table."");


?>