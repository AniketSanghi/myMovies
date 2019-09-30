<?php
	include "../config.php";

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		// Prepare an insert statement
        $sql = "INSERT INTO movies (title, releaseYear, maleActor, femaleActor, Director, description) VALUES (?, ?, ?, ?, ?, ?)";
         
        $stmt = $link->prepare($sql);
		$stmt->bind_param('ssssss', $_POST["title"], $_POST["year"], $_POST["male_actor"], $_POST["female_actor"], $_POST["director"], $_POST["description"]);
		$stmt->execute();

        $movieID = $link->insert_id;

        // Retrieving each selected option 
        foreach ($_POST['genre'] as $subject) {
        	
        	$sql = "INSERT INTO movie_genre(movieID, genreID) VALUES (?, ?)";

        	$stmt = $link->prepare($sql);
			$stmt->bind_param('ss', $movieID, $subject);
			$stmt->execute();
        }
            
        header("location: ../admin_account/myMovies.php");
        mysql_close($link);
        
	}
?>