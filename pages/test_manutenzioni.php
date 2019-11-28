<?php
echo "Inizio call WS Moge";

?>

<script>
/*
var url= "http://apitest.comune.genova.it:28280/MANU_WSManutenzioni_MOGE/";


function Main()
{
  WebServices.SampleWebService.ProcessData();
}

function GeneralEvents_OnWebServiceRequest(Sender, Request, Helper, RequestInfo)
{
  Helper.AddHeader("Authorization", url, "Bearer 10ac7b40-c252-3544-9b5e-301836e485a5");
}*/
</script>


<!DOCTYPE html>
<head>
    <title>SOAP Javascript Test</title>
</head>
<body>
    <script type="text/javascript">
        function soap() {
            var xmlhttp = new XMLHttpRequest();
           
            //replace second argument with the path to your Secret Server webservices
            xmlhttp.open('POST', 'http://wsmanutenzionitest.comune.genova.it/Moge.asmx?WSDL', true);
           
            //create the SOAP request
            //replace username, password (and org + domain, if necessary) with the appropriate info
            var strRequest =
                '<?xml version="1.0" encoding="utf-8"?>' +
                '<soap:Envelope ' +
                    'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"" ' +
                    'xmlns:xsd="http://www.w3.org/2001/XMLSchema"" ' +
                    'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">'; +
                     '<soap:Header>' +
                        '<api:some_api_call soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">' +
                            '<Authorization>Bearer 10ac7b40-c252-3544-9b5e-301836e485a5</Authorization>' +
                            '<Software>test</Authorization>' +
                            '<user>test</Authorization>' +
                            '<Password>test</Authorization>' +
                        '</api:some_api_call>' +
                    '</soap:Header>' +
                    '<soap:Body>' +
                        '<InserisciSegnalazione xmlns="urn:https://apitest.comune.genova.it:28280">' +
                            '<IdTipologiaSegnalazione>7</IdTipologiaSegnalazione>' +
                            '<IdModalitaSegnalazione>6</IdModalitaSegnalazione>' +
                            '<IdSegnalante>21575</IdSegnalante>' +
                            '<Descrizione>test</Descrizione>' +
                            '<IdTipologiaIntervento>21</IdTipologiaIntervento>' +
                            '<Matricola>emergenze</Matricola>' +
                        '</InserisciSegnalazione>' +
                    '</soap:Body>' +
                '</soap:Envelope>';
            //specify request headers
            //xmlhttp.setRequestHeader('Content-Type', 'text/xml; charset=utf-8');
            //xmlhttp.setRequestHeader('Authorization', 'Bearer 10ac7b40-c252-3544-9b5e-301836e485a5');
            xmlhttp.setRequestHeader('Software', 'test');
            xmlhttp.setRequestHeader('User', 'test');				
            xmlhttp.setRequestHeader('Password', 'test');				
            //FOR TESTING: display results in an alert box once the response is received
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4) {
                    alert(xmlhttp.responseText);
                }
            };

            //send the SOAP request
            xmlhttp.send(strRequest);
        };
       
        //build & send the request when the page loads
        window.onload = function() {
            soap();
        };

    </script>
</body>
</html>