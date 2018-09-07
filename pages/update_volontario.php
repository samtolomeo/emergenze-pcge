<?php 

$subtitle="Dettagli volontario"

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

$cf=$_GET["id"];

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
                 
                    <h1 class="page-header"> <i class="fa fa-user"></i> Dettagli volontario
                    
                    <?php
                        $query="SELECT * From \"users\".\"v_personale_volontario\" where \"cf\"=$cf;"; 
                    
                    $result = pg_query($conn, $query);
	                //$rows = array();
	                //echo $result;
	                while($r = pg_fetch_assoc($result)) {
                    		//$rows[] = $r;
                    		echo $r['cognome']. " ".$r['nome'];
    		        ?>
                    
                    </h1>
                </div>


            
            <br><br>
            <div class="row">
              <div class="col-lg-3 col-md-auto">

			<!--b>MATRICOLA</b>: <?php echo $r['matricola'] ?>  <br>
		
			<br-->
            <h4> <i class="fa fa-address-book"></i> Informazioni anagrafiche 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_ana"> 
				     <i class="fa fa-pencil-alt"></i>        
            </button>
            </h4>
            <b>Cognome e nome</b>: <?php echo $r['cognome']. " ".$r['nome']  ?>  <br>
            <b>Codice fiscale</b>: <?php echo $r['cf'] ?>  <br>
            <b>Data di nascita</b>: <?php echo $r['data_nascita'] ?>  <br>   
            <b>Nazionalità:</b> <?php echo $r['nazione_nascita'] ?> <br>


  



<!-- Modal -->
<div id="modal_ana" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit anagrafica volontario</h4>
      </div>
      <div class="modal-body">
      

        <form action="update_v/anagrafica.php?id='<?php echo $r['cf']?>'" method="POST">

              <div class="form-group">
                <label for="cognome"> Cognome</label> *
                <input type="text" value='<?php echo $r['cognome']?>' name="cognome" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="nome"> Nome</label> *
                <input type="text" value='<?php echo $r['nome']?>' name="nome" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="cf"> CF</label> *
                <input type="text" pattern=".{16,16}" maxlenght="16" value='<?php echo $r['cf']?>' name="cf" class="form-control" required>
              </div>           
              <div class="form-group">
                <label for="data_nascita">Data di nascita</label> *
                <input type="text" name="data_nascita" value='<?php echo $r['data_nascita']?>' class="form-control" required>
              </div>            
              <div class="form-group">
                <label for="nazione_nascita">Nazione di nascita</label> *
                <input type="text" name="nazione_nascita" value='<?php echo $r['nazione_nascita']?>' class="form-control" required>
              </div>    
              
            <button type="submit" class="btn btn-primary">Aggiorna</button>
            </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
      </div>
    </div>

  </div>
</div>            




			</div><div class="col-lg-3 col-md-auto">

         
            <h4> <i class="fa fa-home"></i> Residenza
             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_res"> 
				     <i class="fa fa-pencil-alt"></i>        
            </button>
            </h4>
				<b>Indirizzo</b>: <?php echo $r['indirizzo'] ?><br>				
				&emsp;&emsp;&emsp;&emsp;&emsp;<?php echo $r['cap']." - ". $r['comune']. " (".$r['provincia']  ?>)<br>
           

