<?php

?>


<div class="panel-group">
			  <div class="panel panel-success">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" href="#list_comunicazioni"><i class="fa fa-comments"></i> Comunicazioni provvedimento cautelare </a>
			      </h4>
			    </div>
			    <div id="list_comunicazioni" class="panel-collapse collapse">
			      <div class="panel-body"-->
				<?php
				// cerco l'id_lavorazione
				$query_comunicazioni="SELECT *";
				$query_comunicazioni= $query_comunicazioni." FROM segnalazioni.v_comunicazioni_provvedimenti_cautelari WHERE id=".$id. ";";
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
				
	
	
				?>
			
			
			</div>
    </div>
  </div>
</div>


<?php

?>