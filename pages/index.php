<?php 

$subtitle="Dashboard (pagina iniziale)";




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
//require('./conn.php');

require('./check_evento.php');
require('./conteggi_dashboard.php');

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
                <!--div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div-->
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            
            <?php echo $note_debug; ?>
           

            <br>
            
            <style type="text/css">
            
            .panel-allerta {
				  border-color: <?php echo $color_allerta; ?>;
				}
				.panel-allerta > .panel-heading {
				  border-color: <?php echo $color_allerta; ?>;
				  color: white;
				  background-color: <?php echo $color_allerta; ?>;
				}
				.panel-allerta > a {
				  color: <?php echo $color_allerta; ?>;
				}
				.panel-allerta > a:hover {
				  color: #337ab7;
				  /* <?php echo $color_allerta; ?>;*/
				}
            
            
            
            
            </style>
            
            
            <!-- riga iniziale con i contatori -->
            <div class="row">
				<!-- EVENTI IN CORSO -->
            <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $contatore_eventi; ?></div>
                                    <div> <?php echo $preview_eventi; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="./dettagli_evento.php">
                            <div class="panel-footer">
                                <span class="pull-left">Vai ai dettagli</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            
            
            
				<!-- ALLERTE -->
            <div class="col-lg-3 col-md-6">
                    <div class="panel panel-allerta">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-exclamation-triangle fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $contatore_allerte; ?></div>
                                    <div><?php echo $preview_allerte; ?>!</div>
                                </div>
                            </div>
                        </div>
                        <a href="./dettagli_evento.php">
                            <div class="panel-footer">
                                <span class="pull-left">Aggiungi/modifica allerte</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            
            
            
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-map-marked-alt  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                    <?php
                                   		echo $segn_tot;
                                    ?>
                                    
                                    </div>
                                    <div>Segnalazioni pervenute</div>
                                </div>
                            </div>
                        </div>
                        <a href="elenco_segnalazioni.php">
                            <div class="panel-footer">
                                <span class="pull-left">Elenco segnalazioni</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                
                
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cogs fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                    <?php
													echo $segn_lav;
                                    ?>
                                    
                                    </div>
                                    <div>Segnalazioni in lavorazione</div>
                                </div>
                            </div>
                        </div>
                        <a href="mappa_segnalazioni.php">
                            <div class="panel-footer">
                                <span class="pull-left">Vedi su mappa</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                
                
                
                
                
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                
                




                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-map-marked-alt fa-fw"></i> Mappa segnalazioni e presidi in corso
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Altro
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="elenco_segnalazioni.php">Elenco segnalazioni</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="mappa_segnalazioni.php">Ingrandisci mappa</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <!--div id="mapid" style="width: 100%; height: 400px;"></div-->
                        <iframe style="width:100%;height: 600px;position:relative" src="./mappa_leaflet.php"></iframe>
                        <!-- /.panel-body -->
                    </div>
                
                
                
                  
                  
                  
                    
                    
                    
                    <div id="segn_limbo_table" class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-exclamation fa-fw" style="color:red"></i> Sintesi segnalazioni ancora da elaborare
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li class="divider"></li>
                                        <li><a href="elenco_segnalazioni.php">Vai all'elenco completo delle segnalazioni</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                    

<table  id="segnalazioni" class="table-hover" style="word-break:break-all; word-wrap:break-word;" data-toggle="table" data-url="./tables/griglia_segnalazioni_limbo.php" data-show-export="false" data-search="true" data-click-to-select="true" data-pagination="true" data-sidePagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-toolbar="#toolbar">
			

        
        
<thead>

 	<tr>
            <!--th data-field="state" data-checkbox="true"></th-->
            <!--th data-field="in_lavorazione" data-sortable="false" data-formatter="nameFormatter" data-visible="true" ></th--> 
            <th data-field="rischio" data-sortable="true" data-formatter="nameFormatterRischio" data-visible="true">Persone<br>a rischio</th>
            <th style="word-break:break-all; word-wrap:break-word;" data-field="criticita" data-sortable="true"   data-visible="true">Tipo criticità</th>
            <!--th data-field="id_evento" data-sortable="true"  data-visible="true">Id<br>evento</th-->
            <th style="word-break:break-all; word-wrap:break-word;" data-field="tipo_evento" data-sortable="true"  data-visible="true">Tipo evento</th>
            <!--th style="word-break:break-all; word-wrap:break-word;" data-field="data_ora" data-sortable="true"  data-visible="true">Data e ora</th-->
            <th style="word-break:break-all; word-wrap:break-word;" data-field="descrizione" data-sortable="true"  data-visible="true">Descrizione</th>
            <!--th data-field="note" data-sortable="false" data-visible="true" >Note</th-->
            <th data-field="id" data-sortable="false" data-formatter="nameFormatterEdit" data-visible="true" >Dettagli</th>            

    </tr>
