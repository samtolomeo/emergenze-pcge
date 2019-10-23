<?php 
// cerco l'oggetto a rischio



$check_or=0;
if (isset($id_lavorazione)){
	$query_or="SELECT * FROM segnalazioni.v_join_oggetto_rischio WHERE  id_segnalazione=".$id." AND attivo='t';";
} else {
	$query_or="SELECT * FROM segnalazioni.v_join_oggetto_rischio WHERE id_segnalazione_in_lavorazione=".$id_lavorazione."  AND attivo='t';";
}
//echo $query_or;
$result_or=pg_query($conn, $query_or);
while($r_or = pg_fetch_assoc($result_or)) {
	$check_or=1;
	$id_tipo_oggetto_rischio=$r_or['id_tipo_oggetto'];
	$id_oggetto_rischio=$r_or['id_oggetto'];
}

if (isset($id_provvedimento)){
	$query_or="SELECT * FROM segnalazioni.t_geometrie_provvedimenti_cautelari WHERE id_provvedimento=".$id_provvedimento.";";
	//echo $query_or;
	//echo "<br>";
	$result_or=pg_query($conn, $query_or);
	while($r_or = pg_fetch_assoc($result_or)) {
		$check_or=1;
		if ($r_or['tipo_oggetto']=='geodb.edifici'){
			$id_tipo_oggetto_rischio=4;
		} else if ($r_or['tipo_oggetto']=='geodb.civici'){
			$id_tipo_oggetto_rischio=1;
		} else if ($r_or['tipo_oggetto']=='geodb.sottopassi'){		
			$id_tipo_oggetto_rischio=10;
		} else if ($r_or['tipo_oggetto']=='geodb.v_vie_unite'){		
			$id_tipo_oggetto_rischio=0;
		}
		$id_oggetto_rischio=$r_or['id_oggetto'];
	}
}

						


//echo $query_or;
// cerco i dettagli dell'oggetto a rischio
$query_or2="SELECT * from segnalazioni.tipo_oggetti_rischio where id= ".$id_tipo_oggetto_rischio.";";
//echo $query_or2;
$result_or2=pg_query($conn, $query_or2);
while($r_or2 = pg_fetch_assoc($result_or2)) {
	$nome_tabella_oggetto_rischio=$r_or2['nome_tabella'];
	$descrizione_oggetto_rischio=$r_or2['descrizione'];
	$nome_campo_id_oggetto_rischio=$r_or2['campo_identificativo'];
}
if($check_or==1) {
	echo "<h4> <i class=\"fas fa-exclamation-triangle\"></i> Oggetto a rischio </h4>";
	echo "<b>Tipo oggetto a rischio</b>:".$descrizione_oggetto_rischio;
	echo "<br><b>Id oggetto a rischio </b>:".$id_oggetto_rischio;
	
	if ($check_spostamento==1 and $check_operatore==1 and $check_or==1) {
	echo '<br><br><a href="segnalazioni/remove_e_r.php?id='.$id.'"&lav='.$id_lavorazione.' class="btn btn-danger">
	<i class="fas fa-times"></i> Rimuovi oggetto a rischio</a>';
}
	
} else if ($check_or==0 ) {
	echo "<h4> <i class=\"fas fa-exclamation-triangle\"></i> Nessun oggetto a rischio segnalato.</h4>";
	if ($check_lav>=0 and $check_operatore == 1){
	
	if (basename($_SERVER['PHP_SELF'])=='dettagli_segnalazione.php') {
	?>
	
	<form autocomplete="off" action="./segnalazioni/new_e_r.php" method="POST">
  <input type="hidden" name="id" id="hiddenField" value="<?php echo $id ?>" />
  <input type="hidden" name="id_lavorazione" id="hiddenField" value="<?php echo $id_lavorazione ?>" />
  <input type="hidden" name="lon" id="hiddenField" value="<?php echo $lon ?>" />  
  <input type="hidden" name="lat" id="hiddenField" value="<?php echo $lat ?>" />  
	<div class="form-group">
     <label for="tipo_oggetto">Oggetto:</label> 
                   <select class="form-control" name="tipo_oggetto" id="tipo_oggetto" required="">
                   <option name="tipo_oggetto" value="" > Specifica oggetto </option>
   <?php            
   $query2="SELECT * FROM segnalazioni.tipo_oggetti_rischio WHERE valido='t' ORDER BY descrizione;";
   echo $query2;
   $result2 = pg_query($conn, $query2);
   //echo $query1;    
   while($r2 = pg_fetch_assoc($result2)) { 
   ?>    
           <option name="tipo_oggetto" value="<?php echo $r2['id'];?>" ><?php echo $r2['descrizione'];?></option>
    <?php } ?>

    </select>            
    </div>
	 <button  type="submit" class="btn btn-primary"> <i class="fas fa-plus-square"></i> Aggiungi elemento a rischio</button>
     </form>
	
	<?php
	} // check_lav
	}
}


