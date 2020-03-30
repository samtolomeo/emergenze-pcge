<?php 

$subtitle="Monitoraggio corsi d'acqua"

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
                    <h1 class="page-header">Elenco punti di monitoraggio (dati ultime 6 h)</h1>
                </div>
				
				<?php
				//echo strtotime("now");
				//echo "<br><br>";
				//echo date('Y-m-d H:i:s');
				//echo "<br><br>";
				//echo date('Y-m-d H:i:s')-3600;
				//echo "<br><br>";
				$now = new DateTime();
				$date = $now->modify('-1 hour')->format('Y-m-d H:i:s');
				//echo $date;
				?>
				
				<table  id="t_mire" class="table-hover" data-toggle="table" data-url="./tables/griglia_mire.php" 
				data-show-search-clear-button="true"   data-show-export="false" data-search="true" data-click-to-select="true" 
				data-pagination="true" data-page-size=50 data-page-list=[10,25,50,100,200,500
				data-sidePagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-toolbar="#toolbar">
        
        
<thead>

 	<tr>
            
		<th data-field="nome" data-sortable="false" data-visible="true">Rio</th>
		<th data-field="last_update" data-sortable="false"  data-visible="true">Last update</th>
		<th data-field="6" data-sortable="false"  data-visible="true">6</th>
		<th data-field="5" data-sortable="false"  data-visible="true">5</th>            
		<th data-field="4" data-sortable="false"  data-visible="true">4</th>
		<th data-field="3" data-sortable="false"  data-visible="true">3</th>  
		<th data-field="2" data-sortable="false"  data-visible="true">2</th>
		<th data-field="1" data-sortable="false"  data-visible="true">1</th>  
    </tr>
</thead>

</table>
				
				
				
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            
            <br><br>
            <div class="row">

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
