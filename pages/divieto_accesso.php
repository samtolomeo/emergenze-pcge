<?php 

$subtitle="Utente non accreditato"

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
                    <h1 class="page-header">L'utente non è autorizzato a visualizzare questa pagina</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            
            <br><br>
            <div class="row">
				<i class="fas fa-minus-circle fa-9x"></i>
				<br><br><hr><br>
				<h4 >E' possibile contattare l'amministratore di sistema per ottenere i permessi (<a href="mailto:salaemergenzepc@comune.genova.it?subject=Permessi%20utente%20PC%20">Sala Emergenze PC Genova</a>).</h4>
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
