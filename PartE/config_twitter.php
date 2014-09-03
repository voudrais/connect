<?php
	
	require_once 'twitteroauth.php';

	$consumer_key = "Ph2EWhfPVwp5dtC2aws1J6riO";
	$consumer_secret = "B8I6Aq1uNLObE3O0TEWJItPui1VekF9tk7h0zYeo751Xxv2kln";
	$oauth_token = "2787432578-kKF4sccjsfLWiuhf7AgQEx22wM6KeX9xhPEe4XL";
	$oauth_token_secret = "SKw0vuHq2p4fR8FjfdXxavrEyLoTuWDkkeHGYXk6p8NvI";

	$connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);


?>