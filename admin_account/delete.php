<?php

	include "../config.php";

	session_start();

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$stmt = $link->prepare("DELETE FROM movies WHERE movieID = ?");
	    $stmt->bind_param("s", $_POST["movieID"]); 
	    $stmt->execute();

	    $stmt = $link->prepare("DELETE FROM movie_genre WHERE movieID = ?");
	    $stmt->bind_param("s", $_POST["movieID"]); 
	    $stmt->execute();

	    $stmt = $link->prepare("DELETE FROM user_movie_list WHERE movieID = ?");
	    $stmt->bind_param("s", $_POST["movieID"]); 
	    $stmt->execute();

	    header("location: myMovies.php");
	}

?>