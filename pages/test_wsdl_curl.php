<?php
echo "OK test";
$Descrizione ='test descrizione php';
$IdManufatto ='44384';
$CodViaDa = '63760';
$CivicoDa ='0104';
$ColoreDa ='R';

$token = "10ac7b40-c252-3544-9b5e-301836e485a5";

#$wsdl = "http://wsmanutenzionitest.comune.genova.it/Emergenze.asmx?WSDL";
$wsdl = "http://apitest.comune.genova.it:28280/MANU_WSManutenzioni_MOGE";

// xml post structure
$xml_post_string = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:goad="http://goadev.com/">
   <soap:Header/>
   <soap:Body>
      <goad:InserimentoSegnalazione>
         <!--Optional:-->
         <goad:manutenzioneSegnalazioneInput>
            <goad:IdTipologiaSegnalazione>7</goad:IdTipologiaSegnalazione>
            <goad:IdModalitaSegnalazione>6</goad:IdModalitaSegnalazione>
            <goad:IdSegnalante>21575</goad:IdSegnalante>
            <goad:IdManufatto>'.$IdManufatto.'</goad:IdManufatto>
            <!--Optional:-->
            <goad:Descrizione>'.$Descrizione.'</goad:Descrizione>
            <goad:IdTipologiaIntervento>21</goad:IdTipologiaIntervento>
            <!--Optional:-->
            <goad:Matricola>emergenze</goad:Matricola>
            <goad:CodViaDa>'.$CodViaDa.'</goad:CodViaDa>
            <!--Optional:-->
            <goad:CivicoDa>'.$CivicoDa.'</goad:CivicoDa>
            <!--Optional:-->
            <goad:ColoreDa>'.$ColoreDa.'</goad:ColoreDa>
            <!--Optional:-->
            <!--goad:LetteraDa>?</goad:LetteraDa-->
         </goad:manutenzioneSegnalazioneInput>
         <!--Optional:-->
         <goad:autenticazione>
            <!--Optional:-->
            <goad:Software>test</goad:Software>
            <!--Optional:-->
            <goad:User>test</goad:User>
            <!--Optional:-->
            <goad:Password>test</goad:Password>
         </goad:autenticazione>
      </goad:InserimentoSegnalazione>
   </soap:Body>
</soap:Envelope>';

$headers = array(
    "Content-type: text/xml;",
    "Authorization: Bearer ".$token.""
);

// PHP cURL  for https connection with auth
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_URL, $wsdl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request


// converting
$response = curl_exec($ch);

echo "<br>";
echo "Dati XML:" .$xml_post_string;

echo "<br>";
echo $response;
echo "<br>";


echo "<br>";
echo "OK test";
//result=client.service.InserimentoSegnalazione(manutenzioneSegnalazioneInput, autenticazione)


//$wsdl_url= 'http://wsmanutenzionitest.comune.genova.it/Emergenze.asmx?WSDL';
//$WSDL     = new SOAP_WSDL($wsdl_url); 
//$php      = $WSDL->generateProxyCode();

//require 'wsdl_proxy.php';

?>