<?php



//$soapClient = new SoapClient("http://wsmanutenzionitest.comune.genova.it/Emergenze.asmx?WSDL");
//$params = array('text' => 'ciao mondo');
//$result = $soapClient->__call("echo", array($params));





$wsdl = "http://wsmanutenzionitest.comune.genova.it/Emergenze.asmx?WSDL";
//$client = new SoapClient($wsdl, array('trace' => 1));  // The trace param will show you errors stack

#$wsdl = "http://apitest.comune.genova.it:28280/MANU_WSManutenzioni_MOGE/";


echo "URL definito: " . $wsdl;

// create bearer token Authorization header
$token = "10ac7b40-c252-3544-9b5e-301836e485a5";

/*$options['stream_context'] = stream_context_create([
    'http' => [
        'header' => sprintf('Authorization: Bearer %s', $token)
    ]
]);*/


/*
$options['stream_context'] = stream_context_create([
    'http' => [
        'header' => sprintf('Authorization: Bearer %s', $token)
    ]
]);


echo "<br>TOKEN definito";
// create client and get cms block response
$client = new SoapClient($wsdl, $options);
*/

$httpHeaders = array(
            'http'=>array(
            'header' => "Authorization:Bearer ".$token."\r\n"
            ));


$context = stream_context_create($httpHeaders);

    $soapparams = array(                    
                                            'stream_context' => $context,

                            );
							
							
echo "<br>TOKEN 2 correttamente definito";

echo "<br><br>Ora provo a definire il client:";
$client = new SoapClient($wsdl, $soapparams);



echo "<br>Client definito";
/*
$opts = [
  'http'=> [
	  'header' => 'Authorization: Bearer ' . $token
  ]
];

$context = stream_context_create($opts);

$client = new SoapClient($wsdl, array(
  'stream_context' => $context
));
*/


// form an array listing the http header
/*$access_token = "10ac7b40-c252-3544-9b5e-301836e485a5";
$httpHeaders = array(
    'http' => array(
        'protocol_version' => 1.1,
        'header' => "Authorization:Bearer " . $access_token . "\r\n",
    ));
// form a stream context
$context = stream_context_create($httpHeaders);
// pass it in an array
$hparams = array('stream_context' => $context);
*/

//$client = new SoapClient($wsdl);








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

//$result = $soapClient->__soapCall ("InserimentoSegnalazione",$params);

$responce_param = null;
try {
    $responce_param = $client->InserimentoSegnalazione($params);
	echo "<br> Esito: ";
	print_r($responce_param->InserimentoSegnalazioneResult->Esito);
	echo "<br> Id della segnalazione inserita a sistema: ";
    print_r($responce_param->InserimentoSegnalazioneResult->IdSegnalazione);
} catch (Exception $e) {
    echo "<h2>Exception Error!</h2>";
    echo $e->getMessage();
}

echo "<br>";

echo "<br>";
#echo $params;
echo "<br>";
echo "<br>";

//result=client.service.InserimentoSegnalazione(manutenzioneSegnalazioneInput, autenticazione)


//$wsdl_url= 'http://wsmanutenzionitest.comune.genova.it/Emergenze.asmx?WSDL';
//$WSDL     = new SOAP_WSDL($wsdl_url); 
//$php      = $WSDL->generateProxyCode();

//require 'wsdl_proxy.php';

?>