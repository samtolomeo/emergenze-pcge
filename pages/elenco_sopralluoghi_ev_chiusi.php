<?php 

$subtitle="Elenco presidi fissi (eventi chiusi)";


$getfiltri=$_GET["f"];
$filtro_evento_attivo=$_GET["a"];

//echo $filtro_evento_attivo; 


$uri=basename($_SERVER['REQUEST_URI']);
//echo $uri;

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

require('./tables/filtri_segnalazioni.php');
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
                    <h1 class="page-header">Elenco segnalazioni</h1>
                </div>
            </div-->

            
            <br><br>
            <div class="row">


	
        <div id="toolbar">
            <select class="form-control">
                <option value="">Esporta i dati visualizzati</option>
                <option value="all">Esporta tutto (lento)</option>
                <option value="selected">Esporta solo selezionati</option>
            </select>
        </div>
        

        <table  id="pres" class="table-hover" data-toggle="table" data-url="./tables/griglia_sopralluoghi_eventi_chiusi.php?f=<?php echo $getfiltri;?>" data-height="900" data-show-export="true" data-search="true" data-click-to-select="true" data-pagination="true" data-sidePagination="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-toolbar="#toolbar">


        
        
<thead>

 	<tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id_stato_sopralluogo" data-sortable="false" data-formatter="presidiFormatter" data-visible="true" >Stato</th> 
            <!--th data-field="tipo_provvedimento" data-sortable="true" data-visible="true">Tipo</th-->
				<!--th data-field="oggetto" data-sortable="true"  data-visible="true">Localizzazione</th-->
            <th data-field="descrizione" data-sortable="true"   data-visible="true">Descrizione</th>
            <th data-field="id_evento" data-sortable="true"  data-visible="true">Evento</th>
            <th data-field="time_preview" data-sortable="true"  data-visible="true">Ora<br>prevista</th>
            <th data-field="time_start" data-sortable="true"  data-visible="true">Ora<br>inizio</th>
            <th data-field="time_stop" data-sortable="true"  data-visible="true">Ora<br>fine</th>
            <!--th data-field="note" data-sortable="false" data-visible="true" >Note</th-->
            <th data-field="id" data-sortable="false" data-formatter="nameFormatterEdit" data-visible="true" >Dettagli</th>            
				<th data-field="id_segnalazione" data-sortable="false" data-formatter="nameFormatterEdit1" data-visible="true" >Segnalazione</th>
    </tr>
</thead>

</table>


<script>
    // DA MODIFICARE NELLA PRIMA RIGA L'ID DELLA TABELLA VISUALIZZATA (in questo caso t_volontari)
    var $table = $('#pres');
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


 function presidiFormatter(value) {
        if (value==2){
        		return '<i class="fas fa-play" title="Preso in carico" style="color:#5cb85c"></i>';
        } else if (value==3) {
        	   return '<i class="fas fa-stop" title="Chiuso"></i>';
        } else if (value==1){
        	   return '<i class="fas fa-exclamation" title="Da prendere in carico" style="color:#ff0000"></i>';
        }

    }
	

 function nameFormatter(value) {
        if (value=='t'){
        		return '<i class="fas fa-play" style="color:#5cb85c"></i>';
        } else if (value=='f') {
        	   return '<i class="fas fa-stop"></i>';
        } else {
        	   return '<i class="fas fa-pause" style="color:#ff0000"></i>';;
        }

    }

 function nameFormatterEdit(value) {
        
		return '<a class="btn btn-warning" href=./dettagli_sopralluogo.php?id='+value+'> <i class="fas fa-edit"></i> </a>';
 
    }


 function nameFormatterEdit1(value) {
        if (value){
			return '<a class="btn btn-warning" href=./dettagli_segnalazione.php?id='+value+'> <i class="fas fa-search"></i> </a>';
		} else {
			return '-';
		}
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
