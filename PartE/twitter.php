<?php
	session_start();
	include 'config_twitter.php';

	$views = array();

	if (isset($_SESSION["views"])){
		$views = $_SESSION["views"];
	}

	$views = array_unique($views);

	function arrayChange($v1,$v2){
		return $v1 . " " . $v2;
	}

	$post = array_reduce($views, "arrayChange");

	// if $views > 140, then crop to 140
	// if (strlen($post) > 140) {
	// 	$shortPost = substr($post,0,140)
	// }

	$shortPost = (strlen($post) > 140) ? substr($post,0,140) : $post;

	// Post the twitter status update using the short wines_viewed list
	$parameters = array('status' => $shortPost);
	$status = $connection->post('statuses/update', $parameters);

	// Returns the user back to search page
	header('location:search.php');

?>