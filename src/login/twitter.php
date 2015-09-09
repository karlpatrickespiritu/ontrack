<?php

//open connection
$ch = curl_init();

$sFields = 'POST&https%3A%2F%2Fapi.twitter.com%2Foauth%2Frequest_token&oauth_consumer_key%3DqziqppX1DevJ5BtYYFTrBAcdR%26oauth_nonce%3D25db31020f54be347279e517cce22fbe%26oauth_signature_method%3DHMAC-SHA1%26oauth_timestamp%3D1441773023%26oauth_token%3D1570030916-Rau5BIZQG6VcNkngrl74ecWynehfa2tFPFjwiZz%26oauth_version%3D1.0';

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, "https://api.twitter.com/oauth/request_token");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $sFields);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);

var_dump($result); exit;

/*
OAuth oauth_nonce="K7ny27JTpKVsTgdyLdDfmQQWVLERj2zAK5BslRsqyw",
oauth_callback="http%3A%2F%2Fmyapp.com%3A3005%2Ftwitter%2Fprocess_callback",
oauth_signature_method="HMAC-SHA1",
oauth_timestamp="1300228849",
oauth_consumer_key="OqEqJeafRSF11jBMStrZz",
oauth_signature="Pc%2BMLdv028fxCErFyi8KXFM%2BddU%3D",
oauth_version="1.0"*/