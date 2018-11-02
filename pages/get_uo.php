<?php
session_start();


$classe= $_POST["cod"];
echo $classe;


include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';

if(!empty($classe)) {
	if($classe=='comune'){
		$query = "select concat('com_',cod) as cod, descrizione from varie.incarichi_comune order by descrizione;";
	} else if($classe=='esterni') {
		$query = "select concat('uo_',id1) as cod, descrizione from users.uo_1_livello order by descrizione;";
    }
    echo $query;
    $result = pg_query($conn, $query);

     while($r = pg_fetch_assoc($result)) { 
    ?>

        <option name="id_uo" value="<?php echo $r['cod'];?>" ><?php echo $r['descrizione'];?></option>
<?php
    }

	
}
?>