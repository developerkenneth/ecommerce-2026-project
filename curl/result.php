<style>

</style>
<?php

    $url = "https://www.livecoinwatch.com/";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $result = curl_exec($ch);
    preg_match_all('/<tbody>(.*?)<\/tbody>/', $result, $matches);
    
    echo $matches[0][0];
    curl_close($ch);


    ?>