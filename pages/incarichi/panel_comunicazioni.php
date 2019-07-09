<?php

?>


<div class="panel-group">
			  <div class="panel panel-success">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" href="#list_comunicazioni"><i class="fa fa-comments"></i>
					<?php
					if ($check_segnalazione==1){
					?>
						Visualizza tutte le comunicazioni sulla segnalazione 
					<?php
					} else {
					?>
						Visualizza tutte le comunicazioni sull'incarico
					<?php
					} 
					?>
					</a>
			      </h4>
			    </div>
			    <div id="list_comunicazioni" class="panel-collapse collapse">
			      <div class="panel-body"-->
				<?php
				// cerco l'id_lavorazione
				$query_comunicazioni="SELECT *";
				if ($check_segnalazione==1){
					$query_comunicazioni= $query_comunicazioni." FROM segnalazioni.v_comunicazioni WHERE id_lavorazione=".$id_lavorazione. ";";
				} else {
					$query_comunicazioni= $query_comunicazioni." FROM segnalazioni.v_comunicazioni_incarichi WHERE id=".$id. ";";
				} 
				
				//echo $query_comunicazioni;
				$result_comunicazioni=pg_query($conn, $query_comunicazioni);
				$i=0;
				while($r_comunicazioni = pg_fetch_assoc($result_comunicazioni)) {
					if ($i>0){
						echo "<hr>";
					}
					$i=$i+1;
					echo "<i class=\"fa fa-comment\"></i> ". $r_comunicazioni['data_ora_stato'];
					echo " - Da " .$r_comunicazioni['mittente']. " a ". $r_comunicazioni['destinatario'];
					echo " : " .$r_comunicazioni['testo'];
					if ($r_comunicazioni['allegato']!=''){
						echo '<a href="../../'.$r_comunicazioni['allegato'].'"> Allegato </a>';
					}
					//echo " - <a class=\"btn btn-info\" href=\"dettagli_incarico.php?id=".$r_comunicazioni['id']."\"> <i class=\"fas fa-info\"></i> Dettagli</a>";
				}
				
					$page = basename($_SERVER['PHP_SELF']);
					if ($page=='dettagli_segnalazione.php' and $check_lav>=0){
					?>
						<br><hr>
						<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#comunicazione"><i class="fas fa-comment"></i> Invia comunicazione</button>
					<?php
					}
					?>
				
			
			
			</div>
    </div>
  </div>
</div>








<!-- Modal comunicazione da UO-->
<div id="comunicazione" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Comunicazioni sulla segnalazione</h4>
	  </div>
	  <div class="modal-body">
	  

		<form autocomplete="off"  enctype="multipart/form-data"  action="incarichi/comunicazione.php?id=<?php echo $id; ?>" method="POST">
			<input type="hidden" name="mittente" value="<?php echo $cognome." " .$nome. " (".$descrizione_profilo.")";?>" />
			<input type="hidden" name="id_lavorazione" value="<?php echo $r['id_lavorazione'];?>" />
			<input type="hidden" name="id_evento" value="<?php echo $id_evento;?>" />
				 <div class="form-group">
				<label for="note">Testo comunicazione <?php echo $id_evento;?></label>  <font color="red">*</font>
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
	



<?php

?>