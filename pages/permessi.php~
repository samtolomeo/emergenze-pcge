<?php 

$check_cf=0;
$check_matr=0;

$id=$_GET["id"];

if(strlen($id)==16) {
	$check_cf=1;
} else {
	$check_matr=1;
}

if($check_cf==1) {
	$subtitle="Gestione permessi utente CF ".str_replace("'", "", $id);
} else {
	$subtitle="Gestione permessi matricola ".str_replace("'", "", $id);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="roberto" >

    <title>Gestione emergenze</title>
<?php 
require('./req.php');

require('/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php');

require('./check_evento.php');
?>
    
</head>

<body>

    <div id="wrapper">

        <?php 
            require('./navbar_up.php')
        ?>  
        <?php 
            require('./navbar_left.php')
        ?> 
            

        <div id="page-wrapper">
             <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Gestione permessi utente </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            
            <br><br>
            <div class="row">
            
            <?php
            	$check_profilo=0;
            	$query="SELECT * From varie.v_dipendenti where matricola=".$id.";"; 
               $result = pg_query($conn, $query);
	            while($r = pg_fetch_assoc($result)) {
	            	echo '<div class="col-6 col-sm-6">';
	            	echo '<h4><i class="fa fa-address-book"></i> Anagrafica dipendente</h4>';
	            	echo "<b>Matricola</b>:".$r['matricola']. "<br>";
               	echo "<b>Cognome</b>:".$r['cognome']. "<br>";
               	echo "<b>Nome</b>:".$r['nome']. "<br>";
               	echo '</div>';
               	echo '<div class="col-6 col-sm-6">';
               	echo '<h4><i class="fas fa-project-diagram"></i> Inquadramento</h4>';
	            	echo "<b>Direzione (area)</b>:".$r['direzione_area']. "<br>";
               	echo "<b>Settore</b>:".$r['settore']. "<br>";
               	echo "<b>Ufficio</b>:".$r['ufficio']. "<br>";
               	echo '</div>';
               	$profilo=$r['id_profilo'];
               }
               if ($profilo!=''){
               	$check_profilo=1;
               }
               
            ?>

            </div>
            <hr>
            <div class="row">
            
            <?php
            	if ($check_profilo==1){
	            	$query="SELECT * From users.profili_utilizzatore where id=".$profilo.";";
	            	//echo $query; 
	               $result = pg_query($conn, $query);
		            while($r = pg_fetch_assoc($result)) {
		            	echo '<br><b>Profilo</b>: '. $r['descrizione'];
		            }
		            
		            $query="SELECT * From users.utenti_sistema where matricola_cf=".$id.";";
	            	//echo $query; 
	               $result = pg_query($conn, $query);
		            while($r = pg_fetch_assoc($result)) {
		            	$valido = $r['valido'];
		            	//echo $valido;
		            } 
		            
		            if ($valido=='t'){
		            	echo '<br> <br><a class="btn btn-warning" href="./permessi/permessi_sospendi.php?matr='.$id.'"><i class="fas fa-pause"></i> Sospendi </a>';
		            } else {
		            	echo ' (profilo sospeso)<br> <br><a class="btn btn-success" href="./permessi/permessi_riprendi.php?matr='.$id.'"><i class="fas fa-play"></i> Ri-attiva </a>';
		            }
		         } else {
		          	echo "Attualmente l'utente non ha particolari profili impostati. ";
		          	echo 'Potrà solo accedere al form semplificato di inserimento segnalazioni da numero verde.';
		         } 
	            
	            
            ?>

            </div>
            <hr>
            </b>
            <div class="row">
            <form action="permessi/permessi_insert.php" method="POST">
            <!-- Devo passare al php che gestisce l'aggiornamento permessi anche la matricola con un campo nascosto-->
            <input type="hidden" name="matr" id="hiddenField" value="<?php echo $id ?>" />
            
            <div class="form-group col-lg-12">
            <label for="profilo"> Scegli il profilo </label> <font color="red">*</font><br>
            <?php
            	
            	$query="SELECT * From users.profili_utilizzatore order by id;";
               $result = pg_query($conn, $query);
	            while($r = pg_fetch_assoc($result)) {
	            	if($profilo==$r['id']){
	            		echo '<label class="radio"><input type="radio" name="profilo" checked="" value="'.$r['id'].'"> '.$r['id'].' - '.$r['descrizione'].'</label>';
						} else {
	            		echo '<label class="radio"><input type="radio" name="profilo" value="'.$r['id'].'"> '.$r['id'].' - '.$r['descrizione'].'</label>';						
						}


	            }
		       
		       	if($check_profilo==0) {
	            	echo '<label class="radio"><input type="radio" name="profilo" checked="" value="no"> Nessun profilo </label>';
	            } else {
	            	echo '<label class="radio"><input type="radio" name="profilo" value="no"> Nessun profilo </label>';            
	            }
            ?>

            </div>           
            <button type="submit" class="btn btn-primary">Aggiorna permessi</button>
            </form>
            </div>
           
            
            
            <!-- /.row -->
    </div>
    <!-- /#wrapper -->

<?php 

require('./footer.php');

require('./req_bottom.php');


?>


    

</body>

</html>
