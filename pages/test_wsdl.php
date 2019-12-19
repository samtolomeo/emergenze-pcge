<?php



$soapClient = new SoapClient("http://wsmanutenzionitest.comune.genova.it/Emergenze.asmx?WSDL");
//$params = array('text' => 'ciao mondo');
//$result = $soapClient->__call("echo", array($params));



$manutenzioneSegnalazioneInput=array(
    'IdTipologiaSegnalazione' =>7,
    'IdModalitaSegnalazione' =>6,
    'IdSegnalante' =>21575,
    'Descrizione' =>'test descrizione python',
    'IdTipologiaIntervento' =>21,
    'Matricola' =>'emergenze',
    'IdManufatto' =>44384,
    'CodViaDa' =>63760,
    'CivicoDa' =>'0104',
    'ColoreDa' =>'R'
);

$autenticazione=array(
'Software' =>'test',
'User' =>'test',
'Password' =>'test'
);

$params = array('manutenzioneSegnalazioneInput' => $manutenzioneSegnalazioneInput,
'autenticazione'  =>$autenticazione
);

$result = $soapClient->__soapCall ("InserimentoSegnalazione",$params);
echo "OK test";
echo "<br>";
echo $params;
echo "<br>";
echo $result;

echo "<br>";
echo "OK test";
//result=client.service.InserimentoSegnalazione(manutenzioneSegnalazioneInput, autenticazione)


//$wsdl_url= 'http://wsmanutenzionitest.comune.genova.it/Emergenze.asmx?WSDL';
//$WSDL     = new SOAP_WSDL($wsdl_url); 
//$php      = $WSDL->generateProxyCode();

//require 'wsdl_proxy.php';

?>