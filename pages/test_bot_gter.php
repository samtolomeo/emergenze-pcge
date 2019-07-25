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


$token = "842531800:AAFgJzJAYvWdXGgRNpVr0sUOEKpBMj2WPPA";
$chatid = "708309739";
sendMessage($chatid, "Hello World da PHP siamo troppo fighi", $token);
?>