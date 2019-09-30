<?php

        include "../config.php";

        session_start();

        if($_SERVER["REQUEST_METHOD"] == "POST") {

                $stmt = $link->prepare("SELECT * FROM user_movie_list where userID = ? AND movieID = ? AND watched = 1");
                $stmt->bind_param("ss", $_SESSION["id"], $_SESSION["movie"]);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows != 0) {
                        $stm = $link->prepare("DELETE FROM user_movie_list WHERE movieID = ? AND userID = ? AND watched = 1");
                        $stm->bind_param("ss", $_SESSION["movie"], $_SESSION["id"]); 
                        $stm->execute();
                }

                $stmt = $link->prepare("INSERT INTO user_movie_list(userID, movieID, watched, rating, review) VALUES (?, ?, 1, ?, ?)");
                $stmt->bind_param("ssss", $_SESSION["id"], $_SESSION["movie"], $_POST["rating"], $_POST["review"]);
                $stmt->execute();

            header("location: ../mywatched.php");
        }

?>