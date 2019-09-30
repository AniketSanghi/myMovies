<?php

	include "config.php";

	session_start();

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$stmt = $link->prepare("DELETE FROM user_movie_list WHERE movieID = ? AND userID = ? AND towatch = 1");
	    $stmt->bind_param("ss", $_POST["movieID"], $_SESSION["id"]); 
	    $stmt->execute();

	    header("location: mytowatch.php");
	}

?>