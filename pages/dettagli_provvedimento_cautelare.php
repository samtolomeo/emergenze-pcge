<?php 
// Start the session
session_start();
//$_SESSION['user']="MRZRRT84B01D969U";

$id=$_GET["id"];
$subtitle="Dettagli Provvedimento Cautelare n. ".$id;


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


$query_evento_aperto="SELECT s.id,
       e.valido 
		FROM segnalazioni.t_provvedimenti_cautelari s
		JOIN eventi.t_eventi e on e.id=s.id_evento
		WHERE s.id=".$id.";";

$result_e=pg_query($conn, $query_evento_aperto);
while($r_e = pg_fetch_assoc($result_e)) {
	if($r_e['valido']=='f') {
		$table='v_provvedimenti_cautelari_eventi_chiusi';
		//echo "false";
	} else {
		$table='v_provvedimenti_cautelari';
		//echo "true";
	}
}


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
            <!--div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Titolo pagina</h1>
                </div>
            </div-->
            <!-- /.row -->
            
            <br><br>
            <div class="row">
            <div class="col-md-6">
				<?php
				$query= "SELECT *, st_x(geom_inizio) as lon , st_y(geom_inizio) as lat FROM segnalazioni.".$table." WHERE id=".$id." ORDER BY data_ora_stato DESC LIMIT 1;";
				//echo $query
				$check_punto=0;
				$result=pg_query($conn, $query);
				while($r = pg_fetch_assoc($result)) {
					
					//echo $profilo_sistema;
               //operatore 
               // 0 : no permessi 
               // 1 : permessi centrale PC
               // 2 : permessi squadra
               
               //$check_operatore=0;
					$id_squadra=$r['id_squadra'];
               $id_profilo=$r['id_profilo'];
					require('./check_operatore.php');	
					?>            
            	
               <h4><br><b>Unità operativa</b>: <?php echo $r['descrizione_uo'];?>
               <?php
               if ($check_squadra==1){
						echo ' ( <i class="fas fa-user-check" style="color:#5fba7d"></i> )';
					}
					?>
               </h4>
               <?php
               
              
               if ($r['id_profilo']==3){
						echo "<h4><br><b>Responsabile</b>: Centrale PC";
					} else if($r['id_profilo']==4) {
						echo "<h4><br><b>Responsabile</b>: Centrale COA";
					} else if($r['id_profilo']==5) {
						echo "<h4><br><b>Responsabile</b>: Municipio";
					} else if($r['id_profilo']==6) {
						echo "<h4><br><b>Responsabile</b>: Distretto";
					}
					//echo $check_operatore;
					if ($check_operatore==1){
						echo ' ( <i class="fas fa-user-check" style="color:#5fba7d"></i> )';
					}
					?>
					</h4>
               <h4><br><b>Tipo provvedimento</b>: <?php echo $r['tipo_provvedimento']; ?></h4>
			   
			   <?php 
			   //echo $r['id_civico_inizio'];
			   if ($r['id_civico_inizio']!='') {
				   $query_civico="SELECT * FROM geodb.civici WHERE id=".$r['id_civico_inizio'].";"; 
				   $result_c=pg_query($conn, $query_civico);
					while($r_c = pg_fetch_assoc($result_c)) {
						echo "<h4><br><b>Tratto strada</b>: ",$r_c['desvia'].", da civico ".$r_c['testo']." ";
					}
				    $query_civico="SELECT * FROM geodb.civici WHERE id=".$r['id_civico_fine'].";"; 
				   $result_c=pg_query($conn, $query_civico);
					while($r_c = pg_fetch_assoc($result_c)) {
						echo " a civico ".$r_c['testo']." ";
					}
					//echo $query_civico;
			   } else if ($r['desc_via']){
				   $query_via="SELECT * FROM geodb.v_vie_unite WHERE codvia='".$r['codvia']."';"; 
				   //echo $query_via;
				   $result_v=pg_query($conn, $query_via);
					while($r_v = pg_fetch_assoc($result_v)) {
						echo "<h4><br><b>Tratto strada</b>: ".$r_v['desvia']." - ",$r['desc_via']."</h4>";
					}
				   
				   
			   }
			   
			   
			   
			   //anagrafe civico
			   if ($r['tipo_oggetto']=='geodb.civici'){
				
				$query_or3="SELECT * FROM geodb.civici WHERE id = ".$r['id_oggetto'].";";
				$result_or3=pg_query($conn, $query_or3);
				while($r_or3 = pg_fetch_assoc($result_or3)) {
					$numciv=ltrim($r_or3["numero"],'0');
					$via=$r_or3["desvia"];
					$lettera=$r_or3["lettera"];	
				}
				//echo "<br><b>Indirizzo</b>: ".$via. ", " .$numciv;
				?>
				<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#anagrafe_civico"><i class="fas fa-address-book"></i> Visualizza anagrafe civico </button>
				<!-- Modal incarico-->
						<div id="anagrafe_civico" class="modal fade" role="dialog">
						  <div class="modal-dialog modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Anagrafe civico di <?php echo $via. " Numero: " .$numciv. " " .$lettera ;?></h4>
							  </div>
							  <div class="modal-body">
							  

								<div id="toolbar">
				            <select class="form-control">
				                <option value="">Esporta i dati visualizzati</option>
				                <option value="all">Esporta tutto (lento)</option>
				                <option value="selected">Esporta solo selezionati</option>
				            </select>
				        </div>
				        
				        <table  id="t_anagrafe_civico" class="table-hover" style="word-break:break-all; word-wrap:break-word; " data-toggle="table" data-url="./tables/griglia_anagrafe_civico.php?id=<?php echo $r['id_oggetto'];?>" data-height="900"  data-show-export="true" data-search="true" data-click-to-select="true" data-pagination="false" data-sidePagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-toolbar="#toolbar">
				        
				        
						<thead>
				
				 			<tr>
			            <th data-field="state" data-checkbox="true"></th>
			             <th data-field="codfisc" data-sortable="false" data-visible="true">CF</th>
			            <th data-field="matricola" data-sortable="false" data-visible="true">Matricola</th>
			            <th data-field="famiglia" data-sortable="false"  data-visible="true">Fam</th>
			            <th data-field="cognome" data-sortable="false"  data-visible="true">Cognome</th>
			            <th data-field="nome" data-sortable="false"  data-visible="true">Nome</th>
			            <th data-field="anni" data-sortable="false"  data-visible="true">Anni</th>
			            <th data-field="sesso" data-sortable="false"  data-visible="true">M/F</th>
			            <th data-field="numint" data-sortable="false"  data-visible="true">Interno</th>
			            <th data-field="scala" data-sortable="false"  data-visible="true">Scala</th>
				    	</tr>
						</thead>
				
				</table>
				
				
				<script>
				    // DA MODIFICARE NELLA PRIMA RIGA L'ID DELLA TABELLA VISUALIZZATA (in questo caso t_volontari)
				    var $table = $('#t_anagrafe_civico');
				    $(function () {
				        $('#toolbar').find('select').change(function () {
				            $table.bootstrapTable('destroy').bootstrapTable({
				                exportDataType: $(this).val()
				            });
				        });
				    })
				</script>

							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
							  </div>
							</div>

						  </div>
						</div>

				<?php 
			   }
			   ?>
			   
               <h4><br><b>Descrizione Provvedimento Cautelare</b>: <?php echo $r['descrizione']; ?></h4>
               <h4><br><b>Data e ora invio provvedimento</b>: <?php echo $r['data_ora_invio']; ?></h4>
               
               <hr>
            	
						
						<?php 
						$lon=$r['lon'];
						$lat=$r['lat'];
						$zoom=16;
            		$id_lavorazione=$r['id_lavorazione'];
            		if ( $id_lavorazione>0){ 
            			$check_segnalazione=1;
            		} else {
            			$check_segnalazione=0;
            		}
					$id_evento=$r['id_evento'];
						echo "<h2>";
						//1;"Inviato ma non ancora preso in carico"
						//2;"Preso in carico"
						//3;"Chiuso"
						//4;"Rifiutato"
						
						$stato_attuale=$r["id_stato_provvedimenti_cautelari"];
						if ($r["id_stato_provvedimenti_cautelari"]==1){
							echo '<i class="fas fa-pause" style="color:orange"></i> ';
						} else if  ($r["id_stato_provvedimenti_cautelari"]==2) {
							if ($r['time_start']!=null) {
								echo '<i class="fas fa-play" style="color:green"></i> ';
							} else {
								echo '<i class="fas fa-play" style="color:orange"></i> ';
							}
						} else if  ($r["id_stato_provvedimenti_cautelari"]==3) {
							echo '<i class="fas fa-check"></i> ';
						} else if  ($r["id_stato_provvedimenti_cautelari"]==4) {
							echo '<i class="fas fa-times-circle"></i> ';
						}
						
						
						
						echo $r['descrizione_stato'];
						if ($r["parziale"]=='t'){
							echo '<br><br><i class="fas fa-battery-quarter"></i>  Presa in carico parziale';
						}
						echo "</h2><hr>";
						if ($r["id_stato_provvedimenti_cautelari"]==1){
						?>
				      <div style="text-align: center;">
				      <?php 
				      	$check_mail=0; //check se ci sono mail a sistema
				      	$query2="SELECT mail FROM users.t_mail_squadre WHERE cod='".$r['id_squadra']."';";
							$result2=pg_query($conn, $query2);
							while($r2 = pg_fetch_assoc($result2)) {
							  $check_mail=1; //check se ci sono mail a sistema
							}
							if($check_mail==1 and $check_operatore==1) {
								//echo $r['id_squadra'];
								echo '<a class="btn btn-info" href="provvedimenti_cautelari/sollecito.php?id='.$id.'&u='.$r['id_squadra'].'"> <i class="fas fa-at"></i> Invia sollecito </a> ';
							
							}
							if ($check_squadra==1 or $check_operatore==1){
				      ?>
				      <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#accetta"><i class="fas fa-thumbs-up"></i> Presa in carico</button>
						<?php } ?>
						<!--button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#rifiuta"><i class="fas fa-thumbs-down"></i> Rifiuta (DEMO)</button-->
						</div>
						
						<!-- Modal accetta-->
						<div id="accetta" class="modal fade" role="dialog">
						  <div class="modal-dialog">
						
						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Prendi in carico</h4>
						      </div>
						      <div class="modal-body">
						      
						
						   <form autocomplete="off" action="provvedimenti_cautelari/accetta.php?id=<?php echo $id; ?>" method="POST">
							<input type="hidden" name="uo" value="<?php echo $r['descrizione_uo'];?>" />
							<input type="hidden" name="squadra" value="<?php echo $r['id_squadra'];?>" />
							<input type="hidden" name="id_lavorazione" value="<?php echo $r['id_lavorazione'];?>" />
							<!--input type="hidden" name="uo" value="<?php echo $r['descrizione_uo'];?>" /-->
								
									 <div class="form-group">
						<label for="data_inizio" >Data prevista per eseguire il provvedimento cautelare (AAAA-MM-GG) </label>  <font color="red">*</font>                 
						<input type="text" class="form-control" name="data_inizio" id="js-date" required>
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-th"></span>
						</div>
					</div> 
					
					<div class="form-group"-->

                <label for="ora_inizio"> Ora inizio:</label> <font color="red">*</font>

              <div class="form-row">
   
   
    				<div class="form-group col-md-6">
                  <select class="form-control"  name="hh_start" required>
                  <option name="hh_start" value="" > Ora </option>
                    <?php 
                      $start_date = 0;
                      $end_date   = 24;
                      for( $j=$start_date; $j<=$end_date; $j++ ) {
                      	if($j<10) {
                        	echo '<option value="0'.$j.'">0'.$j.'</option>';
                        } else {
                        	echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                      }
                    ?>
                  </select>
                  </div>	
                  
      				<div class="form-group col-md-6">
                  <select class="form-control"  name="mm_start" required>
                  <option name="mm_start" value="00" > 00 </option>
                    <?php 
                      $start_date = 0;
                      $end_date   = 59;
                      $incremento = 10; 
                      for( $j=$start_date; $j<=$end_date; $j+=$incremento) {
                      	if($j<10) {
                        	echo '<option value="0'.$j.'">0'.$j.'</option>';
                        } else {
                        	echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                      }
                    ?>
                  </select>
                  </div>                
                  
                </div>  
                </div>
								
					<!--div class="form-group">		
							<div class="radio-inline">
							  <label><input type="radio" name="parziale" value='f' required="">Presa in carico regolare</label>
							</div>
							<div class="radio-inline">
							  <label><input type="radio" name="parziale" value='t'>Presa in carico parziale</label>
							</div>				
						</div-->		
								
						           <div class="form-group">
									    <label for="note">Note</label>
									    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
									  </div>    
						
						
						
						        <button  id="conferma" type="submit" class="btn btn-primary">Prendi in carico</button>
						            </form>
						
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
						      </div>
						    </div>
						
						  </div>
						</div>
						

						<!-- Modal rifiuta-->
						<div id="rifiuta" class="modal fade" role="dialog">
						  <div class="modal-dialog">
						
						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Rifiuta PC</h4>
						      </div>
						      <div class="modal-body">
						      
						
						        <form autocomplete="off" action="provvedimenti_cautelari/rifiuta.php?id=<?php echo $id; ?>" method="POST">
									<input type="hidden" name="uo" value="<?php echo $r['descrizione_uo'];?>" />
									<input type="hidden" name="squadra" value="<?php echo $r['id_squadra'];?>" />
									<input type="hidden" name="id_lavorazione" value="<?php echo $r['id_lavorazione'];?>" />
										 <div class="form-group">
									    <label for="note_rifiuto">Note rifiuto</label>  <font color="red">*</font>
									    <textarea required="" class="form-control" id="note_rifiuto"  name="note_rifiuto" rows="3"></textarea>
									  </div>
						
						
						
						        <button  id="conferma" type="submit" class="btn btn-primary">Rifiuta il pc</button>
						            </form>
						
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
						      </div>
						    </div>
						
						  </div>
						</div>
						
						
						<hr>
						
						<?php
							
							
							
						} else if ($r["id_stato_provvedimenti_cautelari"]==2) {
						?>
							<h4><br><b>Ora prevista per eseguire il provvedimento</b>: <?php echo $r['time_preview']; ?></h4>
							<?php if ($r['time_start']==''){
								if ($check_squadra==1 or $check_operatore==1){
								?>
								<a class="btn btn-success" href="./provvedimenti_cautelari/start.php?id=<?php echo $id;?>"><i class="fas fa-play"></i> La squadra è sul posto </a><br><br>
							<?php 
								}
							} else { ?>
								<h4><br><b>Ora inizio esecuzione del provvedimento</b>: <?php echo $r['time_start']; ?></h4> 
							<?php } 
							 	if ($check_squadra==1 or $check_operatore==1){
							?>
							<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#chiudi"><i class="fas fa-stop"></i> Provvedimento completato</button>
						<?php	
							}
						} else if ($r["id_stato_provvedimenti_cautelari"]==3) {
						?>
							<h4><br><b>Ora prevista per eseguire il provvedimento</b>: <?php echo $r['time_preview']; ?></h4>
							<h4><br><b>Ora inizio esecuzione del provvedimento</b>: 
							<?php 
							if($r['time_start']!=''){
								echo $r['time_start']; 
							} else {
								echo 'n.d (non in corso o avvio non inserito a sistema)';
							}
							?>
							</h4>
							<h4><br><b>Ora chiusura provvedimento cautelare</b>: <?php echo $r['time_stop']; ?></h4><hr>
							<h4><br><b>Note chiusura provvedimento cautelare</b>: <?php echo $r['note_ente']; ?></h4><hr>
						
						<?php	
						} else if ($r["id_stato_provvedimenti_cautelari"]==4) {
						?>	
							<h4><br><b>Note rifiuto provvedimento cautelare</b>: <?php echo $r['note_rifiuto']; ?></h4><hr>
						<?php	
						}
					?>
					
					
					<!-- Modal rifiuta-->
						<div id="chiudi" class="modal fade" role="dialog">
						  <div class="modal-dialog">
						
						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Provvedimento completato</h4>
						      </div>
						      <div class="modal-body">
						      
						
						        <form autocomplete="off" action="provvedimenti_cautelari/chiudi.php?id=<?php echo $id; ?>" method="POST">
									<input type="hidden" name="uo" value="<?php echo $r['descrizione_uo'];?>" />
									<input type="hidden" name="squadra" value="<?php echo $r['id_squadra'];?>" />
									<input type="hidden" name="id_lavorazione" value="<?php echo $r['id_lavorazione'];?>" />
										 <div class="form-group">
									    <label for="note_rifiuto">Note chiusura</label>  <font color="red">*</font>
									    <textarea required="" class="form-control" id="note_rifiuto"  name="note_rifiuto" rows="3"></textarea>
									  </div>
						
						
						
						        <button  id="conferma" type="submit" class="btn btn-primary">Provvedimento completato</button>
						            </form>
						
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
						      </div>
						    </div>
						
						  </div>
						</div>
					
					<?php

					
					}
					//}
					if ($lat==''){
						$check_punto=1;
						$query= "SELECT st_x(st_centroid(geom)) as lon , st_y(st_centroid(geom)) as lat FROM segnalazioni.".$table." WHERE id=".$id." ORDER BY data_ora_stato DESC LIMIT 1;";
						//echo $query;
						$result=pg_query($conn, $query);
						while($r = pg_fetch_assoc($result)) {
							$lon=$r['lon'];
							$lat=$r['lat'];
						}
					}
						
					
					echo "<hr>";
					if ($check_segnalazione==1){
						include 'incarichi/panel_comunicazioni.php';
					} else{
						include 'provvedimenti_cautelari/panel_comunicazioni.php';
					}
					
					if ($stato_attuale<3){ 
					?>
					<div style="text-align: center;">
					<?php 
					if ($check_squadra==1 or $check_operatore==1 ){
					?>
					<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#comunicazione_da_UO"><i class="fas fa-comment"></i> Invia comunicazione a Centrale</button>
					<?php }
					if ($check_operatore==1){ ?>
					<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#comunicazione_a_UO"><i class="fas fa-comment"></i> Invia comunicazione a Squadra</button>
					<?php } ?>
					</div>
					
					<!-- Modal comunicazione da UO-->
						<div id="comunicazione_da_UO" class="modal fade" role="dialog">
						  <div class="modal-dialog">
						
						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Comunicazione a responsabile provvedimento</h4>
						      </div>
						      <div class="modal-body">
						      
						
						        <form autocomplete="off"  enctype="multipart/form-data"  action="provvedimenti_cautelari/comunicazione_da_UO.php?id=<?php echo $id; ?>" method="POST">
									<input type="hidden" name="uo" value="<?php echo $r['descrizione_uo'];?>" />
									<input type="hidden" name="id_lavorazione" value="<?php echo $r['id_lavorazione'];?>" />
									<input type="hidden" name="id_evento" value="<?php echo $id_evento;?>" />
										 <div class="form-group">
									    <label for="note">Testo comunicazione</label>  <font color="red">*</font>
									    <textarea required="" class="form-control" id="note"  name="note" rows="3"></textarea>
									  </div>
									
									<!--	RICORDA	  enctype="multipart/form-data" nella definizione del form    -->
									<div class="form-group">
									   <label for="note">Eventuale allegato</label>
										<input type="file" class="form-control-file" name="userfile" id="userfile">
									</div>
						
						        <button  id="conferma" type="submit" class="btn btn-primary">Invia comunicazione</button>
						            </form>
						
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
						      </div>
						    </div>
						
						  </div>
						</div>
					
					
					<!-- Modal comunicazione a UO-->
						<div id="comunicazione_a_UO"  class="modal fade" role="dialog">
						  <div class="modal-dialog">
						
						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Comunicazione a squadra responsabile provvedimento</h4>
						      </div>
						      <div class="modal-body">
						      
						
						        <form autocomplete="off"  enctype="multipart/form-data" action="provvedimenti_cautelari/comunicazione_a_UO.php?id=<?php echo $id; ?>" method="POST">
									<input type="hidden" name="uo" value="<?php echo $r['id_squadra'];?>" />
									<input type="hidden" name="id_lavorazione" value="<?php echo $r['id_lavorazione'];?>" />
									<input type="hidden" name="id_evento" value="<?php echo $id_evento;?>" />
										 <div class="form-group">
									    <label for="note">Testo comunicazione</label>
									    <textarea required="" class="form-control" id="note"  name="note" rows="3"></textarea>
									  </div>
									  
									<!--	RICORDA	  enctype="multipart/form-data" nella definizione del form    -->
									<div class="form-group">
									   <label for="note">Eventuale allegato</label>
										<input type="file" class="form-control-file" name="userfile" id="userfile">
									</div>
						
						
						        <button  id="conferma" type="submit" class="btn btn-primary">Invia comunicazione e mail</button>
						            </form>
						
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
						      </div>
						    </div>
						
						  </div>
						</div>
					
					
					
					<?php
					} //fine if su $stato_attuale
					
					if ($check_segnalazione==1){
					?>
					
					
					
					
					
					<hr>
					<h3><i class="fas fa-list-ul"></i> Segnalazioni collegate al provvedimento </h3><br>

					<?php
					
					
					// fine $query che verifica lo stato
					$query= "SELECT * FROM segnalazioni.".$table." WHERE id=".$id." and id_stato_provvedimenti_cautelari =".$stato_attuale."  ORDER BY id_segnalazione;";
					
					
					//echo $query
        
					$result=pg_query($conn, $query);
					while($r = pg_fetch_assoc($result)) {
						//echo '<b>Unità operativa</b>: '.$r['descrizione_uo'];
						
						
					?>
						
						
									<div class="panel-group">
									  <div class="panel panel-info">
									    <div class="panel-heading">
									      <h4 class="panel-title">
									        <a data-toggle="collapse" href="#segnalazione_<?php echo $r["id_segnalazione"];?>"><i class="fas fa-map-marker-alt"></i> Segnalazione n. <?php echo $r['id_segnalazione'];?> </a>
									      </h4>
									    </div>
									    <div id="segnalazione_<?php echo $r["id_segnalazione"];?>" class="panel-collapse collapse">
									      <div class="panel-body"-->
										<?php
										if($r['rischio'] =='t') {
											echo '<i class="fas fa-circle fa-1x" style="color:#ff0000"></i> Persona a rischio';
										} else if ($r['rischio'] =='f') {
											echo '<i class="fas fa-circle fa-1x" style="color:#008000"></i> Non ci sono persone a rischio';
										} else {
											echo '<i class="fas fa-circle fa-1x" style="color:#ffd800"></i> Non è specificato se ci siano persone a rischio';
										}
										?>
										<!--h4><i class="fas fa-list-ul"></i> Generalità </h4-->
										<br><b>Descrizione</b>: <?php echo $r['descrizione_segnalazione']; ?>
										<br><b>Tipologia</b>: <?php echo $r['criticita']; ?>
										<br> <a class="btn btn-info" href="./dettagli_segnalazione.php?id=<?php echo $r['id_segnalazione']; ?>" > Vai alla pagina della segnalazione </a>
										<hr>
										<?php
										$id_segnalazione=$r['id_segnalazione'];
										include './segnalazioni/section_oggetto_rischio.php';
										?>
										
							
							
										
									
									
												</div>
									    </div>
									  </div>
									</div>
						
									<a class="btn btn-info" href="dettagli_segnalazione.php?id=<?php echo $r["id_segnalazione"];?>"><i class="fas fa-undo"></i> Torna alla segnalazione <?php echo $r["id_segnalazione"];?></a>
						<br><br>
						<?php
					}
					}
					?>
						
						<br>
						
						<br>
						</div> 
						<div class="col-md-6">
						<h4> <i class="fas fa-map-marked-alt"></i> Mappa </h4>
						<!--div id="map_dettaglio" style="width: 100%; padding-top: 100%;"></div-->
						<div id="map" style="width: 100%; padding-top: 100%;">
						</div>
						
						
						
						<!--div style="width: 100%; padding-top: 100%;"-->
							<!--iframe class="embed-responsive-item" style="width:100%; padding-top:0%; height:600px;" src="./mappa_leaflet.php#16/<?php echo $lat;?>/<?php echo $lon;?>"></iframe-->
						<!--/div-->
						<hr>
						<?php
						include './segnalazioni/section_oggetto_rischio.php';
						
						?>
						</div>
						
						


            </div>
            <!-- /.row -->
    </div>
    <!-- /#wrapper -->

<?php 



require('./req_bottom.php');
$id_segnalazione=$id;

include './mappa_leaflet_embedded.php';	


require('./footer.php');
?>




<script type="text/javascript" >

$('input[type=radio][name=invio]').attr('disabled', true);

(function ($) {
    'use strict';
    
    
    $('[type="radio"][name="risolta"][value="f"]').on('change', function () {
        if ($(this).is(':checked')) {
            $('input[type=radio][name=invio]').removeAttr('disabled');
            return true;
        }
    });
    
	$('[type="checkbox"][id="cat"]').on('change', function () {
        if ($(this).is(':checked')) {
            $('#conferma_chiudi').removeAttr('disabled');
            return true;
        }
        
    });
}(jQuery));





$(document).ready(function() {
    $('#js-date').datepicker({
        format: "yyyy-mm-dd",
        clearBtn: true,
        autoclose: true,
        todayHighlight: true
    });
});


</script>  

</body>

</html>
