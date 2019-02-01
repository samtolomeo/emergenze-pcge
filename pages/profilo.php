<?php 

$subtitle="Dettagli profilo utente"

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
                    <h1 class="page-header">Dettagli profilo <?php echo $CF; ?>;</h1>
                </div>
				<?php 
					echo "<b>Nome</b>: ". $nome;
					echo "<br><b>Cognome</b>: ". $cognome;
					echo "<br><b>Livello 1</b>: ".$livello1;
					echo "<br><b>Livello 2</b>: ".$livello2;
					echo "<br><b>Livello 3</b>: ".$livello3;
						
					if ($matricola!=''){
						echo "<br><b>Matricola</b>: ". $matricola;
					}
					echo "<br><b>Profilo</b>: ". $descrizione_profilo;
					if ($profilo_nome_munic!=''){
						echo "<br><b>Municipio</b>: ". $profilo_nome_munic;
					}
					echo "<br><b>Squadra</b>: ". $nome_squadra_operatore;
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