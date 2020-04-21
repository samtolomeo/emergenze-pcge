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
                    <h1 class="page-header">Elenco idrometri ARPA</h1>
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
				$station='Montoggio';
				//echo $date;
				
				
				
				
				$query="SELECT name, shortcode FROM geodb.tipo_idrometri_arpa;";
				//echo $query;
				$result = pg_query($conn, $query);
				while($r = pg_fetch_assoc($result)) {
				?>
					<!-- 2. Add the JavaScript to initialize the chart on document ready -->
					<script type="text/javascript">
					Highcharts.getJSON('../vendor/omirl_data_ingestion/<?php echo $r["shortcode"];?>_Idro.json', function (data) {
					// Create the chart
					Highcharts.stockChart('grafico_<?php echo $r["shortcode"];?>', {


						rangeSelector: {
							inputEnabled: true,
							selected: 1,
							buttons: [{
								type: 'day',
								count: 1,
								text: '1g'
							}, {
								type: 'day',
								count: 3,
								text: '3gg'
							}, {
								type: 'week',
								count: 1,
								text: '7gg'
							}, {
								type: 'day',
								count: 10,
								text: '10gg'
							}, {
								type: 'day',
								count: 14,
								text: '14gg'
							}/*, {
								type: 'all',
								text: 'Tutti'
							}*/],
							inputDateFormat:'%d/%m/%Y',
							inputEditDateFormat:'%d/%m/%Y'
						},
						/*rangeSelector: {
							selected: 1
						},*/

						title: {
							text: '<?php echo $r["name"];?>'
						},
						yAxis: {
							title: {
								text: 'Livello idrometrico[m]'
							},
							max:6,
							plotLines: [{
								value: 4,
								color: '#FFC020',
								dashStyle: 'shortdash',
								width: 2,
								label: {
									text: 'Soglia arancione'
								}
							}, {
								
								color: '#FF0000',
								dashStyle: 'shortdash',
								width: 2,
								label: {
									text: 'Soglia rossa'
								},
								value: 5
							}]
						},
						series: [{
							name: '<?php echo $r["name"];?>',
							data: data,
							tooltip: {
								valueDecimals: 2
							}
						}]
					});
					});
					</script>
		
		
		
				
		
					<!-- 3. Add the container -->
					<div id="grafico_<?php echo $r["shortcode"];?>" style="width: 80%; height: 400px; margin: 0 auto"></div>
					<hr>		
							
				<?php
				}
				?>		
				
				
				
				
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
