<?php 

$subtitle="Richiesta generica a n. verde"

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

$page=basename($_SERVER['PHP_SELF']);

if ($profilo_sistema > 8){
	header("location: ./divieto_accesso.php");
}
?>

   <link rel="stylesheet" href="../vendor//leaflet-search/src/leaflet-search.css">
   
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

                <!--div class="col-lg-12">
                    <h1 class="page-header">Titolo pagina</h1>
                </div-->
                <!-- /.col-lg-12 -->
			<form action="segnalazioni/import_richiesta.php" method="POST">
        


       
            <?php 
				if ($contatore_eventi==0){
					echo '<hr> <h2> <font color="red"> <i class="fas fa-ban"></i> ';
					echo 'In questo momento non è possibile inserire nuove segnalazioni in quanto non ci sono eventi attivi.';
					echo '</font></h2><hr>';
				}
				if ($profilo_sistema==8){
					$uo_ins= $descrizione_profilo .' - '.$livello1.'';
				} else {
					$uo_ins= $descrizione_profilo;
				}
				
        		?> 
            <!--Stai inserendo questa segnalazione con il profilo <?php echo $uo_ins;?>-->
			<input type="hidden" id="uo_ins" name="uo_ins" value="<?php echo $uo_ins;?>">

            <div class="row">             
            <h4><i class="fa fa-address-card"></i> Generalità segnalante / evento:</h4> 

				 <div class="col-md-6">

             
            <div class="form-group">
                <label for="nome"> Nome richiedente</label> <font color="red">*</font>
                <input type="text" id="nome" name="nome" class="form-control" required>
                <small>Se non specificato scrivere <i>Anonimo</i></small>
              </div>
            <div class="form-group">
             	<label for="telefono"> Telefono </label>
                <input type="text" name="telefono" class="form-control" >
                <small>Non è un dato obbligatorio, ma è fortemente consigliato avere un recapito telefonico del segnalante.</small>
            </div>

            </div>
            
            <div class="col-md-6">
            <div class="form-group">
            <label for="note_segnalante"> Note segnalante </label>
             	<textarea class="form-control" rows="3" name="note_segnalante" id="note_segnalante"></textarea>
            </div>
            
            </div>
            </div>
            <div class="row">
            <div class="form-group col-md-6">
              <label for="tipo_segn">Tipo segnalante:</label> <font color="red">*</font>
                            <select class="form-control" name="tipo_segn" id="tipo_segn" required="" >
                            <option name="tipo_segn" value="" > Specifica una tipologia segnalante </option>
            <?php            
            $query2="SELECT * FROM segnalazioni.tipo_segnalanti WHERE valido='t';";
            echo $query2;
	        $result2 = pg_query($conn, $query2);
            //echo $query1;    
            while($r2 = pg_fetch_assoc($result2)) { 
            ?>    
                    <option name="tipo_segn" value="<?php echo $r2['id'];?>" ><?php echo $r2['descrizione'];?></option>
             <?php } ?>

             </select>            
             </div>
               <div class="form-group col-md-6">
                <label for="altro"> Specifica altro...</label>
                <input type="text" id="altro" name="altro" class="form-control" disabled="">
              </div>
            </div>
            
            
				<div class="row">             
            <div class="form-group col-md-12">
            <label for="nome"> Evento</label> <font color="red">*</font>  
 				<?php 
           $len=count($eventi_attivi);	               
				                
				if($len==1) {   
			   ?>


                <select readonly="" class="form-control"  name="evento" required>
                 
                    <?php 
                     for ($i=0;$i<$len;$i++){
                      
                        echo '<option name="evento" value="'.$tipo_eventi_attivi[0][0].'">'. $tipo_eventi_attivi[0][1].' (id='.$tipo_eventi_attivi[0][0].')</option>';
                      }
                    ?>
                  </select>
                                  <small id="eventohelp" class="form-text text-muted">Un solo evento attivo (per trasparenza lo mostriamo ma possiamo anche decidere di non farlo).</small>
             
            <?php } else {
            	?>

                  <select class="form-control"  name="evento" required>
                     <option value=''>Seleziona un evento tra quelli attivi </option>
                    <?php 
                     for ($i=0;$i<$len;$i++){
                      
                        echo '<option name="evento" value="'.$tipo_eventi_attivi[$i][0].'">'. $tipo_eventi_attivi[$i][1].' (id='.$tipo_eventi_attivi[$i][0].')</option>';
                      }
                    ?>
                  </select>

            	<?php
            	}
            	?>
              
            </div>
            
             </div>
             <hr>
            <div class="row"> 

            <h4><i class="fa fa-tasks"></i> Richiesta:</h4> 
            
             <!--div class="form-group col-md-6">
              <label for="naz">Tipo criticità:</label> <font color="red">*</font>
                            <select class="form-control" name="crit" id="crit" required="">
                            <option name="crit" value="" > ... </option>
            <?php            
            $query2="SELECT * FROM segnalazioni.tipo_criticita WHERE valido='t' ORDER BY descrizione;";
            echo $query2;
	        $result2 = pg_query($conn, $query2);
            //echo $query1;    
            while($r2 = pg_fetch_assoc($result2)) { 
            ?>    
                    <option name="crit" value="<?php echo $r2['id'];?>" ><?php echo $r2['descrizione'];?></option>
             <?php } ?>

             </select>            
             </div-->
             
             
             
      
             
             
             
            <div class="form-group col-md-12">
                <label for="descrizione"> Descrizione richiesta</label> <font color="red">*</font>
                <textarea class="form-control" rows="5" name="descrizione" id="descrizione"></textarea>
             </div>

				</div> 
				
				
            


            <button  type="submit" class="btn btn-primary">Registra richiesta</button>
            </div>
            <!-- /.row -->
            

            </form>                
                
                
                
                
                

            <br><br>
            <div class="row">

            </div>
            <!-- /.row -->
    </div>
    <!-- /#wrapper -->

<?php 

require('./footer.php');

require('./req_bottom.php');

require('./mappa_georef.php');

?>

		

<script type="text/javascript" >

// con questa parte scritta in JQuery si evita che 
// l'uso del tasto enter abbia effetto sul submit del form

$(document).on("keydown", ":input:not(textarea)", function(event) {
    if (event.key == "Enter") {
        event.preventDefault();
    }
});

</script>



    

</body>

</html>
