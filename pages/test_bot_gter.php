<?php

function sendMessage($chatID, $messaggio, $token) {
    echo "sending message to " . $chatID . "\n";

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


require('./token_telegram.php');
$channelp = "";
sendMessage($chatid, "Hello World da PHP siamo troppo fighi su BOT a Roberto privatamente", $token);

echo "<br>";
sendMessage($chatidl, "Ciao Lorenzo Welcome!", $token);

sendMessage($chatid_GTER, "Ciao GTER!", $token);

sendMessage($channel, "Hello World da PHP siamo troppo fighi su canale privato", $token);

echo "<br>";

sendMessage($channelp, "Hello World da PHP siamo troppo fighi su canale pubblico", $token);
?>