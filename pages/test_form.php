<?php 

$subtitle="Sottotitolo"

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
                    <h1 class="page-header">Titolo nuova pagina</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            
            <br><br>
            <div class="row">


<form autocomplete="off" action="report/nuovo_coord.php" method="POST">
		
	
			
			<div class="form-group  ">
				<select id="cf" class="selectpicker show-tick form-control" data-dropup-auto="false" data-live-search="true" required="" name="cf">
				</select>
			</div> 
			
<script>			
/*let dropdown = document.getElementById('cf');
dropdown.length = 0;

let defaultOption = document.createElement('option');
defaultOption.text = 'Seleziona un dipendente';

dropdown.add(defaultOption);
dropdown.selectedIndex = 0;

const url = 'tables/griglia_dipendenti_incarichi.php';

const request = new XMLHttpRequest();
request.open('GET', url, true);

request.onload = function() {
  if (request.status === 200) {
    const data = JSON.parse(request.responseText);
    let option;
    for (let i = 0; i < data.length; i++) {
      option = document.createElement('option');
      option.text = data[i].nome;
      option.value = data[i].matricola;
	  if (i==0){
		alert(option.text);
	  }
      dropdown.add(option);
    }
   } else {
    // Reached the server, but it returned an error
  }   
}

request.onerror = function() {
  console.error('An error occurred fetching the JSON from ' + url);
};

request.send();*/
</script>
			
				<div class="form-group">
						<label for="data_inizio" >Data inizio (AAAA-MM-GG) </label>                 
						<input type="text" class="form-control" name="data_inizio" id="js-date" required>
						<!--div class="input-group-addon" id="js-date" >
							<span class="glyphicon glyphicon-th"></span>
						</div-->
					</div> 
					
					<div class="form-group"-->

                <label for="ora_inizio"> Ora inizio:</label> <font color="red">*</font>

              <div class="form-row">
   
   
    				<div class="form-group col-md-6">
                  <select class="form-control"  name="hh_start" required>
                  <option name="hh_start" value="" > Ora </option>
                    <?php 
                      $start_date = 0;
                      $end_date   = 24;
                      for( $j=$start_date; $j<=$end_date; $j++ ) {
                      	if($j<10) {
                        	echo '<option value="0'.$j.'">0'.$j.'</option>';
                        } else {
                        	echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                      }
                    ?>
                  </select>
                  </div>	
                  
      				<div class="form-group col-md-6">
                  <select class="form-control"  name="mm_start" required>
                  <option name="mm_start" value="00" > 00 </option>
                    <?php 
                      $start_date = 0;
                      $end_date   = 59;
                      $incremento = 15; 
                      for( $j=$start_date; $j<=$end_date; $j+=$incremento) {
                      	if($j<10) {
                        	echo '<option value="0'.$j.'">0'.$j.'</option>';
                        } else {
                        	echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                      }
                    ?>
                  </select>
                  </div>                
                  
                </div>  
                </div>
					
					
					<div class="form-group">
						<label for="data_fine" >Data fine (AAAA-MM-GG) </label>                 
						<input type="text" class="form-control" name="data_fine" id="js-date2" required>
						<!--div class="input-group-addon">
							<span class="glyphicon glyphicon-th"></span>
						</div-->
					</div> 
					
					<div class="form-group"-->

                <label for="ora_inizio"> Ora fine:</label> <font color="red">*</font>

              <div class="form-row">
   
   
    				<div class="form-group col-md-6">
                  <select class="form-control"  name="hh_end" required>
                  <option name="hh_end" value="" > Ora </option>
                    <?php 
                      $start_date = 0;
                      $end_date   = 24;
                      for( $j=$start_date; $j<=$end_date; $j++ ) {
                      	if($j<10) {
                        	echo '<option value="0'.$j.'">0'.$j.'</option>';
                        } else {
                        	echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                      }
                    ?>
                  </select>
                  </div>	
                  
      				<div class="form-group col-md-6">
                  <select class="form-control"  name="mm_end" required>
                  <option name="mm_end" value="00" > 00 </option>
                    <?php 
                      $start_date = 59;
                      $end_date   = 59;
                      $incremento = 15;
                      for( $j=$start_date; $j<=$end_date; $j+=$incremento ) {
                      	if($j<10) {
                        	echo '<option value="0'.$j.'">0'.$j.'</option>';
                        } else {
                        	echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                      }
                    ?>
                  </select>
                  </div>                
                  
                </div>  
                </div>
		           
                  



        <button  id="conferma" type="submit" class="btn btn-primary">Inserisci coordinatore sala</button>
            </form>







            </div>
            <!-- /.row -->
    </div>
    <!-- /#wrapper -->

<?php 

require('./footer.php');

require('./req_bottom.php');


?>

<script>
let dropdown = $('#cf');

dropdown.empty();

dropdown.append('<option selected="true" disabled>Scegli un dipendente</option>');
dropdown.prop('selectedIndex', 0);

const url = './tables/griglia_dipendenti_incarichi.php';

// Populate dropdown with list of provinces
$.getJSON(url, function (data) {
  $.each(data, function (key, entry) {
    dropdown.append($('<option></option>').attr('value', entry.matricola).text(entry.nome));
  })
});


dropdown.selectpicker('refresh');


$(document).ready(function() {
    $('#js-date').datepicker({
        format: "yyyy-mm-dd",
        clearBtn: true,
        autoclose: true,
        todayHighlight: true
    });
});

$(document).ready(function() {
    $('#js-date2').datepicker({
        format: "yyyy-mm-dd",
        clearBtn: true,
        autoclose: true,
        todayHighlight: true
    });
});
$(document).ready(function() {
    $('#cf').selectpicker('refresh');
});


/*(function ($) {
		'use strict';
		alert('refresh');
		$('#cf').selectpicker('refresh');
	//$('#via-list').selectpicker('refresh');
}(jQuery));*/

</script>
    

</body>

</html>