<!-- Modal -->
<div id="modal_res" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit residenza</h4>
      </div>
      <div class="modal-body">
      

        <form action="update_v/indirizzo.php?id='<?php echo $r['cf']?>'" method="POST">

              <div class="form-group">
                <label for="indirizzo"> Indirizzo</label> *
                <input type="indirizzo" value='<?php echo $r['indirizzo']?>' name="indirizzo" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="cap"> cap</label>
                <input type="text" value='<?php echo $r['cap']?>' name="cap" class="form-control">
              </div>
              
              
            <button type="submit" class="btn btn-primary">Aggiorna indirizzo</button>
            </form>


            <form action="update_v/comune.php?id='<?php echo $r['cf']?>'" method="POST">            
            <br><br>
            <b>Comune:</b> <?php echo $r['comune']." (" .$r['provincia']. ")" ?>


				
		<label for="cat" class="auto-length">
			<input type="checkbox" name="cat" id="cat">
			Modificare comune 
		</label>
		
		            <br><br>


	
	<!--div class="form-group">
              <label for="naz">Comune residenza:</label> <font color="red">*</font>
                            <select class="form-control" name="naz" id="naz">
                            <option name="naz" value="" > Scegli un comune..</option>
            <?php            
            $query2="SELECT * From \"varie\".\"comuni_italia\";";
	        $result2 = pg_query($conn, $query2);
            //echo $query1;    
            while($r2 = pg_fetch_assoc($result2)) { 
            ?>    
                    <option name="naz" value="<?php echo $r2['Denominazione in italiano'];?>" ><?php echo $r2['Denominazione in italiano'];?></option>
             <?php } ?>

             </select>            
             </div-->


              
                
                           

            <script>
            function getCivico(val) {
	            $.ajax({
	            type: "POST",
	            url: "get_comune.php",
	            data:'cod='+val,
	            success: function(data){
		            $("#comune-list").html(data);
	            }
	            });
            }

            </script>



             <div class="form-group">
              <label for="provincia">Provincia:</label> <font color="red">*</font>
                            <select disabled="" name="provincia" id="provincia-list" class="selectpicker show-tick form-control" data-live-search="true" onChange="getCivico(this.value);" required>
                            <option value="">Seleziona la provincia</option>
            <?php            
            $query2="SELECT * From \"varie\".\"province\";";
	        $result2 = pg_query($conn, $query2);
            //echo $query1;    
            while($r2 = pg_fetch_assoc($result2)) { 
                $valore=  $r2['cod']. ";".$r2['nome'];            
            ?>
                        
                    <option name="cod" value="<?php echo $r2['cod'];?>" ><?php echo $r2['nome'];?></option>
             <?php } ?>

             </select>            
             </div>


            <div class="form-group">
              <label for="comune">Comune:</label> <font color="red">*</font>
                <select disabled="" class="form-control" name="comune" id="comune-list" class="demoInputBox" required>
                <option value="">Seleziona il comune</option>
            </select>         
             </div>           


          
       
 


         
              
              
            <button disabled="" type="submit" class="btn btn-primary" id="btn_comune">Aggiorna comune</button>
            </form>
            

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
      </div>
    </div>

  </div>
</div> 









				</div><div class="col-lg-3 col-md-auto">
				<h4> <i class="fa fa-phone"></i> Contatti
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_con"> 
				     <i class="fa fa-pencil-alt"></i>        
            </button>
            </h4>
				<b>Telefono principale</b>: <?php echo $r['telefono1']?><br>
            <b>Mail</b>: <?php echo $r['mail'] ?>  <br>
            <b>Telefono secondario</b>: <?php echo $r['telefono2'] ?>  <br>   
            <b>Fax:</b> <?php echo $r['fax'] ?> <br>
				
				


<!-- Modal -->
<div id="modal_con" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit contatto volontario</h4>
      </div>
      <div class="modal-body">
      

        <form action="update_v/contatti.php?id='<?php echo $r['cf']?>'" method="POST">

              <div class="form-group">
                <label for="telefono1"> Telefono principale</label> *
                <input type="text" value='<?php echo $r['telefono1']?>' name="telefono1" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="mail"> Mail</label> *
                <input type="email" value='<?php echo $r['mail']?>' name="mail" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="telefono2"> Telefono secondario</label>
                <input type="text" value='<?php echo $r['telefono2']?>' name="telefono2" class="form-control">
              </div>           
              <div class="form-group">
                <label for="fax">Fax</label>
                <input type="text" name="fax" value='<?php echo $r['fax']?>' class="form-control">
              </div>            
                
              
            <button type="submit" class="btn btn-primary">Aggiorna</button>
            </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
      </div>
    </div>

  </div>
</div>    				
				
				
				
				
				
				
				
				</div><div class="col-lg-3 col-md-auto">
				<h4> <i class="fa fa-plus"></i> Altro</h4>
				<b>N° Gruppo Genova</b>: <?php echo $r['numero_gg']?><br>
				Gli ulteriori campi sono da modificare in seguito alla riunione del 10 dicembre in cui parleremo anche di come organizzare le Unità Operative <br>
            <b>UO I livello (todo)</b>: <?php echo $r['id1'] ?>  <br>
            <b>UO II livello (todo)</b>: <?php echo $r['id2'] ?>  <br>   
            <b>UO III livello (todo)</b>: <?php echo $r['id3'] ?> <br>
            </div>
            
            
            <<?php } #chiudo il while ?>
            <!-- /.row -->
    </div>
    <!-- /#wrapper -->
    <br><br><br><br><br>
<?php 

require('./footer.php');

require('./req_bottom.php');


?>

<script>

(function ($) {
    'use strict';
    
    $('[type="checkbox"').on('change', function () {
        if ($(this).is(':checked')) {
            $('#catName').removeAttr('disabled');
            $('#provincia-list').removeAttr('disabled');
            $('#comune-list').removeAttr('disabled');
            $('#btn_comune').removeAttr('disabled');
            return true;
        }
        $('#catName').attr('disabled', 'disabled');
    });
    
}(jQuery));    

</script>  
    

</body>

</html>
