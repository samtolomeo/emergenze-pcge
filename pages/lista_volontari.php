<?php 

$subtitle="Gestione utenti"

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
                    <h1 class="page-header">Elenco volontari</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <br><br>
            <div class="row">


        <div id="toolbar">
            <select class="form-control">
                <option value="">Esporta i dati visualizzati</option>
                <option value="all">Esporta tutto (lento)</option>
                <option value="selected">Esporta solo selezionati</option>
            </select>
        </div>
        
        <table  id="t_volontari" class="table-hover" style="word-break:break-all; word-wrap:break-word; " data-toggle="table" data-url="./tables/griglia_elenco_volontari.php" data-height="900"  data-show-export="true" data-search="true" data-click-to-select="true" data-pagination="false" data-sidePagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-toolbar="#toolbar">
        
        
<thead>

 	<tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="cf" data-sortable="false"  data-visible="true">CF</th>
            <th style="word-break:break-all; word-wrap:break-word; " data-field="cognome" data-sortable="true"  data-visible="true">Cognome</th>
            <th style="word-break:break-all; word-wrap:break-word; " data-field="nome" data-sortable="true"  data-visible="true">Nome</th>
	        <th data-field="comune" data-sortable="true"  data-visible="true" >Comune</th>
	    		<th data-field="provincia" data-sortable="true"  data-visible="true" >PR</th>
             <th data-field="id_profilo" data-sortable="true"  data-visible="true" >Tipo<br>Profilo</th>
            <th data-field="stato_profilo" data-sortable="true" data-formatter="nameFormatter0" data-visible="true" >Stato<br>profilo</th>
            <th data-field="cf" data-sortable="false" data-formatter="nameFormatter" data-visible="true" > Edit </th>
            <!--th data-field="cf" data-sortable="false" data-formatter="nameFormatter1" data-visible="true" >Edit<br>permessi</th-->            

    </tr>
</thead>

</table>


<script>
    // DA MODIFICARE NELLA PRIMA RIGA L'ID DELLA TABELLA VISUALIZZATA (in questo caso t_volontari)
    var $table = $('#t_volontari');
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

        return '<a href="./update_volontario.php?id=\''+ value + '\'" class="btn btn-warning" title="Modifica dati" role="button"><i class="fa fa-user-edit" aria-hidden="true"></i> </a> <a href="./elimina_volontario.php?id=\''+ value + '\'" class="btn btn-danger" role="button" title="Elimina persona" ><i class="fa fa-times" aria-hidden="true"></i> </a>';
    }



function nameFormatter0(value) {

	if (value=='t'){
        return '<i class="fa fa-play" aria-hidden="true"></i>';
	} else if (value=='f') {
		  return '<i class="fa fa-pause" aria-hidden="true"></i>';
	} else {
		return '';
	}
}


  function nameFormatter1(value) {

        return '<a href="./permessi.php?id=\''+ value + '\'" class="btn btn-warning" title="Modifica permessi" role="button"><i class="fa fa-user-lock" aria-hidden="true"></i> </a>';
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
