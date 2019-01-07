<?php

if ($id_profilo==3){
	echo "<h4><br><b>Responsabile</b>: Centrale PC";
} else if($id_profilo==4) {
	echo "<h4><br><b>Responsabile</b>: Centrale COA";
} else if($id_profilo==5) {
	echo "<h4><br><b>Responsabile</b>: Municipio";
} else if($id_profilo==6) {
	echo "<h4><br><b>Responsabile</b>: Distretto";
}

//echo $check_operatore;
if ($check_operatore==1){
	echo ' ( <i class="fas fa-user-check" style="color:#5fba7d"></i> )';
}


?>