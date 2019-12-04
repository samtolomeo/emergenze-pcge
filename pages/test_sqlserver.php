<?php
/*
echo "Test<br>";
//format: serverName\instanceName, portNumber (default is 1433)
$serverName = "vm-isdb1.comune.genova.it";


$connectionInfo = array( "Database"=>"is_manutenzioni", "UID"=>"emergenze_prtcv", "PWD"=>'$prot_civ1$');
echo "OK<br>";
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Got a connection!<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}*/
?>



<?php 
#################################### 
# PHP error handling for development servers
error_reporting(E_ALL);
ini_set("display_errors", "1"); 
#####################################

// No need to state port number or instance, but in some situations it may be necessary
// To find that query MSSQL: select @@servername + '\' + @@servicename
// For different port do, e.g., 192.168.1.10:9000
$myServer = "vm-isdb1.comune.genova.it";
$myUser = "emergenze_prtcv"; 
$myPass = '$prot_civ1$'; 
$myDB = "is_manutenzioni";

//connection to the database
print "########################</br>mssql_connect:</br>";
$dbhandle = mssql_connect($myServer, $myUser, $myPass) or exit("Couldn't connect to SQL Server: ".mssql_get_last_message());

//output some info from MSSQL
$version = mssql_query('SELECT @@VERSION');
$row = mssql_fetch_array($version);
echo $row[0];
// Clean up
mssql_free_result($version);
?>