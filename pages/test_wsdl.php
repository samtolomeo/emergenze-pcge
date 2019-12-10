<?php

$wsdl_url= 'http://wsmanutenzionitest.comune.genova.it/Emergenze.asmx?WSDL';
$WSDL     = new SOAP_WSDL($wsdl_url); 
$php      = $WSDL->generateProxyCode();
file_put_contents('wsdl_proxy.php', '<?php ' . $php . ' ?>');

require 'wsdl_proxy.php';

?>