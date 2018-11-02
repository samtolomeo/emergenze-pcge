<?php


function filtro($idfilter){
	//echo $idfilter."<br>";
	#############################################################################################################################################
	#                                       CREAZIONE DEL FILTRO
	#leggo un codice binario di tante cifre quante sono le disabilità, per ognuna ho 0 se non voglio visualizzarla e 1 se voglio visualizzarla
	#'00100000000000'
	#echo $idfilter[1];
	#contatore
	$number = strlen($idfilter);
	
	$filter = '';
	
	$check=0; #controllo se c'è almeno un uno
	for ($mul = 0; $mul <= $number; ++$mul) {
	    
	    if ($idfilter[$mul]==1) {
	        $check=1;
	    } 
	} 
	
	if ($check==1) {
	    $filter = $filter . ' WHERE  ' ;    
	}
	
	$check_first=1; // controllo sul primo
	for ($mul = 0; $mul <= $number; ++$mul) {
	    $mul2=$mul+1;
	
	    if ($idfilter[$mul]==1) {
	    		if($check_first==1){
	    			$filter = $filter . ' id_criticita='. $mul2;
	    		} else {
	    			$filter = $filter . ' OR id_criticita='. $mul2;
	    		}
	    		$check_first=0;    
	    } 
	} 
	
	//$filter = $filter . ')';
	//echo $filter;
	return $filter;
	#############################################################################################################################################
}
?>