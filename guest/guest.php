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
	        <a href="#">
	          <span>
	          		Welcome!  
	          	<?php
	          		// session_start();
	          		echo "Guest"
	          	?>
	          </span>
	        </a>
	      </li>
	      <li class="menu-iPad">
	        <a href="#">
	          <span>Home</span>
	        </a>
	      </li>
	      <li class="menu-iPhone">
	        <a href="#">
	          <span>To Watch List</span>
	        </a>
	      </li>
	      <li class="menu-iPhone">
	        <a href="#">
	          <span>Watched List</span>
	        </a>
	      </li>
	      
	      
	      <li class="menu-search">
	        <a href="#">
	          <i class="fa fa-search" aria-hidden="true"></i>
	        </a>
	      </li>
	      <li class="menu-support">
	        <a href="../index.php">
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
	      
		   </ul>
	    </div>
	    </div>
	   
	  </div>
	</nav>
	</header>
	<div class="fade-screen"></div>


	<div class="container">

	  <?php

	  	include "guestconfig.php";

	  	if($_SERVER["REQUEST_METHOD"] == "POST") {


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

		    	$row1["avg"] = 10;

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


		        	echo 'Movie</div>
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

						        <form action="">
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

		    	$row1["avg"] = 10;

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

		      
		        	echo 'Movie</div>
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

						        <form action="">
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

