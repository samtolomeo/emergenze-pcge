<?php


echo "Step 0 <br>";
//$soapClient = new SoapClient("http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL");
//$params = array('text' => 'ciao mondo');
//$result = $soapClient->__call("echo", array($params));

$wsdl = "http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL";
$client = new SoapClient($wsdl, array('trace' => 1));  // The trace param will show you errors stack



echo "step 1<br>";

$params = array('sCountryName' => 'Italy');
echo "step 2<br>";


$responce_param = null;
try {
    $responce_param = $client->CountryISOCode($params);
	echo "Ho avuto una risposta anche se non so ancora quale<br>";
	//echo $responce_param;
    print_r($responce_param->CountryISOCodeResult);
echo "<br>";
} catch (Exception $e) {
    echo "<h2>Exception Error!</h2>";
    echo $e->getMessage();
}




$request_param = array('sCountryISOCode' => 'IT');
$responce_param = null;
try {
    $responce_param = $client->CountryCurrency($request_param);

    print_r($responce_param->CountryCurrencyResult->sISOCode);
} catch (Exception $e) {
    echo "<h2>Exception Error!</h2>";
    echo $e->getMessage();
}
echo "<br>";
#$result = $soapClient->__soapCall ("CountryISOCode",$params);
echo "OK test";
echo "<br>";
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