//oggetti a rischio passati
echo "<br><lu>";
$query_or="SELECT * FROM segnalazioni.join_oggetto_rischio WHERE  id_segnalazione=".$id." AND attivo='f';";
//echo $query_or;
$result_or=pg_query($conn, $query_or);
while($r_or = pg_fetch_assoc($result_or)) {
	echo "<li><b>Oggetto a rischio definito in passato e poi rimosso dal sistema</b>:";
	$query_tipo= "SELECT descrizione FROM segnalazioni.tipo_oggetti_rischio 
	WHERE id=".$r_or['id_tipo_oggetto'].";";
	$result_tipo=pg_query($conn, $query_tipo);
	while($r_tipo = pg_fetch_assoc($result_tipo)) {
		echo $r_tipo['descrizione'];
	}
	echo "(id=".$r_or['id_oggetto'].")</li>";
}
echo "</lu>";




// eventualmente da tirare fuori altri dettagli
if ($descrizione_oggetto_rischio=='Civici'){

	//$query_or3="SELECT * from ".$nome_tabella_oggetto_rischio."  where ".$nome_campo_id_oggetto_rischio." = ".$id_oggetto_rischio.";";
	$query_or3="SELECT * FROM geodb.civici WHERE id = ".$id_oggetto_rischio.";";
	$result_or3=pg_query($conn, $query_or3);
	while($r_or3 = pg_fetch_assoc($result_or3)) {
		$numciv=ltrim($r_or3["numero"],'0');
		$via=$r_or3["desvia"];
		$lettera=$r_or3["lettera"];	
	}
	//echo "<br><b>Indirizzo</b>: ".$via. ", " .$numciv;
	?>
	<br> <br> <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#anagrafe_civico"><i class="fas fa-address-book"></i> Visualizza anagrafe civico </button>
	<br> <br> 
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
				        
				        <table  id="t_anagrafe_civico" class="table-hover" style="word-break:break-all; word-wrap:break-word; " data-toggle="table" data-url="./tables/griglia_anagrafe_civico.php?id=<?php echo $id_oggetto_rischio;?>" data-height="900"  data-show-export="true" data-search="true" data-click-to-select="true" data-pagination="false" data-sidePagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-toolbar="#toolbar">
				        
				        
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
				if ($check_lav>=0 and $check_operatore == 1){
					
					$check_pc=0;
					$query_pc="SELECT * FROM segnalazioni.v_provvedimenti_cautelari_last_update WHERE rimosso ='f' and tipo_oggetto='".$nome_tabella_oggetto_rischio."' and id_oggetto=".$id_oggetto_rischio.";";
					//echo $query_pc;
					$result_pc=pg_query($conn, $query_pc);
					while($r_pc = pg_fetch_assoc($result_pc)) {
						$check_pc=1;
						echo "Provvedimento cautelare già in corso o effettuato";
						//echo $r_pc['id_stato_provvedimenti_cautelari'];
						if ($r_pc['id_stato_provvedimenti_cautelari']==3 && $check_operatore==1 && basename($_SERVER['PHP_SELF']) == 'dettagli_segnalazione.php'){
							echo'<h5> Se la situazione fosse tornata normale, <b>in presenza di una nuova ordinanza sindacale</b>, 
								è possibile rimuovere il provvedimento cautelare. <br><br>';
								echo 'Prima di tutto è necessario  assegnare uno o più incarichi per ripristinare la situazione.';
								echo '(far rientrare i residenti)';
								echo '<br><br>Una volta completati gli incarichi è possibile rimuovere il Provvedimento dal sistema</h5>';
								
							echo '
							<button type="button" class="btn btn-info"  data-toggle="modal" 
							data-target="#new_incarico"><i class="fas fa-plus"></i>
							 Assegna incarico per rimuovere Provvedimento Cautelare</button>
							 
						   - 
								 
							<button type="button" class="btn btn-danger"  data-toggle="modal" 
							data-target="#rimuovi_pc_civico">
							<i class="fas fa-times"></i> Rimuovi PC</button>';
							
							
							?>
							
							<div id="rimuovi_pc_civico" class="modal fade" role="dialog">
						  <div class="modal-dialog modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Conferma</h4>
							  </div>
							  <div class="modal-body">
								Confermi di voler rimuovere il presente Provvedimento Cautelare? <br><br> Ricorda che per 
								rimuovere un provvedimento cautelare è necessaria una nuova ordinanza sindacale.
								<br><br>Se sei in possesso di ordinanza sindacale prima di tutto assegna uno 
								o più incarichi per ripristinare la situazione. 
								
								Solo una volta completati gli incarichi rimuovi il PC dal sistema.
								<hr>
								<form autocomplete="off" action="provvedimenti_cautelari/rimuovi.php?id=<?php echo $r_pc['id']; ?>" method="POST">
									<button  id="conferma" type="submit" class="btn btn-warning">Gli incarichi sono stati completati?
									<br>Rimuovi il provvedimento cautelare</button>
									
									<button type="button" class="btn btn-default" data-dismiss="modal">Gli inccarichi non sono stati completati?</button>
								</form>
	
							  </div>
							
							</div>

						  </div>
						</div>
							
							
							
							
							<?php
							
							
						}
					}
					
					if($check_operatore==1 and $r['in_lavorazione']!='f') {
					if($check_pc==0) {
				?>
				<br> <br>
				<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#new_pc_sgombero"><i class="fas fa-plus"></i> Provvedimento cautelare<br>Sgombero civico </button>


<?php
					}
					}
				} // chiudi if provvedimento cautelare 
				
				
	//echo "<br>".$query_or3;
} else if($descrizione_oggetto_rischio=='Edifici') {
	$query_or3="SELECT * from geodb.anagrafe_edifici where id_edificio = ".$id_oggetto_rischio.";";
	//echo $query_or3;
	?>
<br> <br> <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#anagrafe_edificio"><i class="fas fa-address-book"></i> Visualizza anagrafe edificio </button>
	<!-- Modal incarico-->
						<div id="anagrafe_edificio" class="modal fade" role="dialog">
						  <div class="modal-dialog modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Anagrafe edificio</h4>
							  </div>
							  <div class="modal-body">
							  

								<div id="toolbar">
				            <select class="form-control">
				                <option value="">Esporta i dati visualizzati</option>
				                <option value="all">Esporta tutto (lento)</option>
				                <option value="selected">Esporta solo selezionati</option>
				            </select>
				        </div>
				        
				        <table  id="t_anagrafe_edificio" class="table-hover" style="word-break:break-all; word-wrap:break-word; " data-toggle="table" data-url="./tables/griglia_anagrafe_edificio.php?id=<?php echo $id_oggetto_rischio;?>" data-height="900"  data-show-export="true" data-search="true" data-click-to-select="true" data-pagination="false" data-sidePagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-toolbar="#toolbar">
				        
				        
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
				    var $table = $('#t_anagrafe_edificio');
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
				if ($check_lav>=0 and $check_operatore == 1){
					
					$check_pc=0;
					$query_pc="SELECT * FROM segnalazioni.v_provvedimenti_cautelari_last_update WHERE rimosso ='f' AND tipo_oggetto='".$nome_tabella_oggetto_rischio."' and id_oggetto=".$id_oggetto_rischio.";";
					//echo $query_pc;
					$result_pc=pg_query($conn, $query_pc);
					while($r_pc = pg_fetch_assoc($result_pc)) {
						$check_pc=1;
						echo "<br> <h4>Provvedimento cautelare già in corso o effettuato</h4>";
						//echo $r_pc['id_stato_provvedimenti_cautelari'];
						if ($r_pc['id_stato_provvedimenti_cautelari']==3 && $check_operatore==1 && basename($_SERVER['PHP_SELF']) == 'dettagli_segnalazione.php'){
							echo'<h5> Se la situazione fosse tornata normale, <b>in presenza di una nuova ordinanza sindacale</b>, 
								è possibile rimuovere il provvedimento cautelare. <br><br>';
								echo 'Prima di tutto è necessario  assegnare uno o più incarichi per ripristinare la situazione.';
								echo '(far rientrare i residenti)';
								echo '<br><br>Una volta completati gli incarichi è possibile rimuovere il Provvedimento dal sistema</h5>';
							
							echo '
							<button type="button" class="btn btn-info"  data-toggle="modal" 
							data-target="#new_incarico"><i class="fas fa-plus"></i>
							 Assegna incarico per rimuovere Provvedimento Cautelare</button>
							 
						   - 
								 
							<button type="button" class="btn btn-danger"  data-toggle="modal" 
							data-target="#rimuovi_pc_edificio">
							<i class="fas fa-times"></i> Rimuovi PC</button>';
							
							
							?>
							<!-- Modal rimuovi pc civico-->
							<div id="rimuovi_pc_edificio" class="modal fade" role="dialog">
						  <div class="modal-dialog modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Conferma</h4>
							  </div>
							  <div class="modal-body">
								Confermi di voler rimuovere il presente Provvedimento Cautelare? <br><br> Ricorda che per 
								rimuovere un provvedimento cautelare è necessaria una nuova ordinanza sindacale.
								<br><br>Se sei in possesso di ordinanza sindacale prima di tutto assegna uno 
								o più incarichi per ripristinare la situazione. 
								<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#new_incarico"><i class="fas fa-plus"></i> Assegna incarico </button>
								Solo una volta completati gli incarichi rimuovi il PC dal sistema.
								<hr>
								<form autocomplete="off" action="provvedimenti_cautelari/rimuovi.php?id=<?php echo $r_pc['id']; ?>" method="POST">
									<button  id="conferma" type="submit" class="btn btn-warning">Gli incarichi sono stati completati?
									<br>Rimuovi il provvedimento cautelare</button>
									
									<button type="button" class="btn btn-default" data-dismiss="modal">Gli inccarichi non sono stati completati?</button>
								</form>
	
							  </div>
							
							</div>

						  </div>
						</div>
					<?php
						}
					}
					if($check_pc==0) {
				?>
				<br> <br>
				<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#new_pc_sgombero"><i class="fas fa-plus"></i> Provvedimento cautelare<br>Sgombero edificio </button>


<?php
				}
				} // chiudi if provvedimento cautelare 
				
				
} else if ($descrizione_oggetto_rischio=='Sottopassi'){
	
				
				if ($check_lav>=0 and $check_operatore == 1){
					
					$check_pc=0;
					$query_pc="SELECT * FROM segnalazioni.v_provvedimenti_cautelari_last_update WHERE rimosso ='f' AND tipo_oggetto='".$nome_tabella_oggetto_rischio."' and id_oggetto=".$id_oggetto_rischio.";";
					//echo $query_pc;
					$result_pc=pg_query($conn, $query_pc);
					while($r_pc = pg_fetch_assoc($result_pc)) {
						$check_pc=1;
						echo "Provvedimento cautelare già in corso o effettuato";
						//echo $r_pc['id_stato_provvedimenti_cautelari'];
						if ($r_pc['id_stato_provvedimenti_cautelari']==3 && $check_operatore==1 && basename($_SERVER['PHP_SELF']) == 'dettagli_segnalazione.php'){
							echo'<h5> Se la situazione fosse tornata normale, <b>in presenza di una nuova ordinanza sindacale</b>, 
								è possibile rimuovere il provvedimento cautelare. <br><br>';
								echo 'Prima di tutto è necessario  assegnare uno o più incarichi per ripristinare la situazione.';
								echo '(riaprire il sottopasso)';
								echo '<br><br>Una volta completati gli incarichi è possibile rimuovere il Provvedimento dal sistema</h5>';
							echo '
							<button type="button" class="btn btn-info"  data-toggle="modal" 
							data-target="#new_incarico"><i class="fas fa-plus"></i>
							 Assegna incarico per rimuovere Provvedimento Cautelare</button>
							 
						   - 
								 
							<button type="button" class="btn btn-danger"  data-toggle="modal" 
							data-target="#rimuovi_pc_sottopasso">
							<i class="fas fa-times"></i> Rimuovi PC</button>';
							
							
							?>
							<!-- Modal rimuovi pc civico-->
							<div id="rimuovi_pc_sottopasso" class="modal fade" role="dialog">
						  <div class="modal-dialog modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Conferma</h4>
							  </div>
							  <div class="modal-body">
								Confermi di voler rimuovere il presente Provvedimento Cautelare? 
								<br><br> Ricorda che per 
								rimuovere un provvedimento cautelare è necessaria una nuova ordinanza sindacale.
								<br><br>Se sei in possesso di ordinanza sindacale prima di tutto assegna uno 
								o più incarichi per ripristinare la situazione. 
								<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#new_incarico"><i class="fas fa-plus"></i> Assegna incarico </button>
								Solo una volta completati gli incarichi rimuovi il PC dal sistema.
								<hr>
								<form autocomplete="off" action="provvedimenti_cautelari/rimuovi.php?id=<?php echo $r_pc['id']; ?>" method="POST">
									<button  id="conferma" type="submit" class="btn btn-warning">Gli incarichi sono stati completati?
									<br>Rimuovi il provvedimento cautelare</button>
									
									<button type="button" class="btn btn-default" data-dismiss="modal">Gli inccarichi non sono stati completati?</button>
								</form>
	
							  </div>
							
							</div>

						  </div>
						</div>
					<?php
						}
					}
					if($check_pc==0) {
				?>
				<br> <br>
				<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#new_pc_ia"><i class="fas fa-plus"></i> Provvedimento cautelare<br>Interdizione all'accesso</button>


<?php
					}
				} // chiudi if provvedimento cautelare 
				
				
	
	
	

?>

<br><br>
<?php
}
?>
<!-- Modal pc-->
<div id="new_pc_sgombero" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Nuovo provvedimento cautelare - Sgombero</h4>
	  </div>
	  <div class="modal-body">
	  

		<form autocomplete="off" action="provvedimenti_cautelari/nuovo_pc.php?id=<?php echo $id_lavorazione; ?>&s=<?php echo $id; ?>" method="POST">
			
		    <!--input type="hidden" name="tipo_pc" id="hiddenField" value="1" /-->
			<input type="hidden" name="nome_tabella_oggetto_rischio" id="hiddenField" value="<?php echo $nome_tabella_oggetto_rischio; ?>" />
			<input type="hidden" name="descrizione_oggetto_rischio" id="hiddenField" value="<?php echo $descrizione_oggetto_rischio; ?>" />
			<input type="hidden" name="nome_campo_id_oggetto_rischio" id="hiddenField" value="<?php echo $nome_campo_id_oggetto_rischio; ?>" />
			<input type="hidden" name="id_oggetto_rischio" id="hiddenField" value="<?php echo $id_oggetto_rischio; ?>" />
			<input type="hidden" name="id_profilo" id="hiddenField" value="<?php echo $profilo_sistema ?>" />
	
			<div class="form-group">
			 <label for="tipo">Tipologia di incarico:</label> <font color="red">*</font>
				<select class="form-control" name="tipo" id="tipo" onChange="getUO2(this.value);"  required="">
				   <option name="tipo" value="" >  </option>
				<option name="tipo" value="direzioni" > Incarico a Direzioni (COC) </option>
				<option name="tipo" value="municipi" > Incarico a municipi </option>
				<option name="tipo" value="distretti" > Incarico a distretti di PM </option>
				<!--option name="tipo" value="esterni" > Incarico a Unità Operative esterne. </option-->
			</select>
			</div>
				 
							 <script>
				function getUO2(val) {
					$.ajax({
					type: "POST",
					url: "get_uo.php",
					data:'cod='+val,
					success: function(data){
						$("#uo-list-pc").html(data);
					}
					});
				}

				</script>

				 
				 
				<div class="form-group">
				  <label for="id_uo_pc">Seleziona l'Unità Operativa cui assegnare l'incarico:</label> <font color="red">*</font>
					<select class="form-control" name="uo" id="uo-list-pc" class="demoInputBox" required="">
					<option value=""> ...</option>
				</select>         
				 </div>     
				
			
			
			
			<?php
			$query2="SELECT * FROM segnalazioni.tipo_provvedimenti_cautelari WHERE id=1 ";
			$result2 = pg_query($conn, $query2);
			?>
			<div class="form-group">
			  <label for="tipo_pc">Tipo provvedimento:</label> <font color="red">*</font>
				<select readonly="" class="form-control" name="tipo_pc" id="tipo_pc-list" class="demoInputBox" required="">
				<?php    
				while($r2 = pg_fetch_assoc($result2)) { 
					$valore=  $r2['id']. ";".$r2['descrizione'];            
				?>
							
						<option id="tipo_pc" name="tipo_pc" value="<?php echo $r2['id'];?>" ><?php echo $r2['descrizione'];?></option>
				 <?php } ?>
			</select>
			 </div> 
			<div class="form-group">
					 <label for="descrizione"> Note</label> <font color="red">*</font>
				<input type="text" name="descrizione" class="form-control" required="">
			  </div>            
				  



		<button  id="conferma" type="submit" class="btn btn-primary">Assegna provvedimento cautelare</button>
			</form>

	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
	  </div>
	</div>

  </div>
