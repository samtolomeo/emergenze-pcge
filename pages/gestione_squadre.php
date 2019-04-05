<?php 

$subtitle="Gestione squadre"

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

$check_operatore=0;
if ($profilo_sistema <= 8){
	$check_operatore=1;
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
             <div class="row">
                <div class="col-lg-12">
                    <h3>Creazione squadre <i class="fas fa-arrow-right"></i> <!--/h3-->
                <!--/div-->
                <!-- /.col-lg-12 -->
            <!--/div-->
            <!-- /.row -->

            <!--div class="row"-->
            <!--div class="col-lg-6"-->
            <?php
				if ($check_operatore == 0){
					echo '<!--h4--><i class="fas fa-minus-circle"></i> L\'utente non è autorizzato a creare nuove squadre</h3><hr> ';
				} else {
				?>
					<!--h3--><button type="button" class="btn btn-info"  data-toggle="modal" data-target="#new_squadra"><i class="fas fa-plus"></i> Nuova squadra </button></h3>
					<!-- Modal incarico-->
					<div id="new_squadra" class="modal fade" role="dialog">
					  <div class="modal-dialog">
					
					    <!-- Modal content-->
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Nuova squadra</h4>
					      </div>
					      <div class="modal-body">
					      
					
					        <form autocomplete="off" action="squadre/nuova_squadra.php?id=<?php echo $id_lavorazione; ?>&s=<?php echo $id; ?>" method="POST">
							
							<!-- Evento -->
							<div class="form-group">
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
							
					
					             <div class="form-group">
										 <label for="descrizione"> Nome squadra </label> <font color="red">*</font>
					                <input type="text" name="nome" class="form-control" required="">
							      </div>  
					            
					            <div class="form-group">
					              <label for="tipo_segn">Chi gestisce la squadra:</label> <font color="red">*</font>
					                            <select class="form-control" name="afferenza" id="afferenza" required="" >
					                            <option name="afferenza" value="" > Specifica quale Unità Operativa gestirà la squadra </option>
					            <?php            
					            $query2="SELECT * FROM varie.t_afferenza_squadre ORDER BY descrizione;";
					            echo $query2;
						        $result2 = pg_query($conn, $query2);
					            //echo $query1;    
					            while($r2 = pg_fetch_assoc($result2)) { 
					            ?>    
					                    <option name="afferenza" value="<?php echo $r2['cod'];?>" ><?php echo $r2['descrizione'];?></option>
					             <?php } ?>
					
					             </select>            
					             </div>
					            
					             
					                      
					                  
					
					
					
					        <button  id="conferma" type="submit" class="btn btn-primary">Crea squadra</button>
					            </form>
					
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
					      </div>
					    </div>
					
					  </div>
					</div>
					
					
					
				<?php
				} // chiudo if check operatore
				?>
			</div>
            </div>
            <hr>
			<div class="row">
                <div class="col-lg-12">
                    <h3>Elenco squadre</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">

				 <div id="toolbar">
				            <select class="form-control">
				                <option value="">Esporta i dati visualizzati</option>
				                <option value="all">Esporta tutto (lento)</option>
				                <option value="selected">Esporta solo selezionati</option>
				            </select>
				        </div>
				        
				        <table  id="t_squadre" class="table-hover" style="word-break:break-all; word-wrap:break-word; " data-toggle="table" data-url="./tables/griglia_squadre.php" data-height="900"  data-show-export="true" data-search="true" data-click-to-select="true" data-pagination="false" data-sidePagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-toolbar="#toolbar">
				        
				        
				<thead>
				
			 	<tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="false"  data-visible="true">ID</th>
            <th style="word-break:break-all; word-wrap:break-word; " data-field="nome" data-sortable="true"  data-visible="true">Nome</th>
            <th style="word-break:break-all; word-wrap:break-word; " data-field="evento" data-sortable="true"  data-visible="true">Evento</th>
	         <th data-field="afferenza" data-sortable="true"  data-visible="true" >Afferenza</th>
	    	
            <th data-field="stato" data-sortable="true" data-formatter="nameFormatter1" data-visible="true" >Stato</th>
            <!--th data-field="id" data-visible="true" data-formatter="nameFormatter0" >Aggiorna stato</th-->
            <th data-field="num_componenti" data-sortable="true" data-formatter="nameFormatter2" data-visible="true" >Numero<br>componenti</th>
            <?php
				if ($check_operatore == 1){
				?>
				<th data-field="id" data-sortable="false" data-formatter="nameFormatter" data-visible="true" >  </th>
				<!--th data-field="cf" data-sortable="false" data-formatter="nameFormatter1" data-visible="true" >Edit<br>permessi</th-->            
				<?php
				}
				?>
				</tr>
				</thead>
				
				</table>
				
				
				<script>
				    // DA MODIFICARE NELLA PRIMA RIGA L'ID DELLA TABELLA VISUALIZZATA (in questo caso t_volontari)
				    var $table = $('#t_squadre');
				    $(function () {
				        $('#toolbar').find('select').change(function () {
				            $table.bootstrapTable('destroy').bootstrapTable({
				                exportDataType: $(this).val()
				            });
				        });
				    })
				</script>
				
				<br><br>
				
				<script>
				
				
				  function nameFormatter(value) {
				
				        return '<a href="./edit_squadra.php?id='+ value + '" class="btn btn-warning" \
				        title="Modifica squadra" role="button"><i class="fa fa-users" aria-hidden="true"></i>\
				         Dettagli e edit</a>';
				    }
				
				
				
				function nameFormatter0(value, row, index) {
					if (row.id_stato==2){
						return '<a href="./squadre/riposo.php?id='+ value + '" class="btn btn-danger" \
				        title="Imposta a riposo" role="button"><i class="fa fa-stop" aria-hidden="true"></i>\
				         </a>';
						} else if (row.id_stato==3) {
							return '<a href="./squadre/play.php?id='+ value + '" class="btn btn-success" \
				        title="Imposta come a disposizione" role="button"><i class="fa fa-play" aria-hidden="true"></i>\
				        </a>';
						}         
				         
				 }
				
				
				  function nameFormatter1(value, row, index) {
						if (row.id_stato==1){
							return value + ' <i class="fa fa-play" aria-hidden="true"></i>';
						} else if (row.id_stato==2) {
							if (<?php echo $check_operatore; ?> ==1) { 
							return  value + ' - <i class="fa fa-pause" aria-hidden="true"></i> - \
							<a href="./squadre/riposo.php?id='+ row.id + '" class="btn btn-danger btn-sm" \
				        title="Imposta come a riposo" role="button"><i class="fa fa-stop" aria-hidden="true"></i>\
				         </a>';
				         } else {
				         	return  value + ' - <i class="fa fa-pause" aria-hidden="true"></i>';
				         }
						} else if (row.id_stato==3) {
							if (<?php echo $check_operatore; ?> ==1) { 
							return value + ' - <i class="fa fa-stop" aria-hidden="true"></i> - \
							<a href="./squadre/play.php?id='+ row.id + '" class="btn btn-success btn-sm" \
				        title="Imposta come a disposizione" role="button"><i class="fa fa-play" aria-hidden="true"></i>\
				         </a>';
				         } else {
				         	return value + ' - <i class="fa fa-stop" aria-hidden="true"></i>';
				         }
						}
				    }
				
				
				
				function nameFormatter2(value) {
						if (value<1){
							return ' <i class="fas fa-exclamation-circle fa-2x"  style="color:red" aria-hidden="true"></i> ' +value  ;
						} else {
							return  value;
						}
				    }
				</script>


            </div>
            
            <!-- /.row -->
    </div>
    <!-- /#wrapper -->

<?php 

require('./footer.php');

require('./req_bottom.php');


?>

<script type="text/javascript" >

(function($) {
    
    $.fn.bmdIframe = function( options ) {
        var self = this;
        var settings = $.extend({
            classBtn: '.bmd-modalButton',
            defaultW: 640,
            defaultH: 360
        }, options );
      
        $(settings.classBtn).on('click', function(e) {
          var allowFullscreen = $(this).attr('data-bmdVideoFullscreen') || false;
          
          var dataVideo = {
            'src': $(this).attr('data-bmdSrc'),
            'height': $(this).attr('data-bmdHeight') || settings.defaultH,
            'width': $(this).attr('data-bmdWidth') || settings.defaultW
          };
          
          if ( allowFullscreen ) dataVideo.allowfullscreen = "";
          
          // stampiamo i nostri dati nell'iframe
          $(self).find("iframe").attr(dataVideo);
        });
      
        // se si chiude la modale resettiamo i dati dell'iframe per impedire ad un video di continuare a riprodursi anche quando la modale è chiusa
        this.on('hidden.bs.modal', function(){
          $(this).find('iframe').html("").attr("src", "");
        });
      
        return this;
    };
  
})(jQuery);

jQuery(document).ready(function(){
  jQuery("#myModal").bmdIframe();
});


</script>
    

</body>

</html>
