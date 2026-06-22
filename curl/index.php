<?php

$url = "https://www.livecoinwatch.com/";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

$result = curl_exec($ch);
preg_match_all('/<div class="lcw-table-container main-table">(.*?)<\/div>/', , matches);

curl_close($ch);


?>