</div>


<!-- Modal pc-->
<div id="new_pc_ia" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Nuovo provvedimento cautelare - Sgombero</h4>
	  </div>
	  <div class="modal-body">
	  

		<form autocomplete="off" action="provvedimenti_cautelari/nuovo_pc.php?id=<?php echo $id_lavorazione; ?>&s=<?php echo $id; ?>" method="POST">
			
		    <!--input type="hidden" name="tipo_pc" id="hiddenField" value="1" /-->
			<input type="hidden" name="nome_tabella_oggetto_rischio" id="hiddenField" value="<?php echo $nome_tabella_oggetto_rischio; ?>" />
			<input type="hidden" name="descrizione_oggetto_rischio" id="hiddenField" value="<?php echo $descrizione_oggetto_rischio; ?>" />
			<input type="hidden" name="nome_campo_id_oggetto_rischio" id="hiddenField" value="<?php echo $nome_campo_id_oggetto_rischio; ?>" />
			<input type="hidden" name="id_oggetto_rischio" id="hiddenField" value="<?php echo $id_oggetto_rischio; ?>" />
			
	
			<?php
			$query2="SELECT * FROM users.v_squadre WHERE id_stato=2 ORDER BY nome ";
			$result2 = pg_query($conn, $query2);
			?>
			<div class="form-group">
			  <label for="id_civico">Seleziona squadra:</label> <font color="red">*</font>
				<select class="form-control" name="uo" id="uo-list" class="demoInputBox" required="">
				<option  id="uo" name="uo" value="">Seleziona la squadra</option>
				<?php    
				while($r2 = pg_fetch_assoc($result2)) { 
					$valore=  $r2['cf']. ";".$r2['nome'];            
				?>
							
						<option id="uo" name="uo" value="<?php echo $r2['id'];?>" ><?php echo $r2['nome'].' ('.$r2['id'].')';?></option>
				 <?php } ?>
			</select>
			<small> Se non trovi una squadra adatta vai alla <a href="gestione_squadre.php" >gestione squadre</a>. </small>
			 </div>       
			
			
			
			<?php
			$query2="SELECT * FROM segnalazioni.tipo_provvedimenti_cautelari WHERE id=2 ";
			$result2 = pg_query($conn, $query2);
			?>
			<div class="form-group">
			  <label for="tipo_pc">Tipo provvedimento:</label> <font color="red">*</font>
				<select readonly="" class="form-control" name="tipo_pc" id="tipo_pc-list" class="demoInputBox" required="">
				<?php    
				while($r2 = pg_fetch_assoc($result2)) { 
					$valore=  $r2['id']. ";".$r2['descrizione'];            
				?>
							
						<option id="tipo_pc" name="tipo_pc" value="<?php echo $r2['id'];?>" ><?php echo $r2['descrizione'];?></option>
				 <?php } ?>
			</select>
			 </div> 
			<div class="form-group">
					 <label for="descrizione"> Note</label> <font color="red">*</font>
				<input type="text" name="descrizione" class="form-control" required="">
			  </div>            
				  



		<button  id="conferma" type="submit" class="btn btn-primary">Assegna provvedimento cautelare</button>
			</form>

	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
	  </div>
	</div>

  </div>
</div>

<?php

?>