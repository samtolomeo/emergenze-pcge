<?php 
// cerco l'oggetto a rischio



$check_or=0;
if ($id_lavorazione==''){
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


$query_or="SELECT * FROM segnalazioni.t_geometrie_provvedimenti_cautelari WHERE id_provvedimento=".$id_provvedimento.";";
//echo $query_or;
$result_or=pg_query($conn, $query_or);
while($r_or = pg_fetch_assoc($result_or)) {
	$check_or=1;
	if ($r_or['tipo_oggetto']=='geodb.edifici'){
		$id_tipo_oggetto_rischio=4;
	} else if ($r_or['tipo_oggetto']=='geodb.civici'){
		$id_tipo_oggetto_rischio=1;
	} else if ($r_or['tipo_oggetto']=='geodb.sottopassi'){		
		$id_tipo_oggetto_rischio=10;
	}
	$id_oggetto_rischio=$r_or['id_oggetto'];
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
} else if ($check_or==0 ) {
	echo "<h4> Nessun oggetto a rischio segnalato.</h4>";
	if ($check_lav>=0){
	
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
	 <button  type="submit" class="btn btn-primary">Aggiungi elemento a rischio</button>
     </form>
	
	<?php
	} // check_lav
	}
}
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
				if ($check_lav==1){
					
					$check_pc=0;
					$query_pc="SELECT * FROM segnalazioni.v_provvedimenti_cautelari_last_update WHERE tipo_oggetto='".$nome_tabella_oggetto_rischio."' and id_oggetto=".$id_oggetto_rischio.";";
					//echo $query_pc;
					$result_pc=pg_query($conn, $query_pc);
					while($r_pc = pg_fetch_assoc($result_pc)) {
						$check_pc=1;
						echo "Provvedimento cautelare già in corso o effettuato";
						
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
				if ($check_lav==1){
					
					$check_pc=0;
					$query_pc="SELECT * FROM segnalazioni.v_provvedimenti_cautelari_last_update WHERE tipo_oggetto='".$nome_tabella_oggetto_rischio."' and id_oggetto=".$id_oggetto_rischio.";";
					//echo $query_pc;
					$result_pc=pg_query($conn, $query_pc);
					while($r_pc = pg_fetch_assoc($result_pc)) {
						$check_pc=1;
						echo "<br> <h4>Provvedimento cautelare già in corso o effettuato</h4>";
						
					}
					if($check_pc==0) {
				?>
				<br> <br>
				<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#new_pc_sgombero"><i class="fas fa-plus"></i> Provvedimento cautelare<br>Sgombero edificio </button>


<?php
				}
				} // chiudi if provvedimento cautelare 
				
				
} else if ($descrizione_oggetto_rischio=='Sottopassi'){
	
				
				if ($check_lav==1){
					
					$check_pc=0;
					$query_pc="SELECT * FROM segnalazioni.v_provvedimenti_cautelari_last_update WHERE tipo_oggetto='".$nome_tabella_oggetto_rischio."' and id_oggetto=".$id_oggetto_rischio.";";
					//echo $query_pc;
					$result_pc=pg_query($conn, $query_pc);
					while($r_pc = pg_fetch_assoc($result_pc)) {
						$check_pc=1;
						echo "Provvedimento cautelare già in corso o effettuato";
						
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