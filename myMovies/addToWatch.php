<?php

	include "config.php";

	session_start();

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$stmt = $link->prepare("SELECT * FROM user_movie_list where userID = ? AND movieID = ? AND towatch = 1");
		$stmt->bind_param("ss", $_SESSION["id"], $_POST["movieID"]);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows != 0) {
			header("location: myMovies.php");
			exit;
		}

		$stmt = $link->prepare("INSERT INTO user_movie_list(userID, movieID, towatch) VALUES (?, ?, 1)");
		$stmt->bind_param("ss", $_SESSION["id"], $_POST["movieID"]);
		$stmt->execute();

	    header("location: myMovies.php");
	}

?>