</thead>
<script>


 function nameFormatter(value) {
        if (value=='t'){
        		return '<i class="fas fa-play" style="color:#5cb85c"></i>';
        } else if (value=='f') {
        	   return '<i class="fas fa-stop" style="color:#5cb85c"></i>';
        } else {
        	   return '<i class="fas fa-pause" style="color:#ff0000"></i>';;
        }

    }
    
 function nameFormatterEdit(value) {
        
		return '<a class="btn btn-warning" href=./dettagli_segnalazione.php?id='+value+'> <i class="fas fa-edit"></i> </a>';
 
    }

  function nameFormatterRischio(value) {
        //return '<i class="fas fa-'+ value +'"></i>' ;
        
        if (value=='t'){
        		return '<i class="fas fa-exclamation-triangle" style="color:#ff0000"></i>';
        } else if (value=='f') {
        	   return '<i class="fas fa-check" style="color:#5cb85c"></i>';
        }
        else {
        		return '<i class="fas fa-question" style="color:#505050"></i>';
        }
    }


</script>

</table>
                                    
                                    
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                    
                    
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-traffic-light fa-fw"></i> Osservatorio Meteo Idrologico della Regione Liguria

 								<a target="_new" href="https://omirl.regione.liguria.it/">link ARPAL</a> 
                        </div>
                        <div class="panel-body">
                 			<iframe style="width:100%;height: 1000px;position:relative" src="https://omirl.regione.liguria.it/"></iframe>    

                        </div>                    
                        <!-- /.panel-body -->
                    </div>
                    
                    
                    
                    
                    
                    
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                
                
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-traffic-light fa-fw"></i> Mappa ufficiale <a target="_new" href="http://www.allertaliguria.gov.it">allertaliguria</a> 
							 <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Altro
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="bollettini_meteo.php">Elenco bollettini allerte</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="http://www.allertaliguria.gov.it">Vai alla pagina www.allertaliguria.gov.it </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                           
							  <img class="pull-right img-responsive" imageborder="0" alt="Problema di visualizzazione immagine causato da sito http://www.allertaliguria.gov.it/" src="https://mappe.comune.genova.it/allertaliguria/mappa_allerta_render.php">
                        </div>                    
                        <!-- /.panel-body -->
                    </div>
                
                
                
                    <div id="panel-notifiche" class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Pannello notifiche
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                               
                                		<?php if($segn_limbo>0){?>
                                			 <a href="#segn_limbo_table" class="list-group-item">
	                                    <i class="fa fa-exclamation fa-fw" style="color:red"></i> Nuove segnalazioni da elaborare!
	                                    <span class="pull-right text-muted small"><em><?php echo $segn_limbo; ?></em>
	                                    </span>
	                                    </a>
                                    <?php }?>
                                
								
											<?php if($inc_limbo>0){?>
                                			 <!--a href="#" class="list-group-item"-->
                                			 <div class="list-group-item" >
	                                    <i class="fa fa-exclamation fa-fw" style="color:red"></i> Nuovi incarichi ancora da prendere in carico!
	                                    <span class="pull-right text-muted small"><em><?php echo $inc_limbo; ?></em>
	                                    </span>
	                                    <!--/a-->
	                                    </div>
                                    <?php }?>
								
								<div class="list-group-item" >
											
                                
                                    <i class="fa fa-users"></i> <b>Gestione squadre</b>
                                    <br><br>
                                     - <i class="fa fa-play"></i> Squadre in azione
                                    <span class="pull-right text-muted small"><em><?php echo $squadre_in_azione; ?></em>
                                    </span>
                                    
                                    <br>
                                     - <i class="fa fa-pause"></i> Squadre a disposizione
                                    <span class="pull-right text-muted small"><em><?php echo $squadre_disposizione; ?></em>
                                    </span>
                                    <br>
                                     - <i class="fa fa-stop"></i> Squadre a riposo
                                    <span class="pull-right text-muted small"><em><?php echo $squadre_riposo; ?></em>
                                    </span>
                                    <hr>
                                    Totale squadre eventi attivi:
                                    <span class="pull-right text-muted small"><em><?php echo $squadre_riposo; ?></em>
                                    </span>
                                </div>
                            
                            <!-- /.list-group -->
                            <a href="./gestione_squadre.php" class="btn btn-default btn-block">Vai alla gestione squadre</a>
							
							
							<div class="list-group-item" >
											
                                
                                    <i class="fa fa-pencil-ruler"></i> <b>Presidi</b>
                                    <br><br>
                                     - <i class="fa fa-pause"></i> Assegnati
                                    <span class="pull-right text-muted small"><em><?php echo $sopralluoghi_assegnati; ?></em>
                                    </span>
                                    
                                    <br>
                                     - <i class="fa fa-play"></i> In corso
                                    <span class="pull-right text-muted small"><em><?php echo $sopralluoghi_corso; ?></em>
                                    </span>
                                    <br>
                                     - <i class="fa fa-stop"></i> Conclusi
                                    <span class="pull-right text-muted small"><em><?php echo $sopralluoghi_conclusi; ?></em>
                                    </span>
                                    <hr>
                                    Totale presidi eventi attivi:
                                    <span class="pull-right text-muted small"><em><?php echo $sopralluoghi_tot; ?></em>
                                    </span>
                                </div>
                            
                            <!-- /.list-group -->
                            <a href="./nuovo_sopralluogo.php" class="btn btn-default btn-block">Crea un nuovo presidio</a>
							
							</div>
							
							<div class="list-group-item" >
											
                                
                                    <i class="fa fa-exclamation-triangle"></i> <b>Provvedimenti cautelari</b>
                                    <br><br>
                                     - <i class="fa fa-pause"></i> Assegnati
                                    <span class="pull-right text-muted small"><em><?php echo $pc_assegnati; ?></em>
                                    </span>
                                    
                                    <br>
                                     - <i class="fa fa-play"></i> In corso
                                    <span class="pull-right text-muted small"><em><?php echo $pc_corso; ?></em>
                                    </span>
                                    <br>
                                     - <i class="fa fa-stop"></i> Portati a termine
                                    <span class="pull-right text-muted small"><em><?php echo $pc_conclusi; ?></em>
                                    </span>
                                    <hr>
                                    Totale provvedimenti cautelari eventi attivi:
                                    <span class="pull-right text-muted small"><em><?php echo $pc_tot; ?></em>
                                    </span>
                                </div>
                            
                            <!-- /.list-group -->
                            <a href="./elenco_pc.php" class="btn btn-default btn-block">Elenco provvedimenti cautelari</a>
							
							</div>
                        
						
						
						
						
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                    <!--style type="text/css">
                    .twitter-timeline {
							  max-width: 100%;
							  max-height: 1000px;
							}
                    </style-->
                    
                    
                    
                    
                    
                    
                    <div class="panel panel-default">
                     <div class="panel-heading">
                            <i class="fab fa-twitter fa-fw"></i> Twitter
                        </div>
                        <div class="panel-body" style="max-height:1000px;overflow-y: scroll;">
                     <a class="twitter-timeline" href="https://twitter.com/ProtCivileGE?ref_src=twsrc%5Etfw">
                     Tweets by ProtCivileGE</a> 
                     <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                     </div>
                     </div> 

                     
                                     
                    
                    
                     

                     
                     
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tasks"></i> Gestione eventi
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                            <a href="dettagli_evento.php" class="btn btn-default btn-block">Visualizza dettagli</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php 

require('./footer.php');

require('./req_bottom.php');


?>

<script>

	/*var mymap = L.map('mapid').setView([44.411156, 8.932661], 12);

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

	L.marker([44.411156, 8.932661]).addTo(mymap)
		.bindPopup("<b>Hello world!</b><br />I am a leafletJS popup.").openPopup();




	var popup = L.popup();

	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent("You clicked the map at " + e.latlng.toString())
			.openOn(mymap);
	}

	mymap.on('click', onMapClick);*/

</script>
    

</body>

</html>
