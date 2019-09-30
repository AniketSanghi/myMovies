<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}
?>

<html>
<head>
	<title> myMovies </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300i,400" rel="stylesheet">
	<link rel="stylesheet" href="./menu_bar.css">

	<!-- <link rel="stylesheet" type="text/css" href="myMovies.css"> -->
	<script src="//use.typekit.net/xyl8bgh.js"></script>
	<script>try{Typekit.load();}catch(e){}</script>
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->
	<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="./myMovies.css">


</head>
<body>

	<header>
	<nav>
	  <div class="menu-container">
	    <!-- Menu -->
	    <ul class="menu">
	      <li class="menu-mac">
	        <a href="./myMovies.php">
	          <span>
	          		Welcome!  
	          	<?php
	          		// session_start();
	          		echo $_SESSION["fullname"];
	          	?>
	          </span>
	        </a>
	      </li>
	      <li class="menu-iPad">
	        <a href="./myMovies.php">
	          <span>Home</span>
	        </a>
	      </li>
	      <li class="menu-iPhone">
	        <a href="./mytowatch.php">
	          <span>To Watch List</span>
	        </a>
	      </li>
	      <li class="menu-iPhone">
	        <a href="./mywatched.php">
	          <span>Watched List</span>
	        </a>
	      </li>
	      
	      
	      <li class="menu-search">
	        <a href="#">
	          <i class="fa fa-search" aria-hidden="true"></i>
	        </a>
	      </li>
	      <li class="menu-support">
	        <a href="../logout.php">
	          <span>Log Out</span>
	        </a>
	      </li>
	    </ul>
	    
	    <!-- Search -->
	    <div class="menu-search-container">
	      <div class="menu-search-input">
	      <form action="" method="post">
	        <a href="#">
	          <i class="fa fa-search" aria-hidden="true"></i>
	        </a>
	        <input class="menu-search-input" name = "search" type="text" aria-label="Search apple.com" placeholder="Search any keyword" autocorrect="off" autocapitalize="off" autocomplete="on" spellcheck="false">
	      </form>
	      </div>
	      <a class="menu-search-close" href="#">
	        <i class="fa fa-close" aria-hidden="true"></i>
	      </a> 
	      <div class="search-sub-menu">
	      <h3>Recently Searched for</h3>
	      <ul>
	      <?php
	      		include "config.php";

	      		$stmt = $link->prepare("SELECT search FROM user_search_history WHERE userID = ? ORDER BY id DESC LIMIT 5");
	      		$stmt->bind_param("s", $_SESSION["id"]);
		    	$stmt->execute();
		    	$result = $stmt->get_result();

		    	while($row = $result->fetch_assoc()) {
		    		echo '<li><a href="#">'.$row["search"].'</a></li>';
		    	}
		      
		   ?>
		   </ul>
	    </div>
	    </div>
	   
	  </div>
	</nav>
	</header>
	<div class="fade-screen"></div>


	<div class="container">

	  <?php

	  	include "config.php";

	  	if($_SERVER["REQUEST_METHOD"] == "POST") {

	  		$temp = $link->prepare("INSERT INTO user_search_history(userID, search) VALUES (?, ?)");
	  		$temp->bind_param("ss", $_SESSION["id"], $_POST["search"]);
	  		$temp->execute();

	  		$temp = $link->prepare("SELECT * FROM user_search_history where userID = ?");
	  		$temp->bind_param("s", $_SESSION["id"]);
	  		$temp->execute();
	  		$result_temp = $temp->get_result();
	  		if($result_temp->num_rows == 6) {
	  			$temp0 = $link->prepare("DELETE FROM user_search_history where userID = ? LIMIT 1");
	  			$temp0->bind_param("s", $_SESSION["id"]);
	  			$temp0->execute();
	  		}


	  		$stmt0 = $link->prepare("SELECT * from genre where genre=?");
	  		$stmt0->bind_param("s", $_POST["search"]);
	  		$stmt0->execute();
	  		$result0 = $stmt0->get_result();

	  		if($result0->num_rows == 0) {
	  			$stmt = $link->prepare("SELECT * FROM movies WHERE title=? OR releaseYear=? OR maleActor=? OR femaleActor=? OR Director=?");
	  			$stmt->bind_param("sssss", $_POST["search"], $_POST["search"], $_POST["search"], $_POST["search"], $_POST["search"]);
		    	$stmt->execute();
		    	$result = $stmt->get_result();
	  		}
	  		else {
	  			$row0 = $result0->fetch_assoc();
	  			$sql3 = "SELECT * from movies JOIN movie_genre ON movies.movieID = movie_genre.movieID WHERE genreID=".$row0["genreID"];
	  			
	  			$result = $link->query($sql3);
	  		}

	  		
	  		
		    
		    while($row = $result->fetch_assoc()) {

		    	$st1 = $link->prepare("SELECT ROUND(AVG(rating), 1) AS avg from user_movie_list WHERE watched = '1' AND movieID = ? ");
		    	$st1->bind_param("s", $row["movieID"]);
		    	$st1->execute();
		    	$result1 = $st1->get_result();
		    	if($result1->num_rows == 0) $row1["avg"] = 10;
		    	else $row1 = $result1->fetch_assoc();
		    	if($row1["avg"] == NULL) $row1["avg"] = 10;

		    	$sql2 = "SELECT g.genre FROM genre as g join movie_genre as m on m.genreID = g.genreID where movieID = ".$row["movieID"];
		    	
		    	$result2 = $link->query($sql2);

		    	echo '<div class="column">
		    			<div class="post-module">
		      				<div class="thumbnail">
		        				<div class="date">
		          					<div class="day">Rating</div>
		          					<div class="month">'.$row1["avg"].'/10</div>
		        				</div><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/photo-1429043794791-eb8f26f44081.jpeg"/>
		      				</div>
		      				<div class="post-content">
		        				<div class="category">';

		        	$std = $link->prepare("SELECT * from user_movie_list where userID = ? AND movieID = ?");
		        	$temporary = "Movie";
		        	$std->bind_param("ss", $_SESSION["id"], $row["movieID"]);
		        	$std->execute();
		        	$res = $std->get_result();
		        	if($res->num_rows != 0) {
		        		$newrow = $res->fetch_assoc();
		        		if($newrow["towatch"] == 1) $temporary = "To Watch";
		        		else if($newrow["watched"] == 1) $temporary = "Watched";
		        	}


		        	echo $temporary.'</div>
		        				<h1 class="title">'.$row["title"].' ('.$row["releaseYear"].')</h1>
		        				<h2 class="sub_title">';
		 
		        		if($row2 = $result2->fetch_assoc()) echo $row2["genre"];
		        		while($row2 = $result2->fetch_assoc()) {
		        			echo ' | '.$row2["genre"];
		        		}

		       			echo 	'</h2>
						        <p class="description">
						        	<b>Director: </b> <i>'.$row["Director"].'</i><br> 
						        	<b>Cast: </b> <i>'.$row["maleActor"].','.$row["femaleActor"].'</i><br> 
						        	'.$row["description"].'
						        </p>
						        <div class="post-meta">

						        <form action="delete.php" method="post">
						        	<input type="hidden" name="movieID" value="'.$row["movieID"].'">
						        	<input type="submit" value="Delete">
						        </form>

						        </div>
						      </div>
						    </div>
						  </div>';

		    }

	  	}
	  	else {
	  		$stmt = $link->prepare("SELECT * FROM movies");
		    $stmt->execute();
		    $result = $stmt->get_result();
		    
		    while($row = $result->fetch_assoc()) {

		    	$st1 = $link->prepare("SELECT ROUND(AVG(rating), 1) AS avg from user_movie_list WHERE watched = '1' AND movieID = ? ");
		    	$st1->bind_param("s", $row["movieID"]);
		    	$st1->execute();
		    	$result1 = $st1->get_result();
		    	if($result1->num_rows == 0) $row1["avg"] = 10;
		    	else $row1 = $result1->fetch_assoc();
		    	if($row1["avg"] == NULL) $row1["avg"] = 10;

		    	$sql2 = "SELECT g.genre FROM genre as g join movie_genre as m on m.genreID = g.genreID where movieID = ".$row["movieID"];
		    	
		    	$result2 = $link->query($sql2);

		    	echo '<div class="column">
		    			<div class="post-module">
		      				<div class="thumbnail">
		        				<div class="date">
		          					<div class="day">Rating</div>
		          					<div class="month">'.$row1["avg"].'/10</div>
		        				</div><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/photo-1429043794791-eb8f26f44081.jpeg"/>
		      				</div>
		      				<div class="post-content">
		        				<div class="category">';

		        	$std = $link->prepare("SELECT * from user_movie_list where userID = ? AND movieID = ?");
		        	$temporary = "Movie";
		        	$std->bind_param("ss", $_SESSION["id"], $row["movieID"]);
		        	$std->execute();
		        	$res = $std->get_result();
		        	if($res->num_rows != 0) {
		        		$newrow = $res->fetch_assoc();
		        		if($newrow["towatch"] == 1) $temporary = "To Watch";
		        		else if($newrow["watched"] == 1) $temporary = "Watched";
		        	}


		        	echo $temporary.'</div>
		        				<h1 class="title">'.$row["title"].' ('.$row["releaseYear"].')</h1>
		        				<h2 class="sub_title">';
		 
		        		if($row2 = $result2->fetch_assoc()) echo $row2["genre"];
		        		while($row2 = $result2->fetch_assoc()) {
		        			echo ' | '.$row2["genre"];
		        		}

		       			echo 	'</h2>
						        <p class="description">
						        	<b>Director: </b> <i>'.$row["Director"].'</i><br> 
						        	<b>Cast: </b> <i>'.$row["maleActor"].','.$row["femaleActor"].'</i><br> 
						        	'.$row["description"].'
						        </p>
						        <div class="post-meta">

						        <form action="addToWatch.php" method="post">
						        	<input type="hidden" name="movieID" value="'.$row["movieID"].'">
						        	<input type="submit" value="Add To Watch List">
						        </form>

						        </div>
						      </div>
						    </div>
						  </div>';

		    }
	  	}
	    
	  ?>
	  
	</div>

	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src='http://codepen.io/andytran/pen/vLmRVp.js'></script>
	<script  src="./myMovies.js"></script>

	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
	<script  src="./script.js"></script>
</body>
</html>

